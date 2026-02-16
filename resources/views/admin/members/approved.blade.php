@extends('layouts.admin')
@section('content')

<div class="space-y-6">

  {{-- ================= HEADER & METRICS ================= --}}
  <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

    <div class="bg-white p-5 rounded-2xl shadow border-l-4 border-indigo-600">
      <p class="text-xs text-gray-500">Total Anggota</p>
      <p class="text-2xl font-bold text-indigo-700">{{ $members->count() }}</p>
    </div>

    <div class="bg-white p-5 rounded-2xl shadow border-l-4 border-green-600">
      <p class="text-xs text-gray-500">Memiliki Dokumen</p>
      <p class="text-2xl font-bold text-green-700">
        {{ $members->filter(fn($m)=>$m->ijazah_file && $m->str_file)->count() }}
      </p>
    </div>

    <div class="bg-white p-5 rounded-2xl shadow border-l-4 border-yellow-500">
      <p class="text-xs text-gray-500">Belum Lengkap</p>
      <p class="text-2xl font-bold text-yellow-600">
        {{ $members->count() - $members->filter(fn($m)=>$m->ijazah_file && $m->str_file)->count() }}
      </p>
    </div>

  </div>

  {{-- ================= FILTER BAR ================= --}}
  <div class="bg-white p-4 rounded-2xl shadow">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">

      <div>
        <label class="block text-sm font-medium mb-1">Cari Nama / Email</label>
        <input type="text" id="searchMember"
               class="w-full border rounded-lg p-2 text-sm"
               placeholder="Ketik untuk mencari..."
               onkeyup="filterTable()">
      </div>

      <div>
        <label class="block text-sm font-medium mb-1">Dokumen</label>
        <select id="filterDoc"
                class="w-full border rounded-lg p-2 text-sm"
                onchange="filterTable()">
          <option value="">Semua</option>
          <option value="lengkap">Lengkap</option>
          <option value="tidak">Tidak Lengkap</option>
        </select>
      </div>

      <div>
        <label class="block text-sm font-medium mb-1">Urutkan</label>
        <select id="sortBy"
                class="w-full border rounded-lg p-2 text-sm"
                onchange="sortTable()">
          <option value="name">Nama A–Z</option>
          <option value="newest">Terbaru</option>
          <option value="oldest">Terlama</option>
        </select>
      </div>

      <div class="flex gap-2">
        <button onclick="toggleAllCheckboxes(true)"
                class="px-3 py-2 border rounded-lg text-sm">
          Pilih Semua
        </button>

        <button onclick="toggleAllCheckboxes(false)"
                class="px-3 py-2 border rounded-lg text-sm">
          Batal Pilih
        </button>
      </div>

    </div>
  </div>

  {{-- ================= TABLE ================= --}}
  <div class="bg-white rounded-2xl shadow overflow-hidden">
    <table class="w-full">
      <thead class="bg-indigo-50 text-indigo-900">
        <tr>
          <th class="p-4"></th>
          <th class="p-4 font-semibold">Nama</th>
          <th class="p-4 font-semibold">Email</th>
          <th class="p-4 font-semibold">NAP</th>
          <th class="p-4 font-semibold">Dokumen</th>
          <th class="p-4 font-semibold">Aksi</th>
        </tr>
      </thead>

      <tbody id="memberTable">
      @foreach($members as $m)
        <tr class="border-b hover:bg-gray-50 member-row"
            data-name="{{ strtolower($m->name) }}"
            data-email="{{ strtolower($m->email) }}"
            data-doc="{{ $m->ijazah_file && $m->str_file ? 'lengkap' : 'tidak' }}"
            data-created="{{ $m->created_at->timestamp }}">

          <td class="p-4 text-center">
            <input type="checkbox" class="member-check">
          </td>

          <td class="p-4 font-medium">{{ $m->name }}</td>
          <td class="p-4 text-gray-600">{{ $m->email }}</td>

          <td class="p-4">
            <div class="inline-flex items-center gap-2 bg-gray-100 px-3 py-1 rounded-lg">
              <span class="font-semibold">{{ $m->nap }}</span>
              <button onclick="openNapModal({{ $m->id }}, '{{ $m->nap }}')"
                      class="bg-yellow-500 text-white px-2 py-1 rounded text-xs">
                ✏️
              </button>
            </div>
          </td>

          {{-- ===== DOCUMENT BUTTONS (SECURE PREVIEW) ===== --}}
          <td class="p-4 flex gap-2">

            @if($m->ijazah_file)
              <button
                onclick="openPreview('{{ route('admin.files.view', [$m->id, 'ijazah']) }}','Ijazah')"
                class="bg-blue-600 text-white px-3 py-1 rounded text-sm">
                📄 Ijazah
              </button>
            @endif

            @if($m->str_file)
              <button
                onclick="openPreview('{{ route('admin.files.view', [$m->id, 'str']) }}','STR')"
                class="bg-green-600 text-white px-3 py-1 rounded text-sm">
                🧾 STR
              </button>
            @endif

            @if($m->foto_file)
              <button
                onclick="openPreview('{{ route('admin.files.view', [$m->id, 'foto']) }}','Foto')"
                class="bg-yellow-500 text-white px-3 py-1 rounded text-sm">
                🖼️ Foto
              </button>
            @endif

          </td>

          <td class="p-4">
            <form action="{{ route('admin.members.destroy',$m->id) }}"
                  method="POST"
                  onsubmit="return confirm('Hapus member ini?')">
              @csrf
              @method('DELETE')
              <button class="bg-red-600 text-white px-3 py-1 rounded text-sm">
                Delete
              </button>
            </form>
          </td>

        </tr>
      @endforeach
      </tbody>
    </table>
  </div>

</div>

{{-- ================= PREVIEW MODAL ================= --}}
<div id="previewModal"
     class="hidden fixed inset-0 z-50 bg-black/70 flex items-center justify-center">

  <div class="bg-white rounded-2xl shadow-2xl
              w-[90vw] max-w-4xl max-h-[90vh]
              flex flex-col">

    <div class="flex justify-between items-center px-5 py-3 border-b">
      <h3 id="previewTitle" class="font-semibold text-sm"></h3>
      <button onclick="closePreview()" class="text-xl text-gray-500">✕</button>
    </div>

    <div id="previewContent"
         class="flex-1 overflow-auto p-4 bg-gray-50">
    </div>

  </div>
</div>

{{-- ================= JS ================= --}}
<script>
function openPreview(url, title) {
  document.getElementById('previewTitle').innerText = title;
  const content = document.getElementById('previewContent');

  const isPdf = url.toLowerCase().endsWith('.pdf');

  content.innerHTML = isPdf
  ? `
    <embed 
      src="${url}" 
      type="application/pdf"
      class="w-full h-[70vh] rounded-lg"
    >
    `
  : `
    <img 
      src="${url}" 
      class="max-w-full max-h-[70vh] mx-auto rounded-lg object-contain"
    >
    `;

  document.getElementById('previewModal').classList.remove('hidden');
}

function closePreview() {
  document.getElementById('previewContent').innerHTML = '';
  document.getElementById('previewModal').classList.add('hidden');
}

document.addEventListener('keydown', e => {
  if (e.key === 'Escape') closePreview();
});

document.getElementById('previewModal')
  .addEventListener('click', e => {
    if (e.target.id === 'previewModal') closePreview();
  });
</script>

@endsection
