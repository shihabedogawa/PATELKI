@extends('layouts.admin')
@section('content')

<div class="max-w-7xl mx-auto">

  <!-- HEADER -->
  <div class="flex justify-between items-center mb-6">
    <div>
      <h2 class="text-3xl font-extrabold text-gray-800">👥 Semua Anggota</h2>
      <p class="text-gray-500 text-sm">Kelola data anggota dengan mudah dan cepat</p>
    </div>
  </div>

  <!-- FILTER CARD -->
  <div class="bg-white p-5 rounded-2xl shadow-lg mb-6 border border-gray-100">
    <form method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">

      <div>
        <label class="text-sm font-semibold text-gray-600">Cari Anggota</label>
        <input name="search" value="{{ request('search') }}"
               placeholder="Nama, Email, atau NAP..."
               class="w-full border border-gray-200 p-3 rounded-xl focus:ring-2 focus:ring-green-400">
      </div>

      <div>
        <label class="text-sm font-semibold text-gray-600">Status</label>
        <select name="status"
                class="w-full border border-gray-200 p-3 rounded-xl">
          <option value="">Semua Status</option>
          <option value="pending" {{ request('status')=='pending'?'selected':'' }}>Pending</option>
          <option value="approved" {{ request('status')=='approved'?'selected':'' }}>Approved</option>
        </select>
      </div>

      <div>
        <button class="w-full bg-gradient-to-r from-green-500 to-green-700 text-white p-3 rounded-xl font-semibold shadow-md hover:opacity-90">
          🔍 Terapkan Filter
        </button>
      </div>

    </form>
  </div>

  <!-- ALERT SUCCESS -->
  @if(session('success'))
  <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg mb-6">
    ✅ {{ session('success') }}
  </div>
  @endif

  <!-- TABLE CARD -->
  <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">

    <table class="w-full">
      <thead>
        <tr class="bg-gradient-to-r from-gray-100 to-gray-200 text-gray-700">
          <th class="p-4 text-left">Nama</th>
          <th class="p-4 text-left">Email</th>
          <th class="p-4 text-left">NAP</th>
          <th class="p-4 text-left">Status</th>
          <th class="p-4 text-center">Aksi</th>
        </tr>
      </thead>

      <tbody class="divide-y">
        @foreach($members as $m)
        <tr class="hover:bg-gray-50 transition">

          <td class="p-4 font-semibold text-gray-800">
            {{ $m->name }}
          </td>

          <td class="p-4 text-gray-600">
            {{ $m->email }}
          </td>

          <td class="p-4">
            <div class="flex items-center gap-3">
              <span class="bg-gray-100 px-3 py-1 rounded-lg font-mono">
                {{ $m->nap }}
              </span>

              <button 
                onclick="openNapModal({{ $m->id }}, '{{ $m->nap }}')"
                class="bg-yellow-500 text-white px-3 py-1 rounded-lg text-sm hover:bg-yellow-600">
                ✏️ Edit
              </button>
            </div>
          </td>

          <td class="p-4">
            <span class="px-3 py-1 rounded-full text-sm font-semibold
              {{ $m->status=='approved' 
                 ? 'bg-green-100 text-green-700' 
                 : 'bg-yellow-100 text-yellow-700' }}">
              {{ ucfirst($m->status) }}
            </span>
          </td>

          <td class="p-4 text-center">
            <form action="{{ route('admin.members.destroy',$m->id) }}"
                  method="POST"
                  onsubmit="return confirm('Hapus member ini?')"
                  class="inline">

              @csrf
              @method('DELETE')

              <button type="submit"
                class="bg-red-600 text-white px-4 py-2 rounded-xl text-sm hover:bg-red-700 shadow">
                🗑 Delete
              </button>
            </form>
          </td>

        </tr>
        @endforeach
      </tbody>
    </table>

  </div>

  <div class="mt-6">
    {{ $members->links() }}
  </div>

</div>

{{-- ====== MODAL EDIT NAP (VERSI BARU & LEBIH CAKEP) ====== --}}
<div id="napModal"
     class="hidden fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center backdrop-blur-sm">

  <div class="bg-white p-6 rounded-2xl shadow-2xl w-96 transform scale-95 transition">

    <h3 class="text-xl font-bold mb-4 text-gray-800">✏️ Edit NAP</h3>

    <form id="napForm" method="POST">
      @csrf
      @method('PUT')

      <label class="block mb-2 font-semibold text-gray-700">NAP Baru</label>
      <input type="text"
             id="nap_input"
             name="nap"
             class="border w-full p-3 rounded-xl mb-4 focus:ring-2 focus:ring-green-400"
             required>

      <div class="flex justify-end gap-3">
        <button type="button"
                onclick="closeNapModal()"
                class="bg-gray-400 text-white px-4 py-2 rounded-xl hover:bg-gray-500">
          Batal
        </button>

        <button type="submit"
                class="bg-gradient-to-r from-green-500 to-green-700 text-white px-4 py-2 rounded-xl shadow">
          Simpan
        </button>
      </div>
    </form>

  </div>
</div>

<script>
function openNapModal(id, nap) {
  const modal = document.getElementById('napModal');
  const form = document.getElementById('napForm');

  document.getElementById('nap_input').value = nap;
  form.action = `/admin/members/${id}/nap`;

  modal.classList.remove('hidden');
}

function closeNapModal() {
  document.getElementById('napModal').classList.add('hidden');
}
</script>

@endsection
