@extends('layouts.main')
@section('container')

<div class="min-h-screen bg-gray-50 py-15">
<div class="max-w-6xl mx-auto px-4">

@include('partials.whatsapp-popup')

  {{-- ================= HERO ================= --}}
  <div class="text-center relative overflow-hidden rounded-3xl mb-8 shadow-2xl">
    <div class="absolute inset-0 bg-gradient-to-r from-emerald-700 to-blue-700"></div>
    <div class="relative p-8 md:p-10 text-white">
      <h1 class="text-2xl md:text-3xl font-bold">Pendaftaran Anggota SIMK PATELKI</h1>
      <p class="mt-2 text-emerald-100">Sistem Informasi Manajemen Keanggotaan</p>
      <div class="mt-4 inline-flex items-center gap-2 bg-white/20 backdrop-blur px-4 py-2 rounded-xl text-sm">
        <span>⏱️ Verifikasi 1–3 hari kerja</span>
        <span class="hidden md:inline">•</span>
        <span class="hidden md:inline">Dokumen maksimal 200 KB</span>
      </div>
    </div>
  </div>

  {{-- ================= CARD UTAMA ================= --}}
  <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="POST" action="{{ route('simk.register.submit') }}" enctype="multipart/form-data"
      class="p-6 md:p-10 space-y-8" onsubmit="return validateFileSize()" id="registerForm">
      @csrf

      {{-- STEP INDICATOR PRO (ANIMATED) --}}
      <div class="grid grid-cols-4 gap-3 text-sm" id="steps">
        @foreach(['Data Pribadi','Legal','Akun','Dokumen'] as $i=>$step)
        <div class="step-item bg-gray-50 text-gray-600 p-3 rounded-xl text-center font-semibold transition">
          <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-gray-200 text-gray-700 mr-2">{{ $i+1 }}</span>
          {{ $step }}
        </div>
        @endforeach
      </div>

      {{-- DATA PRIBADI --}}
      <section class="space-y-4 section" data-step="0">
        <div class="flex items-center gap-2">
          <h2 class="text-lg font-semibold text-emerald-800">Data Pribadi</h2>
          <span class="status-badge text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded">0/6 terisi</span>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-10 gap-y-6">

          <div>
            <label class="block text-sm font-medium mb-1">Nama Lengkap</label>
            <input type="text" name="name" class="field w-full border rounded-xl p-3 focus:ring-2 focus:ring-emerald-400" required>
          </div>

          <div>
            <label class="block text-sm font-medium mb-1">Pendidikan</label>
            <input type="text" name="pendidikan" class="field w-full border rounded-xl p-3 focus:ring-2 focus:ring-emerald-400" required>
          </div>

          <div>
            <label class="block text-sm font-medium mb-1">Tanggal Lahir</label>
            <input type="date" name="tanggal_lahir" class="field w-full border rounded-xl p-3 focus:ring-2 focus:ring-emerald-400" required>
          </div>

          <div>
            <label class="block text-sm font-medium mb-1">Tahun Lulus</label>
            <input type="number" name="tahun_lulus" class="field w-full border rounded-xl p-3 focus:ring-2 focus:ring-emerald-400" required>
          </div>

          <div>
            <label class="block text-sm font-medium mb-1">Jenis Kelamin</label>
            <select name="jenis_kelamin" class="field w-full border rounded-xl p-3 focus:ring-2 focus:ring-emerald-400" required>
              <option value="">-- Pilih --</option>
              <option value="Laki-laki">Laki-laki</option>
              <option value="Perempuan">Perempuan</option>
            </select>
          </div>

          <div>
            <label class="block text-sm font-medium mb-1">Tempat Kerja (Opsional)</label>
            <input type="text" name="tempat_kerja" class="field w-full border rounded-xl p-3 focus:ring-2 focus:ring-emerald-400">
          </div>
        </div>
      </section>

      <hr class="border-gray-200">

      {{-- DATA LEGAL --}}
      <section class="space-y-4 section" data-step="1">
        <div class="flex items-center gap-2">
          <h2 class="text-lg font-semibold text-emerald-800">Data Legal</h2>
          <span class="status-badge text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded">0/2 terisi</span>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium mb-1">Nomor STR</label>
            <input type="text" name="no_str" class="field w-full border rounded-xl p-3 focus:ring-2 focus:ring-emerald-400" required>
          </div>
          <div>
            <label class="block text-sm font-medium mb-1">Nomor Ijazah</label>
            <input type="text" name="no_ijazah" class="field w-full border rounded-xl p-3 focus:ring-2 focus:ring-emerald-400" required>
          </div>
        </div>
      </section>

      <hr class="border-gray-200">

      {{-- AKUN --}}
      <section class="space-y-4 section" data-step="2">
        <div class="flex items-center gap-2">
          <h2 class="text-lg font-semibold text-emerald-800">Akun</h2>
          <span class="status-badge text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded">0/2 terisi</span>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium mb-1">Email Aktif</label>
            <input type="email" name="email" class="field w-full border rounded-xl p-3 focus:ring-2 focus:ring-emerald-400" required>
          </div>
          <div>
            <label class="block text-sm font-medium mb-1">Password</label>
            <input type="password" name="password" class="field w-full border rounded-xl p-3 focus:ring-2 focus:ring-emerald-400" required>
          </div>
        </div>
      </section>

      <hr class="border-gray-200">

      {{-- DOKUMEN (DROPZONE + DRAG & DROP + PREVIEW FOTO) --}}
      <section class="space-y-4 section" data-step="3">
        <div class="flex items-center gap-2">
          <h2 class="text-lg font-semibold text-emerald-800 text-center">Upload Dokumen</h2>
          <span class="status-badge text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded">0/3 terisi</span>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-sm">

          @foreach([
            ['label'=>'Ijazah (PDF)','name'=>'ijazah','accept'=>'application/pdf'],
            ['label'=>'STR (PDF)','name'=>'str','accept'=>'application/pdf'],
            ['label'=>'Foto (Latar Merah)','name'=>'foto','accept'=>'image/jpeg']
          ] as $doc)
          <div class="doc-card border-2 border-dashed rounded-2xl p-5 hover:border-emerald-500 transition bg-gray-50 drag-area" data-input="{{ $doc['name'] }}">
            <p class="font-medium text-center mb-3">{{ $doc['label'] }}</p>
            <div class="flex flex-col items-center">
              <div class="w-20 h-20 mb-2 rounded-full bg-gray-200 overflow-hidden hidden" id="thumb-{{ $doc['name'] }}">
                <img src="" class="w-full h-full object-cover" />
              </div>
              <label class="flex flex-col items-center justify-center w-full px-4 py-4 border rounded-xl cursor-pointer bg-white hover:bg-emerald-50 transition">
                <span class="text-emerald-700 font-semibold">Klik atau seret file ke sini</span>
                <span class="text-xs text-gray-500 mt-1">Max 200 KB</span>
                <input type="file" name="{{ $doc['name'] }}" accept="{{ $doc['accept'] }}" required class="hidden doc-input" id="{{ $doc['name'] }}">
              </label>
              <div id="preview-{{ $doc['name'] }}" class="mt-3 text-center text-xs text-gray-600">Belum ada file</div>
            </div>
          </div>
          @endforeach
        </div>
      </section>

      {{-- PROGRESS BAR GLOBAL --}}
      <div class="w-full bg-gray-100 rounded-full h-2">
        <div id="formProgress" class="bg-gradient-to-r from-emerald-600 to-blue-600 h-2 rounded-full w-0 transition-all duration-500"></div>
      </div>

      <button type="submit" class="w-full bg-gradient-to-r from-emerald-600 to-blue-600 hover:opacity-90 text-white py-3 rounded-xl font-semibold shadow-lg">
        Daftar SIMK
      </button>
    </form>
  </div>

  <br>
