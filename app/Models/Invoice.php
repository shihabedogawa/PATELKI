<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'billing_id',
        'member_id',
        'invoice_number',
        'amount',
        'paid_at',
        'pdf_path'
    ];

    public function billing()
    {
        return $this->belongsTo(Billing::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}


