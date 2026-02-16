@extends('layouts.main')

@section('container')

<main class="max-w-4xl mx-auto px-6 py-12 text-gray-800">

    <!-- ===== IMAGE ===== -->
    <div class="rounded-3xl overflow-hidden mb-8">
        <img src="{{ asset('storage/'.$activity->cover_image) }}"
             alt="{{ $activity->title }}"
             class="w-full h-auto object-cover">
    </div>

    <!-- ===== META ===== -->
    <div class="mb-4 flex flex-wrap items-center gap-3 text-sm">
        <span class="px-3 py-1 rounded-full text-xs font-semibold
            {{ $activity->type === 'baksos'
                ? 'bg-emerald-100 text-emerald-700'
                : 'bg-blue-100 text-blue-700' }}">
            {{ strtoupper($activity->type) }}
        </span>

        <span class="text-gray-500">
            <i class="far fa-calendar-alt mr-1"></i>
            {{ $activity->created_at->translatedFormat('d F Y') }}
        </span>
    </div>

    <!-- ===== TITLE ===== -->
    <h1 class="text-2xl md:text-3xl font-bold mb-6">
        {{ $activity->title }}
    </h1>

    <!-- ===== DESCRIPTION ===== -->
    <article class="prose max-w-none mb-8">
        {!! nl2br(e($activity->description)) !!}
    </article>

    <!-- ===== PDF ===== -->
    @if ($activity->report_file)
        <a href="{{ asset('storage/'.$activity->report_file) }}"
           target="_blank"
           class="inline-flex items-center gap-2 px-5 py-3 rounded-xl
                  bg-indigo-600 text-white font-semibold hover:bg-indigo-700">
            📄 Unduh Laporan Kegiatan
        </a>
    @endif

    <!-- ===== BACK ===== -->
    <div class="mt-10">
        <a href="{{ url()->previous() }}"
           class="text-gray-600 hover:underline">
            ← Kembali
        </a>
    </div>

</main>

@endsection
