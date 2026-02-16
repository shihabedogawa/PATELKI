@props([
    'month',
    'year',
    'prevMonth',
    'nextMonth',
])

<section
    class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-emerald-600 to-teal-500 px-5 py-4 shadow-lg">

    <!-- decorative blur -->
    <div class="absolute -top-10 -right-10 w-40 h-40 bg-white/10 rounded-full"></div>
    <div class="absolute bottom-0 left-16 w-24 h-24 bg-white/10 rounded-full"></div>

    <div class="relative z-10 flex flex-col sm:flex-row sm:items-center gap-4 text-white">

        <!-- LEFT: MONTH NAV -->
        <div class="flex items-center gap-3">

            {{-- Prev --}}
            <a href="{{ route('training.calendar', [
                'month' => $prevMonth->month,
                'year'  => $prevMonth->year
            ]) }}"
               class="flex items-center justify-center w-9 h-9 rounded-full bg-white/20 hover:bg-white/30 transition">
                ‹
            </a>

            {{-- Month label --}}
            <div class="leading-tight">
                <p class="text-xs uppercase tracking-wide opacity-80"></p>
                <h2 class="text-lg font-bold tracking-tight">
                    {{ \Carbon\Carbon::create($year, $month)->translatedFormat('F Y') }}
                </h2>
            </div>

            {{-- Next --}}
            <a href="{{ route('training.calendar', [
                'month' => $nextMonth->month,
                'year'  => $nextMonth->year
            ]) }}"
               class="flex items-center justify-center w-9 h-9 rounded-full bg-white/20 hover:bg-white/30 transition">
                ›
            </a>
        </div>

        <div class="flex-1"></div>

        <!-- RIGHT: FILTER -->
        <div class="flex flex-wrap gap-2">

            <select
                class="text-xs rounded-xl bg-white/90 text-slate-700 px-3 py-2 shadow-sm
                       focus:outline-none focus:ring-2 focus:ring-emerald-400">
                <option>Semua Kategori</option>
            </select>

            <select
                class="text-xs rounded-xl bg-white/90 text-slate-700 px-3 py-2 shadow-sm
                       focus:outline-none focus:ring-2 focus:ring-emerald-400">
                <option>Status: Semua</option>
            </select>

        </div>

    </div>
</section>
