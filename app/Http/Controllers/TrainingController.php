<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Event;
use App\Models\NationalHoliday;


class TrainingController extends Controller
{

    public function calendar(Request $request)
    {
    $month = (int) $request->get('month', now()->month);
    $year  = (int) $request->get('year', now()->year);
    $holidays = NationalHoliday::whereMonth('date', $month)
    ->whereYear('date', $year)
    ->pluck('name', 'date')
    ->toArray();


    $current = Carbon::create($year, $month, 1);
    $selectedDate = $request->get('date');

    // Ambil semua event di bulan ini
    $events = Event::whereMonth('start_date', $month)
        ->whereYear('start_date', $year)
        ->get()
        ->keyBy(function ($e) {
            return Carbon::parse($e->start_date)->toDateString();
        });

    // Siapkan detail jika tanggal diklik
    $selectedTraining = null;
    if ($selectedDate && isset($events[$selectedDate])) {
        $e = $events[$selectedDate];

        $selectedTraining = [
            'date' => Carbon::parse($e->start_date)->translatedFormat('l, d F Y'),
            'title' => $e->title,
            'location' => $e->location,
            'time' => Carbon::parse($e->start_date)->format('H:i') .
                      ' – ' .
                      Carbon::parse($e->end_date)->format('H:i') . ' WIB',
            'description' => $e->description,
            'status' => $e->status,
            'quota' => $e->quota,
            'remaining_quota' => $e->remaining_quota,
            'category' => $e->category,
            'flyer' => $e->flyer,
            'whatsapp' => $e->whatsapp,
        ];
    }

    return view('pages.event.calendar', [
    'calendarDays' => $this->generateCalendar($month, $year, $events, $holidays),
        'selectedTraining' => $selectedTraining,
        'month' => $month,
        'year' => $year,
        'prevMonth' => $current->copy()->subMonth(),
        'nextMonth' => $current->copy()->addMonth(),
        'events' => $events,
        'holidays' => $holidays,
    ]);
    }



    private function generateCalendar(int $month, int $year, $events, array $holidays): array
{
    $startOfMonth = Carbon::create($year, $month, 1);
    $endOfMonth   = $startOfMonth->copy()->endOfMonth();

    $startDate = $startOfMonth->copy()->startOfWeek(Carbon::MONDAY);
    $endDate   = $endOfMonth->copy()->endOfWeek(Carbon::SUNDAY);

    $days = [];

    while ($startDate <= $endDate) {

        $fullDate = $startDate->toDateString();

        // 🔹 CEK LIBUR HARUS DI DALAM LOOP
        $isHoliday = isset($holidays[$fullDate]);
        $holidayName = $holidays[$fullDate] ?? null;

        $training = null;

        // Jika ada event DAN BUKAN hari libur
        if (isset($events[$fullDate]) && !$isHoliday) {
            $e = $events[$fullDate];

            $training = [
                'title' => $e->title,
                'status' => $e->status,
                'status_class' => match ($e->status) {
                    'open' => 'bg-emerald-600 text-white',
                    'almost_full' => 'bg-amber-100 text-amber-800 border border-amber-300',
                    'closed' => 'bg-slate-200 text-slate-700',
                },
            ];
        }

        $days[] = [
            'date' => $startDate->day,
            'full_date' => $fullDate,
            'isToday' => $startDate->isToday(),
            'isCurrentMonth' => $startDate->month === $month,
            'training' => $training,
            'isHoliday' => $isHoliday,
            'holidayName' => $holidayName,
        ];

        $startDate->addDay();
    }

    return $days;
    }


}
