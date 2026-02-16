@extends('layouts.admin')

@section('content')

<div class="min-h-[calc(100vh-6rem)] flex justify-center">

    <!-- PAGE WRAPPER -->
    <div class="w-full space-y-12">

        <!-- ================= HEADER ================= -->
        <header class="text-center space-y-3">
            <h1 class="text-3xl font-bold tracking-tight text-slate-900">
                Tambah Berita / Kegiatan
            </h1>
            <p class="text-base text-slate-500 leading-relaxed">
                Buat dan publikasikan konten resmi Divisi Humas secara profesional dan terstruktur.
            </p>
        </header>

        <!-- ================= ERROR ================= -->
        @if ($errors->any())
            <div class="rounded-3xl bg-red-50 px-6 py-5 text-red-700">
                <p class="font-semibold mb-2 text-sm">
                    Terdapat kesalahan pada input:
                </p>
                <ul class="list-disc pl-5 text-sm space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- ================= FORM CARD ================= -->
        <form
            action="{{ route('admin.humas.activities.store') }}"
            method="POST"
            enctype="multipart/form-data"
            class="bg-white/70 backdrop-blur-xl rounded-[32px] px-10 py-12 shadow-2xl space-y-10"
        >
            @csrf

            <!-- SECTION: BASIC INFO -->
            <section class="space-y-6">
                <h2 class="text-sm font-semibold uppercase tracking-wider text-slate-400">
                    Informasi Utama
                </h2>

                <!-- JUDUL -->
                <div class="space-y-2">
                    <label class="text-sm font-medium text-slate-700">
                        Judul Konten
                    </label>
                    <input
                        type="text"
                        name="title"
                        placeholder="Contoh: Pemeriksaan Kesehatan Gratis di Desa Sukamaju"
                        class="w-full rounded-2xl bg-slate-100 px-5 py-3.5 text-sm
                               focus:outline-none focus:ring-2 focus:ring-emerald-500
                               placeholder:text-slate-400"
                    />
                </div>

                <!-- DESKRIPSI -->
                <div class="space-y-2">
                    <label class="text-sm font-medium text-slate-700">
                        Deskripsi
                    </label>
                    <textarea
                        name="description"
                        rows="5"
                        placeholder="Jelaskan secara singkat tujuan dan rangkaian kegiatan..."
                        class="w-full rounded-2xl bg-slate-100 px-5 py-3.5 text-sm
                               focus:outline-none focus:ring-2 focus:ring-emerald-500
                               placeholder:text-slate-400 resize-none"
                    ></textarea>
                </div>
            </section>

            <!-- SECTION: MEDIA -->
            <section class="space-y-6">
                <h2 class="text-sm font-semibold uppercase tracking-wider text-slate-400">
                    Media Pendukung
                </h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">

                    <!-- FOTO -->
                    <div class="space-y-2">
                        <label class="text-sm font-medium text-slate-700">
                            Foto Kegiatan
                        </label>
                        <input
                            type="file"
                            name="image"
                            class="block w-full text-sm text-slate-600
                                   file:mr-4 file:rounded-full file:border-0
                                   file:bg-emerald-50 file:px-5 file:py-2.5
                                   file:text-emerald-700 file:font-semibold
                                   hover:file:bg-emerald-100"
                        />
                    </div>

                    <!-- PDF -->
                    <div class="space-y-2">
                        <label class="text-sm font-medium text-slate-700">
                            File Laporan (PDF)
                        </label>
                        <input
                            type="file"
                            name="report"
                            class="block w-full text-sm text-slate-600
                                   file:mr-4 file:rounded-full file:border-0
                                   file:bg-indigo-50 file:px-5 file:py-2.5
                                   file:text-indigo-700 file:font-semibold
                                   hover:file:bg-indigo-100"
                        />
                    </div>

                </div>
            </section>

            <!-- SECTION: META -->
            <section class="space-y-6">
                <h2 class="text-sm font-semibold uppercase tracking-wider text-slate-400">
                    Pengaturan Konten
                </h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">

                    <!-- TIPE -->
                    <div class="space-y-2">
                        <label class="text-sm font-medium text-slate-700">
                            Tipe Konten
                        </label>
                        <select
                            name="type"
                            class="w-full rounded-2xl bg-slate-100 px-5 py-3.5 text-sm
                                   focus:outline-none focus:ring-2 focus:ring-emerald-500"
                        >
                            <option value="news">Berita</option>
                            <option value="baksos">Baksos</option>
                        </select>
                    </div>

                    <!-- TANGGAL -->
                    <div class="space-y-2">
                        <label class="text-sm font-medium text-slate-700">
                            Tanggal Kegiatan
                            <span class="text-xs text-slate-400">(opsional)</span>
                        </label>
                        <input
                            type="date"
                            name="event_date"
                            class="w-full rounded-2xl bg-slate-100 px-5 py-3.5 text-sm
                                   focus:outline-none focus:ring-2 focus:ring-emerald-500"
                        />
                    </div>

                </div>
            </section>

            <!-- ACTIONS -->
            <div class="pt-8 flex justify-center">
                <button
                    type="submit"
                    class="inline-flex items-center justify-center
                           rounded-full bg-emerald-600 px-12 py-3
                           text-sm font-semibold text-white
                           hover:bg-emerald-700 transition"
                >
                    Publikasikan Konten
                </button>
            </div>

        </form>

    </div>

</div>

@endsection
