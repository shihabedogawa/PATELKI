<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Billing extends Model
{
    protected $fillable = [
        'member_id',
        'bulan',
        'tahun',
        'amount',
        'status'
    ];

    public function getEffectiveAmountAttribute()
    {
        $setting = \App\Models\DuesSetting::where(function($q){
            $q->where('start_year', '<', $this->tahun)
            ->orWhere(function($q2){
                $q2->where('start_year', $this->tahun)
                    ->whereRaw("FIELD(start_month,
                        'Januari','Februari','Maret','April','Mei','Juni',
                        'Juli','Agustus','September','Oktober','November','Desember')
                        <= FIELD(?, 
                        'Januari','Februari','Maret','April','Mei','Juni',
                        'Juli','Agustus','September','Oktober','November','Desember')",
                        [$this->bulan]);
            });
        })
        ->orderBy('start_year','desc')
        ->orderByRaw("FIELD(start_month,
            'Januari','Februari','Maret','April','Mei','Juni',
            'Juli','Agustus','September','Oktober','November','Desember') DESC")
        ->first();

        return $setting?->amount ?? $this->amount;
    }


    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }
}

