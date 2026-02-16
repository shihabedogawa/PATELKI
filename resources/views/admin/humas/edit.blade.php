@extends('layouts.admin')

@section('content')

<div class="min-h-[calc(100vh-6rem)] flex items-start justify-center">

    <!-- WRAPPER -->
    <div class="w-full space-y-10">

        <!-- ================= HEADER ================= -->
        <section class="text-center space-y-2">
            <h1 class="text-2xl sm:text-3xl font-bold tracking-tight">
                Edit Konten
            </h1>
            <p class="text-sm text-slate-500">
                Perbarui Berita atau Kegiatan Bakti Sosial yang Dipublikasikan
            </p>
        </section>

        <!-- ================= ERROR ================= -->
        @if ($errors->any())
            <div class="rounded-2xl bg-red-50 p-6 text-red-700">
                <p class="font-semibold mb-2 text-sm">
                    Periksa kembali input berikut:
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
            action="{{ route('admin.humas.activities.update', $activity) }}"
            method="POST"
            enctype="multipart/form-data"
            class="space-y-8 bg-white/60 backdrop-blur-xl rounded-3xl p-8 sm:p-10 shadow-xl"
        >
            @csrf
            @method('PUT')

            <!-- JUDUL -->
            <div class="space-y-1.5">
                <label class="text-sm font-semibold text-slate-700">
                    Judul Konten
                </label>
                <input
                    name="title"
                    value="{{ old('title', $activity->title) }}"
                    placeholder="Masukkan judul konten"
                    class="w-full rounded-xl bg-slate-100 px-4 py-3 text-sm
                           focus:outline-none focus:ring-2 focus:ring-indigo-500
                           placeholder:text-slate-400"
                />
            </div>

            <!-- DESKRIPSI -->
            <div class="space-y-1.5">
                <label class="text-sm font-semibold text-slate-700">
                    Deskripsi
                </label>
                <textarea
                    name="description"
                    rows="5"
                    placeholder="Tulis deskripsi singkat konten..."
                    class="w-full rounded-xl bg-slate-100 px-4 py-3 text-sm
                           focus:outline-none focus:ring-2 focus:ring-indigo-500
                           placeholder:text-slate-400 resize-none"
                >{{ old('description', $activity->description) }}</textarea>
            </div>

            <!-- GRID -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">

                <!-- TIPE -->
                <div class="space-y-1.5">
                    <label class="text-sm font-semibold text-slate-700">
                        Tipe Konten
                    </label>
                    <select
                        name="type"
                        class="w-full rounded-xl bg-slate-100 px-4 py-3 text-sm
                               focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    >
                        <option value="news"   @selected($activity->type === 'news')>
                            Berita
                        </option>
                        <option value="baksos" @selected($activity->type === 'baksos')>
                            Baksos
                        </option>
                    </select>
                </div>

                <!-- TANGGAL -->
                <div class="space-y-1.5">
                    <label class="text-sm font-semibold text-slate-700">
                        Tanggal Kegiatan <span class="text-xs text-slate-400">(opsional)</span>
                    </label>
                    <input
                        type="date"
                        name="event_date"
                        value="{{ old('event_date', optional($activity->event_date)->format('Y-m-d')) }}"
                        class="w-full rounded-xl bg-slate-100 px-4 py-3 text-sm
                               focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    />
                </div>

            </div>

            <!-- FILE UPLOAD -->
            <div class="space-y-5">

                <div class="space-y-1.5">
                    <label class="text-sm font-semibold text-slate-700">
                        Ganti Foto <span class="text-xs text-slate-400">(opsional)</span>
                    </label>
                    <input
                        type="file"
                        name="image"
                        class="block w-full text-sm text-slate-600
                               file:mr-4 file:rounded-full file:border-0
                               file:bg-indigo-50 file:px-4 file:py-2
                               file:text-indigo-700 file:font-semibold
                               hover:file:bg-indigo-100"
                    />
                </div>

                <div class="space-y-1.5">
                    <label class="text-sm font-semibold text-slate-700">
                        Ganti PDF <span class="text-xs text-slate-400">(opsional)</span>
                    </label>
                    <input
                        type="file"
                        name="report"
                        class="block w-full text-sm text-slate-600
                               file:mr-4 file:rounded-full file:border-0
                               file:bg-emerald-50 file:px-4 file:py-2
                               file:text-emerald-700 file:font-semibold
                               hover:file:bg-emerald-100"
                    />
                </div>

            </div>

            <!-- ACTIONS -->
            <div class="flex items-center justify-center gap-5 pt-6">
                <button
                    class="inline-flex items-center justify-center rounded-full
                           bg-indigo-600 px-8 py-2.5 text-sm font-semibold text-white
                           hover:bg-indigo-700 transition"
                >
                    Simpan Perubahan
                </button>

                <a
                    href="{{ route('admin.humas.dashboard') }}"
                    class="text-sm font-medium text-slate-500 hover:text-slate-700"
                >
                    Batal
                </a>
            </div>

        </form>

    </div>

</div>

@endsection
