@extends('layouts.admin')
@section('content')

    <div class="max-w-4xl mx-auto">

        <h1 class="text-2xl font-semibold mb-6">Tambah Pelatihan</h1>

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $err)
                        <li>• {{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.pendidikan.events.store') }}" method="POST" enctype="multipart/form-data"
            class="bg-white p-6 rounded-lg shadow space-y-4">

            @csrf

            <input name="title" placeholder="Judul Pelatihan" class="w-full bg-gray-200 rounded-lg p-2" required>

            <input name="category" placeholder="Kategori" class="w-full bg-gray-200 rounded-lg p-2">

            <textarea name="description" placeholder="Deskripsi" class="w-full bg-gray-200 rounded-lg p-2" rows="4"></textarea>

            <div class="grid grid-cols-2 gap-4">
                <input type="datetime-local" name="start_date" class="bg-gray-200 p-2 rounded-lg" required>

                <input type="datetime-local" name="end_date" class="bg-gray-200 p-2 rounded-lg" required>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <input name="location" placeholder="Lokasi" class="w-full bg-gray-200 rounded-lg p-2" required>

                <input name="whatsapp" placeholder="Nomor WhatsApp Panitia (contoh: 628123456789)"
                    class="w-full bg-gray-200 rounded-lg p-2" required>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <input type="number" name="quota" placeholder="Kuota" class="bg-gray-200 p-2 rounded-lg">

                <input type="number" name="remaining_quota" placeholder="Sisa Kuota" class="bg-gray-200 p-2 rounded-lg">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <select name="status" class="w-full bg-gray-200 p-2 rounded-lg">
                    <option value="open">Pendaftaran Dibuka</option>
                    <option value="almost_full">Hampir Penuh</option>
                    <option value="closed">Ditutup</option>
                </select>

                <input type="file" name="flyer" class="w-full bg-gray-200 p-2 rounded-lg">
            </div>

            <button class="bg-emerald-600 text-white px-4 py-2 rounded-lg">
                Simpan Pelatihan
            </button>

        </form>
    </div>
@endsection
