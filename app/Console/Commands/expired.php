<?php

namespace App\Console\Commands;

use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class expired extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payment:expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Soft delete expired payments';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $payments = Payment::where('status',0)->get();
        foreach($payments as $payment)
        {
            $vaid_hours = $payment->valid_hours;
            $created_at = Carbon::parse($payment->created_at)->addHours($vaid_hours);
            $currentDateTime = Carbon::now();

            if($currentDateTime->gt($created_at)){

                $paymentId = $payment->id;
                $payment->delete();

                Log::info('Payment ID ' . $paymentId . ' has been deleted.'); // Log the payment ID
            }
        }

        Log::info('Cron job done at '. Carbon::now() .' hourly.');

    }
}
