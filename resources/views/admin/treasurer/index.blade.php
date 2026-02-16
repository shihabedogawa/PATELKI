{{-- resources/views/admin/treasurer/index.blade.php --}}
@extends('layouts.admin')

@section('content')
<div class="p-6 space-y-8">

  {{-- =================== HERO + ACTION BAR =================== --}}
  <div class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white rounded-3xl p-6 shadow-xl">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
      <div>
        <h1 class="text-2xl font-bold">Bendahara Dashboard</h1>
        <p class="text-blue-100 text-sm">Atur iuran, verifikasi pembayaran, dan pantau kas organisasi dalam satu layar.</p>
      </div>
      <div class="bg-white/10 backdrop-blur border border-white/20 rounded-2xl px-5 py-3">
        <p class="text-xs text-blue-100">Saldo Kas Saat Ini</p>
        <p class="text-xl font-bold">Rp {{ number_format($kas->total_balance ?? 0,0,',','.') }}</p>
      </div>
    </div>
  </div>

  {{-- =================== PANEL ATUR IURAN (WOW VERSION) =================== --}}
  <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
    <div class="bg-gradient-to-r from-gray-900 to-gray-800 text-white p-4">
      <h3 class="font-semibold">⚡ Atur Iuran Baru (Berlaku Global untuk Semua Member)</h3>
      <p class="text-xs text-gray-300">Perubahan akan otomatis berlaku sejak bulan & tahun yang dipilih.</p>
    </div>

    <form action="{{ route('treasurer.dues.store') }}" method="POST" class="p-6 grid grid-cols-1 md:grid-cols-3 gap-4">
      @csrf

      <div class="space-y-1">
        <label class="text-sm font-medium">Nominal Iuran (Rp)</label>
        <div class="relative">
          <span class="absolute left-3 top-2.5 text-gray-400">Rp</span>
          <input type="number" name="amount" class="w-full border rounded-xl p-2 pl-9 focus:ring-2 focus:ring-blue-500" required placeholder="60000">
        </div>
      </div>

      <div class="space-y-1">
        <label class="text-sm font-medium">Berlaku Mulai Bulan</label>
        <select name="start_month" class="w-full border rounded-xl p-2">
          @foreach(['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $m)
          <option value="{{ $m }}">{{ $m }}</option>
          @endforeach
        </select>
      </div>

      <div class="space-y-1">
        <label class="text-sm font-medium">Tahun Berlaku</label>
        <input type="number" name="start_year" value="{{ now()->year }}" class="w-full border rounded-xl p-2">
      </div>

      <div class="md:col-span-3 space-y-1">
        <label class="text-sm font-medium">Catatan Perubahan (opsional)</label>
        <textarea name="note" rows="2" class="w-full border rounded-xl p-2" placeholder="Contoh: penyesuaian operasional dan inflasi"></textarea>
      </div>

      <div class="md:col-span-3">
        <button class="w-full md:w-auto bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-xl shadow transition">
          Simpan Aturan Iuran Baru
        </button>
      </div>
    </form>
  </div>

  {{-- =================== METRICS DASHBOARD =================== --}}
  <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <div class="bg-white p-5 rounded-2xl shadow border-l-4 border-blue-600">
      <p class="text-sm text-gray-500">Menunggu Verifikasi</p>
      <p class="text-2xl font-bold">{{ $payments->count() }}</p>
    </div>
    <div class="bg-white p-5 rounded-2xl shadow border-l-4 border-green-600">
      <p class="text-sm text-gray-500">Total Potensi Kas</p>
      <p class="text-2xl font-bold">
        Rp {{ number_format($payments->sum(fn($p) => $p->billing->amount),0,',','.') }}
      </p>
    </div>
    <div class="bg-white p-5 rounded-2xl shadow border-l-4 border-indigo-600">
      <p class="text-sm text-gray-500">Bulan Paling Banyak</p>
      <p class="text-2xl font-bold">
        {{ $payments->groupBy(fn($p) => $p->billing->bulan)->sortDesc()->keys()->first() ?? '-' }}
      </p>
    </div>
  </div>

  {{-- =================== FILTER BAR =================== --}}
  <div class="bg-white p-4 rounded-2xl shadow">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
      <div>
        <label class="block text-sm font-medium mb-1">Cari Member</label>
        <input type="text" id="searchMember" placeholder="Ketik nama..."
          class="w-full border rounded-xl p-2 text-sm" onkeyup="filterCards()">
      </div>
      <div>
        <label class="block text-sm font-medium mb-1">Bulan</label>
        <select id="filterMonth" class="w-full border rounded-xl p-2 text-sm" onchange="filterCards()">
          <option value="">Semua Bulan</option>
          <option>Januari</option><option>Februari</option><option>Maret</option>
          <option>April</option><option>Mei</option><option>Juni</option>
          <option>Juli</option><option>Agustus</option><option>September</option>
          <option>Oktober</option><option>November</option><option>Desember</option>
        </select>
      </div>
      <div>
        <label class="block text-sm font-medium mb-1">Urutkan</label>
        <select id="sortBy" class="w-full border rounded-xl p-2 text-sm" onchange="sortCards()">
          <option value="newest">Terbaru</option>
          <option value="oldest">Terlama</option>
          <option value="name">Nama A–Z</option>
        </select>
      </div>
      <div class="flex items-end">
        <button onclick="resetFilter()" class="px-4 py-2 border rounded-xl text-sm">Reset</button>
      </div>
    </div>
  </div>

  {{-- =================== CARD GRID =================== --}}
  <div id="cardContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
    @forelse($payments as $pay)
    <div class="pay-card bg-white rounded-2xl shadow hover:shadow-xl transition p-4" 
         data-name="{{ strtolower($pay->billing->member->name ?? '') }}"
         data-month="{{ strtolower($pay->billing->bulan) }}"
         data-created="{{ $pay->created_at->timestamp }}">

      <div class="flex justify-between items-start mb-3">
        <div>
          <p class="font-semibold">{{ $pay->billing->member->name ?? 'Member' }}</p>
          <p class="text-xs text-gray-500">
            Diajukan: {{ $pay->created_at->translatedFormat('d M Y H:i') }}
          </p>
        </div>
        <span class="bg-blue-100 text-blue-700 text-xs px-2 py-1 rounded">Menunggu</span>
      </div>

      <div class="bg-gray-50 rounded-xl p-3 mb-3">
        <p class="text-sm">{{ $pay->billing->bulan }} {{ $pay->billing->tahun }}</p>
        <p class="font-bold text-blue-600">
          Rp {{ number_format($pay->billing->amount,0,',','.') }}
        </p>
      </div>

      {{-- Thumbnail bukti --}}
      <div class="mb-3 relative">
        <img src="{{ asset('storage/'.$pay->proof_path) }}" 
             class="w-full h-40 object-cover rounded-xl cursor-pointer"
             onclick="openProof('{{ asset('storage/'.$pay->proof_path) }}')">
        <a href="{{ asset('storage/'.$pay->proof_path) }}" download
           class="absolute bottom-2 right-2 bg-white text-xs px-2 py-1 rounded shadow">
           Download
        </a>
      </div>

      <div class="flex gap-2">
        <form action="{{ route('treasurer.approve', $pay->id) }}" method="POST" class="flex-1">
          @csrf
          <button class="w-full bg-green-600 text-white py-2 rounded-xl text-sm">Approve</button>
        </form>

        <form action="{{ route('treasurer.reject', $pay->id) }}" method="POST" class="flex-1">
          @csrf
          <button class="w-full bg-red-600 text-white py-2 rounded-xl text-sm">Reject</button>
        </form>
      </div>
    </div>
    @empty
    <div class="col-span-full text-center text-gray-500 bg-white p-6 rounded-2xl shadow">
      Tidak ada pembayaran yang menunggu verifikasi.
    </div>
    @endforelse
  </div>
</div>

{{-- MODAL PREVIEW --}}
<div id="proofModal" class="hidden fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center">
  <div class="bg-white rounded-2xl w-[600px] p-6 shadow-2xl">
    <div class="flex justify-between items-center mb-4">
      <h3 class="font-bold">Bukti Pembayaran</h3>
      <button onclick="closeProof()" class="text-gray-500 hover:text-black">✕</button>
    </div>
    <img id="proofImage" src="" class="w-full rounded-lg" />
  </div>
</div>

<script>
function openProof(url){
  document.getElementById('proofImage').src = url;
  document.getElementById('proofModal').classList.remove('hidden');
}
function closeProof(){
  document.getElementById('proofModal').classList.add('hidden');
}

function filterCards(){
  const search = document.getElementById('searchMember').value.toLowerCase();
  const month = document.getElementById('filterMonth').value.toLowerCase();
  document.querySelectorAll('.pay-card').forEach(card => {
    const matchName = card.dataset.name.includes(search);
    const matchMonth = month === '' || card.dataset.month.includes(month);
    card.style.display = (matchName && matchMonth) ? '' : 'none';
  });
}

function sortCards(){
  const container = document.getElementById('cardContainer');
  const cards = Array.from(container.querySelectorAll('.pay-card'));
  const mode = document.getElementById('sortBy').value;

  cards.sort((a,b)=>{
    if(mode === 'newest') return b.dataset.created - a.dataset.created;
    if(mode === 'oldest') return a.dataset.created - b.dataset.created;
    if(mode === 'name') return a.dataset.name.localeCompare(b.dataset.name);
  });

  cards.forEach(c => container.appendChild(c));
}

function resetFilter(){
  document.getElementById('searchMember').value = '';
  document.getElementById('filterMonth').value = '';
  document.getElementById('sortBy').value = 'newest';
  filterCards();
  sortCards();
}
</script>
@endsection