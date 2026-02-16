@extends('layouts.main')
@section('title', 'Jadwal Pelatihan')
@section('container')


<div class="bg-white space-y-6 px-2 sm:px-0 py-20">
@include('partials.whatsapp-popup')

    {{-- Header Kalender --}}
    <x-calendar.header />

    {{-- Navigasi Bulan --}}
    <x-filters.month-filter 
        :month="$month" 
        :year="$year" 
        :prevMonth="$prevMonth" 
        :nextMonth="$nextMonth" 
    />

    
    <section class="bg-slate-100 rounded-2xl shadow-sm p-4 sm:p-5 lg:p-6">

    {{-- GRID + PANEL dalam satu kartu --}}
    <div class="grid grid-cols-1 lg:grid-cols-[2fr_1fr] gap-6 mt-6">

        <x-calendar.grid 
            :days="$calendarDays"
            :events="$events"   
        />

        <x-training.detail-panel :training="$selectedTraining" />

    </div>

</section>

</div>

@include('footer')

@endsection