@include('footer')

  {{-- POPUP SUKSES --}}
  @if (session('success'))
  <div class="fixed inset-0 bg-black/40 flex items-center justify-center">
    <div class="bg-white p-6 rounded-2xl max-w-md shadow-xl">
      <h3 class="font-semibold mb-3">🎉 Pendaftaran Berhasil</h3>
      <ul class="text-sm list-disc list-inside space-y-1">
        <li>Menunggu verifikasi maksimal 3 hari kerja</li>
        <li>Verifikasi melalui Email</li>
        <li>Mohon pantau status pendaftaran</li>
      </ul>
      <div class="text-right mt-4">
        <a href="{{ route('simk.register') }}" class="text-emerald-700 font-semibold">Tutup</a>
      </div>
    </div>
  </div>
  @endif

  </div>
</div>

<script>
// ===== VALIDASI UKURAN FILE =====
function validateFileSize() {
  const files = document.querySelectorAll('input[type="file"]');
  for (let file of files) {
    if (file.files[0] && file.files[0].size > 200 * 1024) {
      alert("Ukuran file tidak boleh lebih dari 200 KB");
      file.value = "";
      return false;
    }
  }
  return true;
}

// ===== PREVIEW FILE + FOTO THUMBNAIL =====
const docInputs = document.querySelectorAll('.doc-input');
const progress = document.getElementById('formProgress');
const allFields = document.querySelectorAll('.field');

