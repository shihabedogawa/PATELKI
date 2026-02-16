<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventParticipant extends Model
{
    //

protected $fillable = [
    'event_id',
    'member_id',
    'name',
    'email',
    'phone',
    'status',
];


public function event()
{
    return $this->belongsTo(Event::class);
}

public function member()
{
    return $this->belongsTo(Member::class);
}

}
