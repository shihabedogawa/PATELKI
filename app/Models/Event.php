<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Event extends Model
{
    //

protected $fillable = [
    'title',
    'category',
    'description',
    'start_date',
    'end_date',
    'location',
    'quota',
    'remaining_quota',
    'status',
    'flyer',
    'whatsapp',
    'created_by',
    ];


public function creator()
{
    return $this->belongsTo(User::class, 'created_by');
}

public function participants()
{
    return $this->hasMany(EventParticipant::class);
}

public function calendar(Request $request)
{
    $month = (int) $request->get('month', now()->month);
    $year  = (int) $request->get('year', now()->year);

    $current = Carbon::create($year, $month, 1);

    // Ambil semua event di bulan ini
    $events = Event::whereMonth('start_date', $month)
        ->whereYear('start_date', $year)
        ->get()
        ->keyBy(fn($e) => Carbon::parse($e->start_date)->toDateString());

    $calendarDays = $this->generateCalendar($month, $year);

    // Masukkan event ke tiap hari kalender
    foreach ($calendarDays as &$day) {
        if (isset($events[$day['full_date']])) {
            $day['training'] = $events[$day['full_date']];
        }
    }

    // Jika ada tanggal diklik
    $selectedDate = $request->get('date');
    $selectedTraining = null;

    if ($selectedDate) {
        $selectedTraining = Event::whereDate('start_date', $selectedDate)->first();}
    }

public function getWhatsappMessageAttribute()
{
    return match ($this->category) {
        'workshop' => "Hallo admin 👋

Saya ingin mendaftar *WORKSHOP*:
📌 {$this->title}

Apakah kuotanya masih tersedia?",

        'seminar' => "Hallo admin 👋

Saya tertarik mengikuti *SEMINAR*:
📌 {$this->title}

Mohon info pendaftarannya 🙏",

        'pelatihan' => "Hallo admin 👋

Saya ingin ikut *PELATIHAN*:
📌 {$this->title}

Apakah masih tersedia slot?",

        default => "Hallo admin 👋

Saya ingin mendaftar:
📌 {$this->title}

Apakah kuotanya masih tersedia?",
    };
}

public function getWhatsappLinkAttribute()
{
    return "https://wa.me/{$this->whatsapp}?text=" . urlencode($this->whatsapp_message);
}



}
