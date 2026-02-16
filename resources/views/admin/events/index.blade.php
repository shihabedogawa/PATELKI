@extends('layouts.admin')
@section('content')

<div class="max-w-7xl mx-auto px-4 py-6 space-y-6">

    <!-- ================= HEADER ================= -->
    <div class="rounded-xl bg-gradient-to-br from-emerald-600 to-teal-500 px-6 py-5 text-white shadow-sm">
        <h1 class="text-lg font-semibold tracking-tight">
            Dashboard Pelatihan
        </h1>
        <p class="text-xs opacity-90 mt-0.5">
            Kelola data pelatihan & pendidikan anggota
        </p>

        <div class="mt-3">
            <a href="{{ route('admin.pendidikan.events.create') }}"
               class="inline-flex items-center bg-white text-emerald-700 font-medium px-4 py-1.5 rounded-lg text-sm shadow-sm hover:bg-emerald-50">
                ➕ Tambah
            </a>
        </div>
    </div>

    <!-- ================= STAT CARDS ================= -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">

        @php
            $stats = [
                ['label'=>'Total','value'=>$events->total(),'color'=>'text-slate-900'],
                ['label'=>'Open','value'=>$events->where('status','open')->count(),'color'=>'text-emerald-600'],
                ['label'=>'Almost Full','value'=>$events->where('status','almost_full')->count(),'color'=>'text-amber-600'],
                ['label'=>'Closed','value'=>$events->where('status','closed')->count(),'color'=>'text-slate-600'],
            ];
        @endphp

        @foreach($stats as $s)
        <div class="bg-white rounded-xl border border-slate-200 p-4 shadow-sm">
            <p class="text-[11px] text-slate-500">{{ $s['label'] }}</p>
            <p class="text-xl font-semibold mt-1 {{ $s['color'] }}">
                {{ $s['value'] }}
            </p>
        </div>
        @endforeach

    </div>

    <!-- ================= FILTER BAR ================= -->
    <div class="bg-white rounded-xl border border-slate-200 p-4 shadow-sm">
        <form method="GET" class="flex flex-col md:flex-row gap-3 md:items-center">

            <input type="text"
                   name="search"
                   value="{{ request('search') }}"
                   placeholder="Cari judul..."
                   class="flex-1 rounded-lg border border-slate-300 px-3 py-2 text-sm
                          focus:border-emerald-500 focus:ring-1 focus:ring-emerald-300">

            <select name="status"
                    class="rounded-lg border border-slate-300 px-3 py-2 text-sm
                           focus:border-emerald-500 focus:ring-1 focus:ring-emerald-300">
                <option value="">Semua Status</option>
                <option value="open" {{ request('status')=='open'?'selected':'' }}>Open</option>
                <option value="almost_full" {{ request('status')=='almost_full'?'selected':'' }}>Almost Full</option>
                <option value="closed" {{ request('status')=='closed'?'selected':'' }}>Closed</option>
            </select>

            <button class="bg-emerald-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-emerald-700">
                Filter
            </button>
        </form>
    </div>

    <!-- ================= FLASH ================= -->
    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-2.5 rounded-lg text-sm">
            ✅ {{ session('success') }}
        </div>
    @endif

    <!-- ================= TABLE ================= -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">

        <div class="px-4 py-3 flex justify-between items-center">
            <h2 class="font-medium text-sm">
                Daftar Pelatihan
            </h2>
            <span class="text-[11px] text-slate-500">
                {{ $events->count() }} data
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 text-slate-600 text-[11px] uppercase">
                    <tr>
                        <th class="p-3 text-left">Judul</th>
                        <th class="text-center">Kategori</th>
                        <th class="text-center">Tanggal</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-200">
                    @forelse($events as $event)
                    <tr class="hover:bg-slate-50 transition">

                        <td class="p-3 font-medium">
                            {{ $event->title }}
                        </td>

                        <td class="text-center text-slate-600">
                            {{ $event->category }}
                        </td>

                        <td class="text-center text-slate-600">
                            {{ \Carbon\Carbon::parse($event->start_date)->format('d M Y') }}
                        </td>

                        <td class="text-center">
                            <span class="inline-flex px-2 py-0.5 rounded-full text-[11px] font-semibold
                                {{ $event->status === 'open' ? 'bg-emerald-100 text-emerald-700' : '' }}
                                {{ $event->status === 'almost_full' ? 'bg-amber-100 text-amber-700' : '' }}
                                {{ $event->status === 'closed' ? 'bg-slate-200 text-slate-600' : '' }}">
                                {{ strtoupper($event->status) }}
                            </span>
                        </td>

                        <td class="text-center space-x-2 text-sm">
                            <a href="{{ route('admin.pendidikan.events.edit', $event) }}"
                               class="text-blue-600 hover:underline">
                                Edit
                            </a>

                            <form action="{{ route('admin.pendidikan.events.destroy', $event) }}"
                                  method="POST"
                                  class="inline">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Hapus pelatihan ini?')"
                                        class="text-red-600 hover:underline">
                                    Hapus
                                </button>
                            </form>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-8 text-center text-slate-500 text-sm">
                            Tidak ada data pelatihan
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- ================= PAGINATION ================= -->
    <div class="pt-2">
        {{ $events->links() }}
    </div>

</div>

@endsection
