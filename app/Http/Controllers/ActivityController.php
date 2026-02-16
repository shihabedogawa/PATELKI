<?php

namespace App\Http\Controllers;

use App\Models\Activity;

class ActivityController extends Controller
{
    public function show(string $slug)
    {
        $activity = Activity::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        return view('activities.show', compact('activity'));
    }
}
