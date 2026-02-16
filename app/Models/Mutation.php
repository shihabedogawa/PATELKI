<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mutation extends Model
{
    //

protected $fillable = [
    'member_id',
    'description',
    'mutation_date',
];


public function member()
{
    return $this->belongsTo(Member::class);
}

}
