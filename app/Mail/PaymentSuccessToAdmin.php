<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentSuccessToAdmin extends Mailable
{
    use Queueable, SerializesModels;

    protected $payment;
    protected $zone;
    protected $building_type;
    // protected $unit;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($payment, $zone, $building_type)
    {
        $this->payment = $payment;
        $this->zone = $zone;
        $this->building_type = $building_type;
        // $this->unit = $unit;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.order-notification-to-admin')
            // ->from('noreply@makadi-heights.com')
            ->subject('Payment Notification')
            ->with([
                'payment' => $this->payment,
                'id' => $this->payment->id,
                'hashed' => $this->payment->hashed,
                'unitName' => $this->payment->unit,
                'zoneName' => $this->payment->zone,
                'totalUnitPrice' => ceil($this->payment->total_unit_price / $this->payment->currency->rate),
                'downPayment' => ceil($this->payment->down_payment / $this->payment->currency->rate),
                'dueAmount' =>
                ceil($this->payment->total_unit_price / $this->payment->currency->rate -
                    $this->payment->down_payment / $this->payment->currency->rate),
                'tax' => ceil(($this->payment->total_unit_price / $this->payment->currency->rate) * 0.05),
                // 'propertySize' => $this->unit->propertySize,
                // 'bathrooms' => $this->unit->bathrooms,
                // 'beds' => $this->unit->beds,
                // 'terraces' => $this->unit->terraces,
                // 'bua' => $this->unit->bua,
                'zoneName' => $this->zone->zoneName,
                'logourl' => $this->zone->bannerSection->logoImg->url,
                'bannerUrl' =>
                    $this->building_type->exteriorImages[0]->image[0]->url,
                'building_type' => $this->building_type,
                'currency' => $this->payment->currency->currency,
                'zoneSlug' => $this->zone->slug,
                'Unit Time'=>$this->payment->unit_unique_reference,
                'created_at'=>$this->payment->created_at,
                'updated_at'=>$this->payment->updated_at
            ]);
    }
}
