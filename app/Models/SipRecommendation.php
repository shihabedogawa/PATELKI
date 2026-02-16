<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SipRecommendation extends Model
{
    //

protected $fillable = [
    'member_id',
    'sip_number',
    'status',
    'submitted_at',
    'approved_at',
];


public function member()
{
    return $this->belongsTo(Member::class);
}

}
