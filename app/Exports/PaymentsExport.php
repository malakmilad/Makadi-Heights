<?php

namespace App\Exports;

use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PaymentsExport implements FromCollection, WithMapping, WithHeadings
{
    protected $request;
    public function __construct($request)
    {
        $this->request = $request;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $request = $this->request;
        $payments = Payment::with(['user']);
        $logged_in_user = Auth::user();
        if ($logged_in_user->hasRole('sales')) {
            $payments->whereHas('user', function($query) use($logged_in_user) {
                $query->where('id',$logged_in_user->id);
            });
        } elseif ($request->date_from && $request->date_to) {
            // $payments->whereBetween('created_at', [
            //     $request->date_from,
            //     $request->date_to,
            // ]);
            $payments->where('created_at', '>=', $request->date_from)
                    ->where('created_at', '<=', $request->date_to);
            // dd($payments->get(),$request->date_to);
        } elseif ($request->date_from) {
            $payments->where('created_at', '>=', $request->date_from);
        } elseif ($request->date_to) {
            $payments->where('created_at', '<=', $request->date_to);
        }
        
        $paymentdata = $payments->get();
        
        return $paymentdata;
    }
    public function map($payment): array
    {
        switch ($payment->status) {
            case '0':
                $status = 'Pending';
                break;

            case '1':
                $status = 'Failed';
                break;

            case '2':
                $status = 'Paid';
                break;
        }
        return [
            $payment->id,
            $payment->first_name,
            $payment->last_name,
            // $payment->mobile,
            // $payment->email,
            $payment->personal_id,
            $payment->unit_unique_reference,
            // $payment->unit,
            $payment->payment_link,
            number_format($payment->total_unit_price,0) . " EGP",
            number_format($payment->down_payment, 0) . " EGP",
            number_format(($payment->total_paid ? $payment->total_paid : $payment->down_payment / $payment->currency->rate), 0) . " " . $payment->currency->currency,
            $payment->valid_hours,
            $payment->zone,
            $payment->building_type,
            $payment->address_line_1,
            $payment->address_line_2,
            $payment->city,
            $payment->country,
            $status,
            $payment->user->name,
            $payment->created_at,
            $payment->updated_at,
            $payment->currency->currency
        ];
    }
    public function headings(): array
    {
        return [
            '#',
            'First Name',
            'Last Name',
            // 'mobile',
            // 'email',
            'Personal ID',
            'Unit Unique Reference',
            // 'unit',
            'Payment Link',
            'Total Unit Price',
            'Down Payment',
            'Total Paid',
            'Valid Hours',
            'Zone',
            'Building Type',
            'Addres Line 1',
            'Address Line 2',
            'City',
            'Country',
            'Status',
            'Created by',
            'Created At',
            'Updated At',
            'Currency'
        ];
    }
}
