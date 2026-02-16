<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DuesSetting extends Model
{
    protected $fillable = [
        'amount',
        'start_month',
        'start_year',
        'note'
    ];
}

