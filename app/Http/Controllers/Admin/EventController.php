<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::latest()->paginate(10);

        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        return view('admin.events.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'description' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'location' => 'required|string|max:255',
            'quota' => 'nullable|integer|min:1',
            'remaining_quota' => 'nullable|integer|min:0',
            'status' => 'required|in:open,almost_full,closed',
            'flyer' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'whatsapp' => 'required|string|min:10|max:15',
        ]);

        if ($request->hasFile('flyer')) {
            $validated['flyer'] = $request->file('flyer')
                ->store('flyers', 'public');
        }

        $validated['created_by'] = auth()->id();

        Event::create($validated);

        return redirect()
            ->route('admin.pendidikan.events.index')
            ->with('success', 'Pelatihan berhasil ditambahkan.');
    }

    public function edit(Event $event)
    {
        return view('admin.pendidikan.events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'description' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'location' => 'required|string|max:255',
            'quota' => 'nullable|integer|min:1',
            'remaining_quota' => 'nullable|integer|min:0',
            'status' => 'required|in:open,almost_full,closed',
            'flyer' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            
        ]);

        if ($request->hasFile('flyer')) {
            // hapus flyer lama kalau ada
            if ($event->flyer) {
                Storage::disk('public')->delete($event->flyer);
            }

            $validated['flyer'] = $request->file('flyer')
                ->store('flyers', 'public');
        }

        $event->update($validated);

        return redirect()
            ->route('admin.pendidikan.events.index')
            ->with('success', 'Pelatihan berhasil diperbarui.');
    }

    public function destroy(Event $event)
    {
        if ($event->flyer) {
            Storage::disk('public')->delete($event->flyer);
        }

        $event->delete();

        return back()->with('success', 'Pelatihan berhasil dihapus.');
    }
}
