@extends('layouts.admin')
@section('content')

<div class="max-w-4xl mx-auto">

<h1 class="text-2xl font-semibold mb-6">Edit Pelatihan</h1>

<form action="{{ route('admin.pendidikan.events.update', $event) }}"
      method="POST"
      enctype="multipart/form-data"
      class="bg-white p-6 rounded-lg shadow space-y-4">

@csrf
@method('PUT')

<input name="title" value="{{ $event->title }}"
       class="w-full border rounded-lg p-2" required>

<input name="category" value="{{ $event->category }}"
       class="w-full border rounded-lg p-2">

<textarea name="description"
          class="w-full border rounded-lg p-2" rows="4">{{ $event->description }}</textarea>

<div class="grid grid-cols-2 gap-4">
    <input type="datetime-local" name="start_date"
           value="{{ \Carbon\Carbon::parse($event->start_date)->format('Y-m-d\TH:i') }}"
           class="border p-2 rounded-lg" required>

    <input type="datetime-local" name="end_date"
           value="{{ \Carbon\Carbon::parse($event->end_date)->format('Y-m-d\TH:i') }}"
           class="border p-2 rounded-lg" required>
</div>

<input name="location" value="{{ $event->location }}"
       class="w-full border rounded-lg p-2" required>

<div class="grid grid-cols-2 gap-4">
    <input type="number" name="quota" value="{{ $event->quota }}"
           class="border p-2 rounded-lg">

    <input type="number" name="remaining_quota"
           value="{{ $event->remaining_quota }}"
           class="border p-2 rounded-lg">
</div>

<select name="status" class="w-full border p-2 rounded-lg">
    <option value="open" {{ $event->status=='open'?'selected':'' }}>Pendaftaran Dibuka</option>
    <option value="almost_full" {{ $event->status=='almost_full'?'selected':'' }}>Hampir Penuh</option>
    <option value="closed" {{ $event->status=='closed'?'selected':'' }}>Ditutup</option>
</select>

@if($event->flyer)
<div class="mt-2">
    <p class="text-sm text-slate-600">Flyer saat ini:</p>
    <img src="{{ asset('storage/'.$event->flyer) }}" class="h-32 mt-2">
</div>
@endif

<input type="file" name="flyer" class="w-full border p-2 rounded-lg">

<button class="bg-emerald-600 text-white px-4 py-2 rounded-lg">
    Simpan Perubahan
</button>

</form>
</div>

@endsection
