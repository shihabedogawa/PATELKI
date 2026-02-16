<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class HumasActivityController extends Controller
{
    /**
     * Dashboard Humas
     */
    public function index()
    {
        $totalNews = Activity::where('type', 'news')->count();
    $totalBaksos = Activity::where('type', 'baksos')->count();

    $latestActivities = Activity::latest()
        ->take(5)
        ->get();

    return view('admin.humas.dashboard', compact(
        'totalNews',
        'totalBaksos',
        'latestActivities'
    ));
    }

    /**
     * Form tambah berita / kegiatan
     */
    public function create()
    {
        return view('admin.humas.create');
    }

    /**
     * Simpan berita / kegiatan
     * (logic upload & DB kita isi di step berikutnya)
     */
    public function store(Request $request)
    {
        // 1️⃣ VALIDASI
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'type'        => 'required|in:news,baksos',
            'event_date'  => 'nullable|date',

            'image'  => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'report' => 'nullable|file|mimes:pdf|max:5120',
        ]);

        // 2️⃣ UPLOAD FOTO
        $imagePath = $request->file('image')
            ->store('activities/images', 'public');

        // 3️⃣ UPLOAD PDF (OPSIONAL)
        $reportPath = null;
        if ($request->hasFile('report')) {
            $reportPath = $request->file('report')
                ->store('activities/reports', 'public');
        }

        // 4️⃣ SIMPAN KE DATABASE
        Activity::create([
            'title'        => $validated['title'],
            'slug'         => Str::slug($validated['title']) . '-' . time(),
            'description'  => $validated['description'],
            'type'         => $validated['type'],
            'event_date'   => $validated['event_date'] ?? null,

            'cover_image'  => $imagePath,
            'report_file'  => $reportPath,

            'is_published' => true,
            'created_by'   => auth()->id(),
        ]);

        // 5️⃣ REDIRECT
        return redirect()
            ->route('admin.humas.dashboard')
            ->with('success', 'Berita / kegiatan berhasil disimpan.');
    }

    public function edit(Activity $activity)
    {
        return view('admin.humas.edit', compact('activity'));
    }

    public function update(Request $request, Activity $activity)
    {
    $validated = $request->validate([
        'title'       => 'required|string|max:255',
        'description' => 'required|string',
        'type'        => 'required|in:news,baksos',
        'event_date'  => 'nullable|date',
        'image'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'report'      => 'nullable|file|mimes:pdf|max:5120',
    ]);

    // Ganti foto (jika ada)
    if ($request->hasFile('image')) {
        Storage::disk('public')->delete($activity->cover_image);
        $activity->cover_image = $request->file('image')
            ->store('activities/images', 'public');
    }

    // Ganti PDF (jika ada)
    if ($request->hasFile('report')) {
        if ($activity->report_file) {
            Storage::disk('public')->delete($activity->report_file);
        }
        $activity->report_file = $request->file('report')
            ->store('activities/reports', 'public');
    }

    $activity->update([
        'title'        => $validated['title'],
        'description'  => $validated['description'],
        'type'         => $validated['type'],
        'event_date'   => $validated['event_date'] ?? null,
        'slug'         => \Illuminate\Support\Str::slug($validated['title']) . '-' . time(),
    ]);

    return redirect()
        ->route('admin.humas.dashboard')
        ->with('success', 'Konten berhasil diperbarui.');
    }

    public function destroy(Activity $activity)
    {
        Storage::disk('public')->delete($activity->cover_image);

        if ($activity->report_file) {
            Storage::disk('public')->delete($activity->report_file);
        }

        $activity->delete();

        return back()->with('success', 'Konten berhasil dihapus.');
    }




}
