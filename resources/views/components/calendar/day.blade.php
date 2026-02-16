@props(['day', 'event' => null])

@php
    $dayNumber = $day['day'] ?? $day['date'] ?? '';

    // Base state
    $baseBg = 'bg-white';
    $baseText = 'text-slate-700';
    $eventBg = '';
    $eventText = '';

    if (!$day['isCurrentMonth']) {
        $baseBg = 'bg-slate-50';
        $baseText = 'text-slate-400';
    }

    // Event styles
    if ($event) {
        if ($event->status === 'open') {
            $eventBg = 'bg-emerald-100';
            $eventText = 'text-emerald-700';
        } elseif ($event->status === 'almost_full') {
            $eventBg = 'bg-amber-100';
            $eventText = 'text-amber-800';
        } else {
            $eventBg = 'bg-slate-200';
            $eventText = 'text-slate-600';
        }
    }
@endphp

<div
    class="
        relative h-[92px] rounded-xl p-2 flex flex-col
        {{ $baseBg }} {{ $baseText }}
        transition-all duration-150
        hover:bg-emerald-50 hover:shadow-sm
    "
>

    <!-- DAY NUMBER -->
    <div class="flex justify-between items-center">
        <span class="text-[11px] font-semibold
            {{ $day['isToday'] 
                ? 'bg-emerald-600 text-white px-2 py-0.5 rounded-full shadow-sm' 
                : '' }}">
            {{ $dayNumber }}
        </span>

        @if($event)
            <span class="w-2 h-2 rounded-full
                {{ $event->status === 'open' ? 'bg-emerald-500' : '' }}
                {{ $event->status === 'almost_full' ? 'bg-amber-400' : '' }}
                {{ $event->status === 'closed' ? 'bg-slate-400' : '' }}">
            </span>
        @endif
    </div>

    <!-- EVENT PREVIEW -->
    @if($event)
        <div class="mt-auto">
            <div
                class="
                    text-[10px] leading-tight truncate
                    px-2 py-1 rounded-md
                    {{ $eventBg }} {{ $eventText }}
                "
                title="{{ $event->title }}"
            >
                {{ $event->title }}
            </div>
        </div>
    @endif

    <!-- TODAY GLOW -->
    @if($day['isToday'])
        <div class="absolute inset-0 rounded-xl ring-1 ring-emerald-300 pointer-events-none"></div>
    @endif

</div>
