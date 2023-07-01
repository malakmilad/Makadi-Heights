<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Faq;
use Illuminate\Support\Facades\Mail;
use GuzzleHttp\Client;

class ApiController extends Controller
{
    public function getPayment(Request $request)
    {
        $payment = Payment::where('hashed',$request->hashed)->first();

        if (!$payment) {
            return response()->json([
                'statusCode' => 500,
                'error' => 'Internal Server Error',
                'message' => 'An internal server error occurred',
            ]);
        }
        
        $remaining_unit_amount = $payment->getRemainingUnitAmount()['remaining_unit_amount'];


        return response()->json(['payment' => $payment, 'remaining_unit_amount' => $remaining_unit_amount ]);
    }

    public function getFaqs()
    {
        $faqs = Faq::get();

        if (!$faqs) {
            return response()->json([
                'statusCode' => 500,
                'error' => 'Internal Server Error',
                'message' => 'An internal server error occurred',
            ]);
        }

        return $faqs;
    }

    public function updateStatus(Request $request)
    {
        $payment = Payment::where('hashed',$request->hashed)->first();

        if (!$payment) {
            return response()->json([
                'statusCode' => 500,
                'error' => 'Internal Server Error',
                'message' => 'An internal server error occurred',
            ]);
        }

        $validated = $request->validate([
            'status' => 'required',
        ]);

        if (!$payment->transaction_id) {
            $payment->transaction_id = $request->transaction_id;
        }


        if (isset($request->currency_id)) {
            $payment->currency_id = $request->currency_id;
        }

        $payment->save();

        $client = new Client([
            'base_uri' => config('app.database_url'),
        ]);
        $response = $client
            ->get(config('app.database_url').'/zones')
            ->getBody();

        $obj = json_decode($response);

        foreach ($obj as $zone) {
            if ($zone->zoneName == $payment->zone) {
                foreach ($zone->building_types as $building_type) {
                    if ($building_type->unitName == $payment->building_type) {
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

        $payment->update([
            'status' => $request->status,
        ]);

        if ($payment->status == 2) {
            $payment->total_paid = $payment->down_payment / $payment->currency->rate;
            $payment->save();
            Mail::to($payment->email)->send(
                new \App\Mail\PaymentSuccess(
                    $payment,
                    $will_use_zone,
                    $will_use_building_type,
                    // $will_use_unit
                )
            );

            Mail::to([$payment->user->email])->send(
                new \App\Mail\PaymentSuccessToAdmin(
                    $payment,
                    $will_use_zone,
                    $will_use_building_type,
                    // $will_use_unit
                )
            );
            $message = "Thank you for choosing Makadi Heights! Your payment was successful. Your payment reciept was sent to your registered email. For any inquires, please contact your MH sales representative.";

            $sms = Payment::sendSms($payment->mobile, $message);
        }

        return $payment;
    }

    public function test()
    {
        $client = new Client([
            'base_uri' => config('app.database_url'),
        ]);
        $response = $client
            ->get(config('app.database_url').'/zones')
            ->getBody();

        $obj = json_decode($response);

        $payment = Payment::where('id',90)->first();

        foreach ($obj as $zone) {
            if ($zone->zoneName == $payment->zone) {
                foreach ($zone->building_types as $building_type) {
                    if ($building_type->unitName == $payment->building_type) {
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

        Mail::to($payment->email)->send(
            new \App\Mail\PaymentSuccess(
                $payment,
                $will_use_zone,
                $will_use_building_type,
                // $will_use_unit
            )
        );
        Mail::to([$payment->user->email])->send(
            new \App\Mail\PaymentSuccessToAdmin(
                $payment,
                $will_use_zone,
                $will_use_building_type,
                // $will_use_unit
            )
        );
    }
}
