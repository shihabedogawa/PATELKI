@extends('layouts.main')
@section('container')

@include('partials.whatsapp-popup')

<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-28 pb-16 space-y-16">

    <!-- ================= HERO ================= -->
    <section class="text-center space-y-4">
        <h1 class="text-3xl sm:text-4xl font-bold tracking-tight text-slate-900">
            Kegiatan Bakti Sosial
        </h1>
        <p class="text-base text-slate-500 max-w-2xl mx-auto leading-relaxed">
            Dokumentasi dan informasi kegiatan bakti sosial yang dilaksanakan sebagai
            wujud kepedulian dan pengabdian organisasi kepada masyarakat.
        </p>
    </section>

    <!-- ================= LIST ================= -->
    <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

        @forelse($activities as $item)
        <article
            class="group relative bg-white/80 backdrop-blur-xl rounded-3xl shadow-xl
                   hover:shadow-2xl transition overflow-hidden flex flex-col"
        >

            <!-- IMAGE -->
            <div class="relative aspect-[16/10] overflow-hidden">
                <img
                    src="{{ asset('storage/'.$item->cover_image) }}"
                    alt="{{ $item->title }}"
                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                />

                <!-- BADGE -->
                <span class="absolute top-4 left-4 inline-flex items-center
                             rounded-full bg-emerald-600 px-4 py-1.5
                             text-xs font-semibold text-white shadow">
                    Bakti Sosial
                </span>
            </div>

            <!-- CONTENT -->
            <div class="flex flex-col flex-1 p-6 space-y-4">

                <h3 class="text-lg font-semibold text-slate-900 leading-snug line-clamp-2">
                    {{ $item->title }}
                </h3>

                <p class="text-sm text-slate-600 leading-relaxed line-clamp-3">
                    {{ $item->description }}
                </p>

                <!-- META -->
                <div class="flex flex-wrap gap-2 pt-2 text-xs">

                    @if($item->event_date)
                    <span class="inline-flex items-center rounded-full
                                 bg-slate-100 px-3 py-1 text-slate-600">
                        {{ \Carbon\Carbon::parse($item->event_date)->translatedFormat('d F Y') }}
                    </span>
                    @endif

                    @if($item->report_file)
                    <a
                        href="{{ asset('storage/'.$item->report_file) }}"
                        target="_blank"
                        class="inline-flex items-center gap-1 rounded-full
                               bg-emerald-600 px-3 py-1 text-white
                               hover:bg-emerald-700 transition"
                    >
                        📄 Laporan
                    </a>
                    @endif

                </div>

                <!-- CTA -->
                <div class="pt-4 mt-auto">
                    <a
                        href="{{ route('baksos.schedule') }}"
                        class="inline-flex items-center text-sm font-semibold
                               text-emerald-700 hover:text-emerald-900 transition"
                    >
                        Lihat Detail →
                    </a>
                </div>

            </div>

        </article>
        @empty
        <div class="col-span-full text-center py-20">
            <p class="text-base text-slate-500">
                Belum ada kegiatan bakti sosial yang dipublikasikan.
            </p>
        </div>
        @endforelse

    </section>

</main>

@include('footer')
@endsection
