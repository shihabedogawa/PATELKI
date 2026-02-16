@extends('layouts.main')
@section ('container')

<h2 class="text-2xl font-bold mb-6">Jadwal Pelatihan PATELKI</h2>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach ($jadwal as $item)
        <div class="bg-white rounded-xl shadow hover:shadow-lg transition p-6">
            <h3 class="text-lg font-semibold mb-2">
                {{ $item['judul'] }}
            </h3>

            <p class="text-sm text-gray-600 mb-1">
                📅 {{ $item['tanggal'] }}
            </p>

            <p class="text-sm text-gray-600 mb-4">
                📍 {{ $item['lokasi'] }}
            </p>

            @if ($item['status'] === 'Dibuka')
                <span class="inline-block bg-green-100 text-green-700 text-xs px-3 py-1 rounded-full mb-4">
                    Dibuka
                </span>
            @elseif ($item['status'] === 'Penuh')
                <span class="inline-block bg-yellow-100 text-yellow-700 text-xs px-3 py-1 rounded-full mb-4">
                    Penuh
                </span>
            @else
                <span class="inline-block bg-gray-200 text-gray-700 text-xs px-3 py-1 rounded-full mb-4">
                    Selesai
                </span>
            @endif

            <div class="mt-4">
                @if ($item['status'] === 'Dibuka')
                    <a href="#"
                       class="block text-center bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition">
                        Daftar Sekarang
                    </a>
                @else
                    <button disabled
                        class="block w-full bg-gray-300 text-gray-600 py-2 rounded-lg cursor-not-allowed">
                        Pendaftaran Ditutup
                    </button>
                @endif
            </div>
        </div>
    @endforeach
</div>



@endsection