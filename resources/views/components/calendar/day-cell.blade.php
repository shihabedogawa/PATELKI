@php
    $base = 'h-20 rounded-lg p-1 flex flex-col relative';
@endphp

<div class="{{ $base }}
    {{ $day['isCurrentMonth'] ? 'bg-slate-50' : 'bg-slate-50/50 text-slate-400' }}
    {{ $day['isToday'] ? 'border-2 border-emerald-500 bg-emerald-50' : '' }}
    {{ $day['isHoliday'] ? 'bg-red-50 border border-red-300' : '' }}
">

    {{-- Nomor tanggal --}}
    <span class="text-[11px] self-end">
        {{ $day['date'] }}
    </span>

    {{-- Label Hari Libur --}}
    @if($day['isHoliday'])
        <span class="text-[9px] text-red-600 font-semibold leading-tight mt-0.5">
            {{ $day['holidayName'] }}
        </span>
    @endif

    {{-- Event / Training (hanya muncul jika bukan libur) --}}
    @if($day['training'])
        <button 
            class="mt-auto text-[10px] rounded-md px-1.5 py-0.5 {{ $day['training']['status_class'] }}"
        >
            {{ $day['training']['title'] }}
        </button>
    @endif

</div>
