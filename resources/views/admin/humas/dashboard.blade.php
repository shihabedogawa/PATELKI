@extends('layouts.admin')

@section('content')

<div class="mx-auto max-w-7xl space-y-12">

    <!-- ================= HEADER ================= -->
    <header class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6">
        <div class="space-y-2">
            <h1 class="text-3xl font-bold tracking-tight text-slate-900">
                Dashboard Divisi Humas
            </h1>
            <p class="text-base text-slate-500 max-w-2xl leading-relaxed">
                Pusat kendali publikasi berita dan kegiatan bakti sosial organisasi.
            </p>
        </div>

        <a href="{{ route('admin.humas.activities.create') }}"
           class="inline-flex items-center gap-2 rounded-full
                  bg-indigo-600 px-6 py-3 text-sm font-semibold text-white
                  hover:bg-indigo-700 transition shadow-md">
            <span class="text-lg leading-none">＋</span>
            Tambah Konten
        </a>
    </header>

    <!-- ================= STATS ================= -->
    <section class="grid grid-cols-1 sm:grid-cols-2 gap-6">

        <!-- TOTAL BERITA -->
        <div class="relative rounded-2xl bg-white/70 backdrop-blur-xl px-6 py-5 shadow-md">
            <div class="absolute -top-6 -right-6 w-24 h-24 bg-blue-200/40 rounded-full blur-2xl"></div>

            <p class="text-xs font-medium text-slate-500 uppercase tracking-wide">
                Total Berita
            </p>

            <h2 class="mt-2 text-3xl font-bold text-slate-900">
                {{ $totalNews }}
            </h2>

            <p class="mt-3 text-xs text-slate-400">
                Konten berita dipublikasikan
            </p>
        </div>

        <!-- TOTAL BAKSOS -->
        <div class="relative rounded-2xl bg-white/70 backdrop-blur-xl px-6 py-5 shadow-md">
            <div class="absolute -top-6 -right-6 w-24 h-24 bg-emerald-200/40 rounded-full blur-2xl"></div>

            <p class="text-xs font-medium text-slate-500 uppercase tracking-wide">
                Total Baksos
            </p>

            <h2 class="mt-2 text-3xl font-bold text-slate-900">
                {{ $totalBaksos }}
            </h2>

            <p class="mt-3 text-xs text-slate-400">
                Program bakti sosial
            </p>
        </div>

    </section>


    <!-- ================= CONTENT ================= -->
    <section class="space-y-6">

        <div class="flex items-end justify-between">
            <div>
                <h2 class="text-xl font-semibold text-slate-900">
                    Konten Terbaru
                </h2>
                <p class="text-sm text-slate-400">
                    Aktivitas terakhir yang ditambahkan ke sistem
                </p>
            </div>
        </div>

        <!-- TABLE SURFACE -->
        <div class="rounded-[28px] bg-white/70 backdrop-blur-xl shadow-xl overflow-hidden">

            <table class="w-full text-sm">
                <thead class="bg-slate-100/70 text-slate-600">
                    <tr>
                        <th class="px-8 py-5 text-left font-semibold">
                            Judul Konten
                        </th>
                        <th class="px-8 py-5 text-center font-semibold">
                            Tipe
                        </th>
                        <th class="px-8 py-5 text-center font-semibold">
                            Tanggal
                        </th>
                        <th class="px-8 py-5 text-right font-semibold">
                            Aksi
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">
                @forelse($latestActivities as $item)
                    <tr class="hover:bg-slate-50/60 transition">
                        <td class="px-8 py-5 font-medium text-slate-900">
                            {{ $item->title }}
                        </td>

                        <td class="px-8 py-5 text-center">
                            <span class="inline-flex items-center rounded-full px-4 py-1.5 text-xs font-semibold
                                {{ $item->type === 'news'
                                    ? 'bg-blue-100 text-blue-700'
                                    : 'bg-emerald-100 text-emerald-700' }}">
                                {{ strtoupper($item->type) }}
                            </span>
                        </td>

                        <td class="px-8 py-5 text-center text-slate-500">
                            {{ $item->created_at->format('d M Y') }}
                        </td>

                        <td class="px-8 py-5 text-right">
                            <div class="inline-flex items-center gap-4">
                                <a href="{{ route('admin.humas.activities.edit', $item) }}"
                                   class="text-indigo-600 font-medium hover:text-indigo-800">
                                    Edit
                                </a>

                                <form action="{{ route('admin.humas.activities.destroy', $item) }}"
                                      method="POST"
                                      onsubmit="return confirm('Hapus konten ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600 font-medium hover:text-red-800">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-8 py-16 text-center">
                            <p class="text-sm text-slate-400">
                                Belum ada konten yang tersedia.
                            </p>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>

        </div>

    </section>

</div>

@endsection
