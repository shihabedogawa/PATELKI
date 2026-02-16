<div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 sm:p-6 flex flex-col min-h-full">

    @if ($training)

        <!-- HEADER -->
        <div class="mb-4">
            <p class="text-xs uppercase tracking-wide text-slate-400">
                Detail Pelatihan
            </p>
            <h2 class="text-sm font-semibold text-slate-800 mt-0.5">
                {{ $training['date'] }}
            </h2>
        </div>

        <!-- MAIN CARD -->
        <div class="bg-emerald-50 rounded-2xl border border-emerald-100 p-5 flex-1 text-slate-700">

            <!-- CATEGORY -->
            <p class="text-xs uppercase tracking-wide text-emerald-600 font-semibold mb-1">
                {{ $training['category'] }}
            </p>

            <!-- TITLE -->
            <h3 class="text-base font-bold text-slate-900 leading-snug">
                {{ $training['title'] }}
            </h3>

            <!-- META -->
            <div class="mt-2 space-y-1 text-xs text-slate-600">
                <p>📍 {{ $training['location'] }}</p>
                <p>⏰ {{ $training['time'] }}</p>
            </div>

            <!-- DESCRIPTION -->
            <p class="mt-3 text-xs text-slate-600 leading-relaxed">
                {{ $training['description'] }}
            </p>

            <!-- STATUS & QUOTA -->
            <div class="flex flex-wrap items-center gap-2 mt-4 text-xs">

                <span class="inline-flex items-center px-3 py-1 rounded-full font-semibold
                    {{ $training['status'] === 'open' ? 'bg-emerald-600 text-white' : '' }}
                    {{ $training['status'] === 'almost_full' ? 'bg-amber-100 text-amber-700' : '' }}
                    {{ $training['status'] === 'closed' ? 'bg-slate-200 text-slate-600' : '' }}
                ">
                    {{ ucfirst(str_replace('_', ' ', $training['status'])) }}
                </span>

                @if ($training['quota'])
                    <span class="inline-flex items-center px-3 py-1 rounded-full border border-slate-300 text-slate-600">
                        🎟 Kuota {{ $training['quota'] }} • Sisa {{ $training['remaining_quota'] }}
                    </span>
                @endif

            </div>

            <!-- FLYER -->
            @if ($training['flyer'])
                <div class="mt-5">
                    <p class="text-xs font-medium text-slate-500 mb-2">
                        Flyer Pelatihan
                    </p>
                    <img
                        src="{{ asset('storage/' . $training['flyer']) }}"
                        alt="Flyer {{ $training['title'] }}"
                        class="w-full max-h-48 object-cover rounded-xl border border-slate-200 shadow-sm"
                    >
                </div>
            @endif

        </div>

        <!-- CTA -->
        @if (isset($training['whatsapp']))
            <div class="mt-5">
                <a
                    href="https://wa.me/{{ $training['whatsapp'] }}?text=Halo%20Admin,%20saya%20ingin%20mendaftar%20pelatihan:%20{{ urlencode($training['title']) }}"
                    target="_blank"
                    class="block w-full text-center bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-3 text-sm font-semibold rounded-full shadow transition">
                    Daftar Pelatihan Ini
                </a>
            </div>
        @endif

    @else

        <!-- EMPTY STATE -->
        <div class="flex flex-col items-center justify-center text-center text-slate-500 py-10">
            <div class="text-4xl mb-2">📅</div>
            <p class="text-sm font-medium">
                Belum ada pelatihan dipilih
            </p>
            <p class="text-xs mt-1">
                Klik tanggal pada kalender untuk melihat detail pelatihan.
            </p>
        </div>

    @endif

</div>
