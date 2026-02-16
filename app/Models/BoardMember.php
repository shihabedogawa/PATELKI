<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BoardMember extends Model
{
    //

    protected $fillable = [
    'member_id',
    'position_id',
    'period_start',
    'period_end',
    ];


public function member()
{
    return $this->belongsTo(Member::class);
}

public function position()
{
    return $this->belongsTo(Position::class);
}

}
