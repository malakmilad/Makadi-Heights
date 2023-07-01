<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Rate;
use App\Models\User;
use Illuminate\Http\Request;
use App\Mail\PaymentLink;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;
use App\Exports\PaymentsExport;
use Maatwebsite\Excel\Facades\Excel;
use Dompdf\Dompdf;
use Dompdf\Options;

use PDF;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payments = Payment::getPayments();
        $count = count($payments);

        return view('payments.index', compact('payments', 'count'));
    }

    public function searchPayments(Request $request)
    {
        $payments = Payment::with(['user']);

        if ($request->get('id')) {
            $payments->where('id', $request->id);
        }

        if ($request->get('unit_unique_reference')) {
            $payments->where('unit_unique_reference', $request->unit_unique_reference);
        }

        if ($request->get('personal_id')) {
            $payments->where('personal_id', $request->personal_id);
        }

        if ($request->get('date_from') || $request->get('date_to')) {
            $payments->whereBetween('created_at', [
                $request->date_from . ' 00:00:00',
                $request->date_to . ' 23:59:59',
            ]);
        }

        $payments = $payments->orderBy('created_at', 'DESC')->paginate(15);
        $count = count($payments);

        return view('payments.index', compact('payments', 'count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::where('email', '!=', 'super-admin@makadi-heights.com')->get();
        return view('payments.create', compact('users'));
    }

    public function searchUnitUniqueReferencePage()
    {
        return view('payments.unit-search');
    }

    public function searchUnitUniqueReference(Request $request)
    {
        $validated = $request->validate([
            'unit_unique_reference' => 'required'
        ]);

        $payment = Payment::where('unit_unique_reference',$request->unit_unique_reference)->latest()->first();

        if ($payment) {
            if ($payment->status == 0 || $payment->status == 1) {
                return redirect()
                // ->route('payments.create')
                ->back()
                ->with('status', 'There is a payment with this unit unique reference pending, please wait till the owner responds')
                ->with('url', route('payments.show',$payment->id));
            }
            else {
                return redirect()
                ->route('payments.show',[
                    'id' => $payment->id,
                    'add_payments' => 1
                ]);
                // ->route('payments.create',
                // [
                //     'first_name'=> $payment->first_name,
                //     'last_name'=> $payment->last_name,
                //     'mobile'=> $payment->mobile,
                //     'email'=> $payment->email,
                //     'personal_id'=> $payment->personal_id,
                //     'unit_unique_reference'=> $payment->unit_unique_reference,
                //     'total_unit_price'=> $payment->total_unit_price,
                //     'valid_hours'=> $payment->valid_hours,
                //     'zone'=> $payment->zone,
                //     'building_type'=> $payment->building_type,
                //     'city'=> $payment->city,
                //     'country'=> $payment->country,
                //     'building_type_id'=> $payment->building_type_id,
                //     'building_type'=> $payment->building_type,
                //     'currency_id'=> $payment->currency_id,
                //     'address_line_1'=> $payment->address_line_1,
                //     'address_line_2'=> $payment->address_line_2,
                //     // 'city'=> $payment->city,
                // ]);
            }
        }
        return redirect()->route('payments.create', [
            'unit_unique_reference' => $request->unit_unique_reference
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|max:255',
            'last_name' => 'required',
            'mobile' => 'required|min:10',
            'email' => 'required|email',
            'personal_id' => 'required',
            'unit_unique_reference' => 'required',
            // 'personal_id' => 'required|unique:payments',
            // 'unit_unique_reference' => 'required|unique:payments',
            // 'unit' => 'required',
            'total_unit_price' => 'required',
            'down_payment' => 'required',
            'valid_hours' => 'required|numeric|min:2|max:5',
            'zone' => 'required',
            'building_type' => 'required',
            'address_line_1' => 'required',
            // 'address_line_2' => 'required',
            'city' => 'required',
            'country' => 'required',
            // 'unit_id' => 'required',
            'building_type_id' => 'required',
        ]);

        $payment = Payment::create($request->all());
        $payment->hashed = str_replace('/', '', Hash::make($payment->id));

        if ($request->user_id && (Auth::user()->hasRole('makadi-admin') || Auth::user()->hasRole('makadi-super-admin'))) {
            $payment->user_id = $request->user_id;
        } else {
            $payment->user_id = Auth::user()->id;
        }

        $rate = Rate::where('currency', 'EGP')->first();
        $payment->currency_id = $rate->id;

        $payment->save();

        $payments = Payment::get();
        $count = count($payments);

        return redirect()
            ->route('payments.edit', $payment->id)
            ->with('status', 'Payment Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $payment = Payment::getPayment($request->id);
        $unit_unique_reference = $payment->unit_unique_reference;
        $related_payments = Payment::where('unit_unique_reference', $unit_unique_reference)
        ->orderBy('id','DESC')
        ->get();
        // dd($payment->getRemainingUnitPrice());
        return view('payments.show', compact('payment','related_payments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $payment = Payment::getPayment($request->id);
        if ($payment->status == 2) {
            abort(404);
        }
        $related_payments = Payment::where("unit_unique_reference",$payment->unit_unique_reference)
            ->where('status', 2)
            ->get();

        $count_related_payments = count($related_payments);
        $count_related_payments > 0 ? $has_past_payments_paid = true : $has_past_payments_paid = false;

        $users = User::where('email', '!=', 'super-admin@makadi-heights.com')->get();
        return view('payments.edit', compact('payment', 'users', 'has_past_payments_paid'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Payment $payment)
    {
        $payment = Payment::findOrFail($request->id);

        if ($payment->status == 2) {
            abort(404);
        }

        $validated = $request->validate([
            // 'first_name' => 'required|max:255',
            // 'last_name' => 'required',
            // 'mobile' => 'required',
            // 'email' => 'required|email',
            // 'personal_id' =>
            //     'required|unique:payments,personal_id,' . $payment->id,
            // 'unit_unique_reference' =>
            //     'required|unique:payments,unit_unique_reference,' .
            //     $payment->id,
            // 'personal_id' => 'required',
            // 'unit_unique_reference' => 'required',
            // 'unit' => 'required',
            // 'total_unit_price' => 'required',
            'down_payment' => 'required',
            'valid_hours' => 'required|numeric|min:2|max:5',
            // 'zone' => 'required',
            // 'building_type' => 'required',
            // 'address_line_1' => 'required',
            // 'address_line_2' => 'required',
            // 'city' => 'required',
            // 'country' => 'required',
            // 'unit_id' => 'required',
            'building_type_id' => 'required',
        ]);

        $payment->fill($request->input());

        if ($request->user_id && (Auth::user()->hasRole('makadi-admin') || Auth::user()->hasRole('makadi-super-admin'))) {
            $payment->user_id = $request->user_id;
        } else {
            $payment->user_id = Auth::user()->id;
        }

        $rate = Rate::where('currency', 'EGP')->first();
        $payment->currency_id = $rate->id;

        $payment->save();

        return redirect()
            ->back()
            ->with('status', 'Payment Updated Successfully');
    }

    public function sendPaymentLink(Request $request)
    {
        //TODO: get base_uri from config
        $client = new Client([
            // 'base_uri' => config('app.database_url'),
        ]);
        $response = $client
            ->get(config('app.database_url') . '/zones')
            ->getBody();

        $payment = Payment::findOrFail($request->id);
        if ($payment->status != 2) {
            $payment->status = 0;
        }
        $payment->save();

        $obj = json_decode($response);

        foreach ($obj as $zone) {
            if ($zone->zoneName == $payment->zone) {
                foreach ($zone->building_types as $building_type) {
                    if (trim($building_type->unitName) == trim($payment->building_type)) {
                        // dd($building_type->unitName);
                        $will_use_building_type = $building_type;
                        $will_use_zone = $zone;
                        break;
                    }
                }

                // foreach ($zone->units as $unit) {
                //     if ($unit->unitName == $payment->unit) {
                //         $will_use_unit = $unit;
                //     }
                // }
            }
        }

        try {
            $mail = Mail::to($payment->email)->send(
                new PaymentLink(
                    $payment,
                    $will_use_zone,
                    $will_use_building_type,
                    // $will_use_unit
                )
            );
            $payment_link = config('app.api_url') . '/payments/' . $payment->hashed;

            $payment->payment_link = $payment_link;
            $payment->save();

            // $message = "Thanks for your order,".$payment->first_name." ".$payment->last_name.". Please review your booking details through this link ".$payment_link.". Once you’ve double checked your booking details, make sure you pay the booking amount to keep the unit locked for you. Otherwise, the payment link will expire in an hour and the unit will be made available to other customers. © 2022 Makadi Heights";

            $message = "Dear " . $payment->first_name . " " . $payment->last_name . ", Thanks for your interest in Makadi Heights. Please review your booking details at " . $payment_link . ". Kindly make sure to finalize the payment within the next " . $payment->valid_hours . " hours) to keep the unit reserved for you. For any questions, please contact your MH sales representative.  ";

            $sms = Payment::sendSms($payment->mobile, $message);

        } catch (\Swift_TransportException $e) {
            $error_text = $e->getMessage();
            return response()->json(['error' => $error_text]);
        } catch (\Exception $e) {
            $error_text = $e;
            return response()->json(['error' => $error_text->getMessage()]);
        }

        return redirect()
            ->back()
            // ->with('status', 'Payment Link Sent Successfully '.$sms['data']['SentSMSIDs'][0]['SMSId']);
            ->with('status', 'Payment Link Sent Successfully ');
    }
    //

    public function export(Request $request)
    {
        return Excel::download(new PaymentsExport($request), 'payments.xlsx');
    }

    public function getReceipt(Request $request)
    {
        // $client = new Client([
        //     'base_uri' => config('app.database_url'),
        // ]);
        // $response = $client
        //     ->get(config('app.database_url').'/zones')
        //     ->getBody();

        // $obj = json_decode($response);
        // // dd($obj);

        // $payment = Payment::where('hashed',$request->hashed)->first();

        // foreach ($obj as $zone) {
        //     if ($zone->zoneName == $payment->zone) {
        //         foreach ($zone->building_types as $building_type) {
        //             if ($building_type->unitName == $payment->building_type) {
        //                 // dd($building_type->unitName);
        //                 $will_use_building_type = $building_type;
        //                 $will_use_zone = $zone;
        //                 break;
        //             }
        //         }

        //         foreach ($zone->units as $unit) {
        //             if ($unit->unitName == $payment->unit) {
        //                 $will_use_unit = $unit;
        //             }
        //         }
        //     }
        // }

        // $id = $payment->id;

        // $hashed = $payment->hashed;
        // $unitName = $payment->unit;
        // $zoneName =  $payment->zone;
        // $totalUnitPrice =  $payment->total_unit_price;
        // $downPayment =  $payment->down_payment;
        // $dueAmount = $payment->total_unit_price - $payment->down_payment;
        // $tax =  $payment->total_unit_price * 0.05;
        // $propertySize =  $will_use_unit->propertySize;
        // $bathrooms =  $will_use_unit->bathrooms;
        // $beds =  $will_use_unit->beds;
        // $terraces =  $will_use_unit->terraces;
        // $bua =  $will_use_unit->bua;
        // $zoneName =  $will_use_zone->zoneName;
        // $logourl =  $will_use_zone->bannerSection->logoImg->url;
        // $bannerUrl = $will_use_building_type->exteriorImages[0]->image[0]->url;
        // $building_type =  $will_use_building_type;


        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $options->set('isPhpEnabled', true);
        $options->set('isHtml5ParserEnabled', true);
        $dompdf = new Dompdf($options);

        // $dompdf->loadHtml(view('emails.order-receipt',compact(
        //     'payment',
        //     'id',
        //     'hashed',
        //     'unitName',
        //     'zoneName',
        //     'totalUnitPrice',
        //     'downPayment',
        //     'dueAmount',
        //     'tax',
        //     'propertySize',
        //     'bathrooms',
        //     'beds',
        //     'terraces',
        //     'bua',
        //     'zoneName',
        //     'logourl',
        //     'bannerUrl',
        //     'building_type',

        // )));
        // $dompdf->loadHtml("<html>
        //     <body>
        //     <div>
        //     Hey</div>
        //     Hello
        //     </body>
        // </html>");


        // dd($dompdf);

        // $dompdf->setPaper('A4', 'landscape');

        $dompdf->render();
    }

    public function createSession(Request $request)
    {
        $payment = Payment::find($request->id);
        if (!$payment) {
            return response()->json(['error', "There is an error with connecting to the bank, please try again later"]);
        }

        $client = new Client([
            'base_uri' => 'https://cibpaynow.gateway.mastercard.com/api/nvp/version/61',
        ]);


        $currency = Rate::find($request->currency);
        $params = [
            'apiOperation' => 'CREATE_CHECKOUT_SESSION',
            'apiPassword' => $currency ? $currency->api_password : config('app.merchant_password'),
            'apiUsername' => $currency && $currency->currency != "EGP" ? 'merchant.' . config('app.merchant_id') . $currency->currency : 'merchant.' . config('app.merchant_id'),
            'merchant' => $currency && $currency->currency != "EGP" ? config('app.merchant_id') . $currency->currency : config('app.merchant_id'),
            'interaction.operation' => 'PURCHASE',
            'interaction.returnUrl' => config('app.api_url') . "/payment-success?signed=" . $payment->hashed,
            'interaction.cancelUrl' => config('app.api_url') . "/payment-response?status=1",
            'order.id' => "LIVE-ORDER-" . $payment->id,
            'order.amount' => $currency ? round($payment->down_payment / $currency->rate, 2) : $payment->down_payment,
            'order.description' => 'Order Goods',
            'order.currency' => $currency ? $currency->currency : "EGP",
        ];

        $response = $client->request('POST', "", [
            'form_params' => $params
        ]);

        $body = parse_str($response->getBody(), $parsed);

        return json_encode($parsed, JSON_FORCE_OBJECT);
    }

    public function getSuccessfullPayment(Request $request)
    {
        $payment = Payment::where('transaction_id', $request->transaction_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $payment = Payment::findOrFail($request->id);

        $payment->delete();
        $payments = Payment::get();
        $count = count($payments);

        return redirect()
            ->route('payments')
            ->with('status', 'Payment Deleted Successfully');
    }

    public function sendSms()
    {
        $payment = Payment::sendSms();

        return response()->json($payment);
    }
    public function get_expired_payment()
    {
        $payments = Payment::onlyTrashed()->paginate(15);
        $count = $payments->total();
        return view('payments.expired', compact('payments', 'count'));
    }
    public function restore($id)
    {
        Payment::withTrashed()->where('id', $id)->restore();
        return redirect()->back();
    }
    public function ForceDelete($id)
    {
        Payment::withTrashed()->where('id', $id)->forceDelete();
        return redirect()->back();
    }
    public function DownloadAsPdf(Request $request)
    {
        $payment = Payment::findOrFail($request->id);
        if ($payment->status = 2) {
            $data = [
                'payment' => $payment,
                'remaining_unit_amount' => $payment->getRemainingUnitAmount()['remaining_unit_amount']
            ];
            $pdf = PDF::loadView('emails.order-new', $data);
            return $pdf->download('payments.pdf');
        } else {
            abort(404);
        }
    }
    public function ExportWithDate(Request $request)
    {
        return Excel::download(new PaymentsExport($request), 'payments.xlsx');
    }
}
