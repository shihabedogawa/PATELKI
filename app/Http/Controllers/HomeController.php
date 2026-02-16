<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        // Event selanjutnya (maks 3)
        $nextEvents = Activity::where('is_published', true)
            ->whereNotNull('event_date')
            ->whereDate('event_date', '>=', Carbon::today())
            ->orderBy('event_date', 'asc')
            ->limit(3)
            ->get();

        return view('home', [
            'heroImage'  => 'Mikroskop.jpg',
            'title'      => 'Home',
            'nextEvents' => $nextEvents,
        ]);
    }
}
