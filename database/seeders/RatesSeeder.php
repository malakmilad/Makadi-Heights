<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rate;

class RatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $usd = Rate::updateOrCreate(['currency' => 'USD','rate' => 18.6,'api_password' => '02e4e7bb50f62128abf77fabf210bb72']);
        $eur = Rate::updateOrCreate(['currency' => 'EUR','rate' => 20.2,'api_password' => 'e5351569469384f584a958e64774210e']);
        $gbp = Rate::updateOrCreate(['currency' => 'GBP','rate' => 23.3,'api_password' => '680d29c08a1b7aaa78e6f8e6819497a3']);
        $egp = Rate::updateOrCreate(['currency' => 'EGP','rate' => 1,'api_password' => '421d47c274609759f9d065934949cbdd']);
    }
}
