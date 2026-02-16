<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Member;
use App\Models\Billing;

class BillingSeeder extends Seeder
{
    public function run()
    {
        $months = [
            'Januari','Februari','Maret','April','Mei','Juni',
            'Juli','Agustus','September','Oktober','November','Desember'
        ];

        $year = now()->year;

        $members = Member::all();

        foreach ($members as $member) {
            foreach ($months as $month) {
                Billing::firstOrCreate([
                    'member_id' => $member->id,
                    'bulan' => $month,
                    'tahun' => $year,
                ], [
                    'amount' => 50000,
                    'status' => 'unpaid'
                ]);
            }
        }
    }
}
