@extends('layouts.admin')
@section('content')

<div class="space-y-6">

{{-- ================= ALERT SUCCESS ================= --}}
@if(session('success'))
<div class="bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded-xl shadow">
  ✅ {{ session('success') }}
</div>
@endif

{{-- ================= HEADER + METRICS ================= --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-4">

  <div class="bg-white p-5 rounded-2xl shadow border-l-4 border-indigo-600">
    <p class="text-xs text-gray-500">Total Pending</p>
    <p class="text-2xl font-bold text-indigo-700">{{ $members->count() }}</p>
  </div>

  <div class="bg-white p-5 rounded-2xl shadow border-l-4 border-green-600">
    <p class="text-xs text-gray-500">Siap Disetujui</p>
    <p class="text-2xl font-bold text-green-700">
      {{ $members->where('nap','!=',null)->count() }}
    </p>
  </div>

  <div class="bg-white p-5 rounded-2xl shadow border-l-4 border-yellow-500">
    <p class="text-xs text-gray-500">NAP Kosong</p>
    <p class="text-2xl font-bold text-yellow-600">
      {{ $members->where('nap',null)->count() }}
    </p>
  </div>
</div>

{{-- ================= FILTER BAR ================= --}}
<div class="bg-white p-4 rounded-2xl shadow">
  <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <div>
      <label class="block text-sm font-medium mb-1">Cari Nama / Email</label>
      <input type="text" id="searchMember"
        class="w-full border rounded-lg p-2 text-sm"
        placeholder="Ketik untuk mencari..."
        onkeyup="filterTable()">
    </div>

    <div>
      <label class="block text-sm font-medium mb-1">Status</label>
      <select id="filterStatus"
        class="w-full border rounded-lg p-2 text-sm"
        onchange="filterTable()">
        <option value="">Semua</option>
        <option value="pending">Pending</option>
        <option value="approved">Approved</option>
      </select>
    </div>
  </div>
</div>

{{-- ================= TABLE ================= --}}
<div class="bg-white rounded-2xl shadow overflow-hidden">
<table class="w-full">
<thead class="bg-indigo-50 text-indigo-900">
<tr>
  <th class="p-4 font-semibold">Nama</th>
  <th class="p-4 font-semibold">Email</th>
  <th class="p-4 font-semibold">NAP</th>
  <th class="p-4 font-semibold">Status</th>
  <th class="p-4 font-semibold text-center">Aksi</th>
</tr>
</thead>

<tbody id="memberTable">
@foreach ($members as $m)
<tr class="border-b hover:bg-gray-50 transition member-row"
    data-name="{{ strtolower($m->name) }}"
    data-email="{{ strtolower($m->email) }}"
    data-status="{{ strtolower($m->status) }}">

  {{-- NAMA --}}
  <td class="p-4 font-medium">
    <div class="flex items-center gap-3">
      <div class="w-9 h-9 bg-indigo-100 text-indigo-700 rounded-full flex items-center justify-center font-bold">
        {{ strtoupper(substr($m->name,0,1)) }}
      </div>
      {{ $m->name }}
    </div>
  </td>

  {{-- EMAIL --}}
  <td class="p-4 text-gray-600">{{ $m->email }}</td>

  {{-- NAP --}}
  <td class="p-4">
    <div class="inline-flex items-center gap-2 bg-gray-100 px-3 py-1 rounded-lg">
      <span class="font-semibold">{{ $m->nap ?? '-' }}</span>
      <button onclick="openNapModal({{ $m->id }}, '{{ $m->nap }}')"
        class="bg-yellow-500 hover:bg-yellow-600 text-white px-2 py-1 rounded text-xs">
        ✏️
      </button>
    </div>
  </td>

  {{-- STATUS --}}
  <td class="p-4">
    <span class="
      {{ $m->status === 'pending'
          ? 'bg-yellow-100 text-yellow-700'
          : 'bg-green-100 text-green-700' }}
      px-3 py-1 rounded-full text-sm font-semibold">
      {{ ucfirst($m->status) }}
    </span>
  </td>

  {{-- AKSI --}}
  <td class="p-4">
    <div class="flex justify-center gap-2">
      <form action="{{ route('admin.members.approve', $m->id) }}" method="POST">
        @csrf
        <button class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded-lg text-sm shadow">
          Approve
        </button>
      </form>

      <form action="{{ route('admin.members.destroy', $m->id) }}"
            method="POST"
            onsubmit="return confirm('Yakin hapus member ini?')">
        @csrf
        @method('DELETE')
        <button class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded-lg text-sm shadow">
          Delete
        </button>
      </form>
    </div>
  </td>

</tr>
@endforeach
</tbody>
</table>
</div>

{{-- ================= MODAL EDIT NAP (WOW) ================= --}}
<div id="napModal"
 class="hidden fixed inset-0 bg-black bg-opacity-60 backdrop-blur-sm flex items-center justify-center">

  <div class="bg-white p-6 rounded-2xl shadow-2xl w-[420px]">
    <div class="flex justify-between items-center mb-4">
      <h3 class="text-lg font-bold">Edit NAP Anggota</h3>
      <button onclick="closeNapModal()" class="text-gray-400 hover:text-black">✕</button>
    </div>

    <form id="napForm" method="POST">
      @csrf
      @method('PUT')

      <input type="hidden" id="member_id">

      <label class="block mb-2 font-medium">NAP Baru</label>
      <input type="text" id="nap_input" name="nap"
        class="border w-full p-3 rounded-xl mb-4" required>

      <div class="flex justify-end gap-2">
        <button type="button" onclick="closeNapModal()"
          class="bg-gray-400 text-white px-4 py-2 rounded-xl">
          Batal
        </button>

        <button type="submit"
          class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-xl shadow">
          Simpan
        </button>
      </div>
    </form>
  </div>
</div>

{{-- ================= SCRIPT ================= --}}
<script>
function openNapModal(id, nap) {
  document.getElementById('nap_input').value = nap ?? '';
  document.getElementById('member_id').value = id;
  document.getElementById('napForm').action = `/admin/members/${id}/nap`;
  document.getElementById('napModal').classList.remove('hidden');
}
function closeNapModal() {
  document.getElementById('napModal').classList.add('hidden');
}
function filterTable(){
  const search = document.getElementById('searchMember').value.toLowerCase();
  const status = document.getElementById('filterStatus').value;

  document.querySelectorAll('.member-row').forEach(row => {
    const matchText =
      row.dataset.name.includes(search) ||
      row.dataset.email.includes(search);

    const matchStatus =
      status === '' || row.dataset.status === status;

    row.style.display = (matchText && matchStatus) ? '' : 'none';
  });
}
</script>

</div>
@endsection
