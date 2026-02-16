<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use Carbon\Carbon;


class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'cover_image',
        'report_file',
        'type',
        'event_date',
        'is_published',
        'created_by',
    ];

    protected $casts = [
    'event_date' => 'date',
    ];


    /**
     * Admin (Humas) pembuat konten
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getEventLabelAttribute()
    {
        if (!$this->event_date) return null;

        if ($this->event_date->isToday()) {
            return 'Hari Ini';
        }

        if ($this->event_date->isTomorrow()) {
            return 'Besok';
        }

        return $this->event_date->translatedFormat('d F Y');
    }
}