function updateProgress(){
  const filledFields = Array.from(allFields).filter(f => f.value.trim() !== '').length;
  const totalFields = allFields.length;
  const filledDocs = Array.from(docInputs).filter(i => i.files[0]).length;
  const totalDocs = docInputs.length;
  const percent = ((filledFields/totalFields)*70) + ((filledDocs/totalDocs)*30);
  progress.style.width = percent + '%';
}

function updateSectionBadges(){
  document.querySelectorAll('.section').forEach(sec => {
    const badge = sec.querySelector('.status-badge');
    const fields = sec.querySelectorAll('.field');
    const inputs = sec.querySelectorAll('.doc-input');
    let total = fields.length + inputs.length;
    let filled = Array.from(fields).filter(f => f.value.trim() !== '').length +
                 Array.from(inputs).filter(i => i.files[0]).length;
    badge.textContent = filled + '/' + total + ' terisi';
  });
}

function highlightStep(){
  const steps = document.querySelectorAll('#steps .step-item');
  document.querySelectorAll('.section').forEach((sec, idx) => {
    const rect = sec.getBoundingClientRect();
    if(rect.top >= 0 && rect.top < window.innerHeight/2){
      steps.forEach(s => s.classList.remove('bg-emerald-100','text-emerald-800'));
      steps[idx].classList.add('bg-emerald-100','text-emerald-800');
    }
  });
}

window.addEventListener('scroll', highlightStep);

// Handle file change + drag & drop
function handleFile(input, file){
  if(file.size > 200*1024){ alert('File terlalu besar'); return; }
  const preview = document.getElementById('preview-' + input.id);
  preview.innerHTML = '✔️ ' + file.name + ' (' + Math.round(file.size/1024) + ' KB)';
  
  // preview foto thumbnail
  if(input.id === 'foto'){
    const thumb = document.getElementById('thumb-foto');
    const img = thumb.querySelector('img');
    img.src = URL.createObjectURL(file);
    thumb.classList.remove('hidden');
  }
  updateProgress();
  updateSectionBadges();
}

docInputs.forEach(inp => {
  inp.addEventListener('change', e => handleFile(inp, e.target.files[0]));
});

// Drag & Drop
const dropAreas = document.querySelectorAll('.drag-area');
dropAreas.forEach(area => {
  const inputId = area.dataset.input;
  const input = document.getElementById(inputId);
  area.addEventListener('dragover', e => { e.preventDefault(); area.classList.add('border-emerald-600'); });
  area.addEventListener('dragleave', e => { area.classList.remove('border-emerald-600'); });
  area.addEventListener('drop', e => {
    e.preventDefault(); area.classList.remove('border-emerald-600');
    const file = e.dataTransfer.files[0];
    if(file){
      const dt = new DataTransfer(); dt.items.add(file);
      input.files = dt.files;
      handleFile(input, file);
    }
  });
});

// realtime badges for text fields
allFields.forEach(f => {
  f.addEventListener('input', () => { updateProgress(); updateSectionBadges(); });
});

// init
updateProgress(); updateSectionBadges(); highlightStep();
</script>
@endsection