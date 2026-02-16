<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    //

protected $fillable = [
    'division_id',
    'name',
];


public function division()
{
    return $this->belongsTo(Division::class);
}

public function boardMembers()
{
    return $this->hasMany(BoardMember::class);
}

}
