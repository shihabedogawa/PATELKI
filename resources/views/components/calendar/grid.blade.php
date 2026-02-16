@props([
    'days' => [],
    'events' => collect(),
])

<div class="bg-white shadow-sm rounded-2xl p-4">

    <div class="grid grid-cols-7 text-center text-[11px] font-semibold text-slate-500 mb-2">
        @foreach(['Sen','Sel','Rab','Kam','Jum','Sab','Min'] as $d)
            <div>{{ $d }}</div>
        @endforeach
    </div>

    <div class="grid grid-cols-7 gap-[2px] text-xs">
        @foreach($days as $day)
            <a 
               href="{{ route('training.calendar', [
                   'month' => request('month', now()->month),
                   'year'  => request('year', now()->year),
                   'date'  => $day['full_date']
               ]) }}"
               class="block"
            >
                <x-calendar.day 
                    :day="$day" 
                    :event="$events[$day['full_date']] ?? null"
                />
            </a>
        @endforeach
    </div>

</div>

