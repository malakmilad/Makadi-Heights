<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentLink extends Mailable
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
        return $this->view('emails.send-payment-link')
            // ->from('noreply@makadi-heights.com')
            ->subject('Action Required: Payment Notice')
            ->with([
                'id' => $this->payment->id,
                'name' => $this->payment->first_name." ".$this->payment->last_name,
                'link' => config('app.api_url').'/payments/'.$this->payment->hashed,
                'hashed' => $this->payment->hashed,
                // 'unitName' => $this->payment->unit,
                'valid_hours' => $this->payment->valid_hours,
                'zoneName' => $this->payment->zone,
                'totalUnitPrice' => $this->payment->total_unit_price,
                'downPayment' => $this->payment->down_payment,
                'dueAmount' =>
                    $this->payment->total_unit_price -
                    $this->payment->down_payment,
                'tax' => $this->payment->total_unit_price * 0.05,
                // 'propertySize' => $this->unit->propertySize,
                // 'bathrooms' => $this->unit->bathrooms,
                // 'beds' => $this->unit->beds,
                // 'terraces' => $this->unit->terraces,
                // 'bua' => $this->unit->bua,
                'zoneName' => $this->zone->zoneName,
                'logoUrl' => $this->zone->bannerSection->logoImg->url,
                'bannerUrl' =>
                    $this->building_type->exteriorImages[0]->image[0]->url,
                'building_type' => $this->building_type,
            ]);
    }
}
