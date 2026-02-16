<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'billing_id',
        'member_id',
        'proof_path',
        'note',
        'status',
    ];

    public function billing()
    {
        return $this->belongsTo(Billing::class);
    }
}
