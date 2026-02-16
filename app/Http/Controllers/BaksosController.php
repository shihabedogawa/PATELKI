<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Carbon\Carbon;

class BaksosController extends Controller
{
    public function index()
    {
        $activities = Activity::where('type', 'baksos')
            ->where('is_published', true)
            ->whereDate('event_date', '>=', Carbon::today())
            ->orderBy('event_date')
            ->get();

        return view('pages.baksos.schedule', compact('activities'));
    }
}
