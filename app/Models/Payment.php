<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use HasFactory;
    use SoftDeletes;

    const PENDING = 0;
    const FAILED = 1;
    const PAID = 2;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function faqs()
    {
        return $this->hasMany('App\Models\Faq');
    }

    public function currency()
    {
        return $this->belongsTo('App\Models\Rate', 'currency_id');
    }

    public function getStatus()
    {
        switch ($this->status) {
            case $this::PENDING:
                return 'Pending';

            case $this::FAILED:
                return 'Failed';

            case $this::PAID:
                return 'Paid';

            default:
                return 'Pending';
        }
    }

    public function getRemainingUnitAmount()
    {
        $related_payments = self::where('unit_unique_reference', $this->unit_unique_reference)
            ->where('status', 2)
            ->get();

        $unit_price = $this->total_unit_price;
        $remaining_unit_amount = $unit_price;
        $payments_paid = 0;

        foreach ($related_payments as $payment) {
            $payments_paid += $payment->down_payment;
        }

        $remaining_unit_amount = $unit_price - $payments_paid;

        return ['remaining_unit_amount' => $remaining_unit_amount, 'total_paid' => $payments_paid]; // Return an array of remaining amount, and total paid
    }
    //TODO: try to merge getPayments & getPayment
    // TODO: move methods to repository
    public static function getPayments()
    {
        // \DB::statement("SET SQL_MODE=''");
        // $payments = self::orderBy('id','DESC')->groupBy('unit_unique_reference')->paginate(15);
        $latestIds = self::selectRaw('MAX(id) as max_id')
            ->groupBy('unit_unique_reference')
            ->orderBy('max_id', 'DESC');

        $payments = self::with(['user'])->joinSub($latestIds, 'latest_ids', function ($join) {
            $join->on('payments.id', '=', 'latest_ids.max_id');
        })
            ->orderBy('latest_ids.max_id', 'DESC')
            ->with('user');

        $logged_in_user = Auth::user();

        if ($logged_in_user->hasRole('sales')) {
            $payments->whereHas('user', function ($query) use ($logged_in_user) {
                    $query->where('id', $logged_in_user->id);
                })
                ->orderBy('latest_ids.max_id', 'DESC');
        }

        if ($logged_in_user->hasRole('manager')) {
            $payments->whereHas('user', function ($query) use ($logged_in_user) {
                    $query->where('manager_id', $logged_in_user->id)->orWhere('id', $logged_in_user->id);
                })
                ->orderBy('latest_ids.max_id', 'DESC');
        }
        
        return $payments->paginate(15);
    }

    public static function getPayment($id)
    {
        $payment = self::findOrFail($id);
        $logged_in_user = Auth::user();
        if ($logged_in_user->hasRole('sales')) {
            $payment = self::with(['user'])
                ->where('id', $id)
                ->whereHas('user', function ($query) use ($logged_in_user) {
                    $query->where('id', $logged_in_user->id);
                })
                ->first();
            if (!$payment) {
                abort(404);
            }
        }

        return $payment;
    }

    public static function sendSms($mobile, $message)
    {

        $client = new Client();

        $request = $client->request('POST', 'https://apis.cequens.com/auth/v1/tokens/', [
            'body' => '{"apiKey":"' . config('services.sms.api_key') . '","userName":"' . config('services.sms.username') . '"}',
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
        ]);

        $response = json_decode($request->getBody()->getContents(), true);
        $api_key = $response['data']['access_token'];

        $message = $client->request('POST', 'https://apis.cequens.com/sms/v1/messages', [
            'body' => '{"senderName":"OrascomDev","messageType":"text","acknowledgement":1,"flashing":0,"messageText":"' . $message . '","recipients":"' . $mobile . '"}',
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $api_key,
                'Content-Type' => 'application/json',
            ],
        ]);

        return json_decode($message->getBody()->getContents(), true);
    }
}
