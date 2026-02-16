<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Support\Carbon;


class GalleryController extends Controller
{
    public function index()
    {
        $activities = Activity::where('is_published', true)
        ->whereNotNull('event_date')
        ->whereDate('event_date', '<', Carbon::today())
        ->orderBy('event_date', 'desc')
        ->paginate(12);

        return view('gallery.index', compact('activities'));
    }
}
