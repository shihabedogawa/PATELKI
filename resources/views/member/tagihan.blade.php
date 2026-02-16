@extends('layouts.member')
@section('container')

    {{-- Header --}}
    <div class="flex justify-between items-center mb-6">
      <div>
        <h2 class="text-2xl font-bold">Tagihan Iuran</h2>
        <p class="text-gray-500">Kelola dan pantau tagihan bulanan Anda</p>
      </div> 
      <div class="bg-white px-4 py-2 rounded shadow text-sm">
        <span class="font-semibold">Status Anda:</span>
        <span class="text-green-600">Aktif</span>
      </div>
    </div>

    {{-- Ringkasan --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
      <div class="bg-white p-5 rounded-lg shadow">
        <p class="text-gray-500 text-sm">Tagihan Bulan Ini</p>
        <p class="text-2xl font-bold">Rp 50.000</p>
      </div>
      <div class="bg-white p-5 rounded-lg shadow">
        <p class="text-gray-500 text-sm">Status</p>
        <p class="text-2xl font-bold text-yellow-600">Belum Lunas</p>
      </div>
      <div class="bg-white p-5 rounded-lg shadow">
        <p class="text-gray-500 text-sm">Batas Bayar</p>
        <p class="text-2xl font-bold">31 Jan 2025</p>
      </div>
    </div>

    {{-- Aksi Multi-Bayar --}}
    <div class="flex justify-between items-center mb-3">
      <p class="text-sm text-gray-600">Centang bulan yang ingin dibayar, lalu klik tombol di bawah.</p>
      <button onclick="openModal()" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
        Bayar Bulan Terpilih
      </button>
    </div>

    {{-- GRID 12 BULAN (Modern) --}}
    <div class="bg-white rounded-xl shadow p-6">
      <h3 class="text-lg font-semibold mb-4">Pilih Bulan Tagihan</h3>

      <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
        @foreach($billings as $billing)
            <div class="month-card relative border-none rounded-xl p-4 hover:shadow-lg transition"
                data-month="{{ $billing->bulan }} {{ $billing->tahun }}">

            <div class="absolute top-3 right-3">
                @if($billing->status === 'unpaid')
                <input type="checkbox"
                        class="month-checkbox w-4 h-4"
                        value="{{ $billing->id }}">
                @else
                <span class="text-green-600 font-bold">✔</span>
                @endif
            </div>

            <div class="text-center">
                <p class="font-semibold text-lg">{{ $billing->bulan }}</p>
                <p class="text-sm text-gray-500">{{ $billing->tahun }}</p>

                <p class="mt-2 font-bold text-blue-600 amount-text">
                Rp {{ number_format($billing->effective_amount,0,',','.') }}
                </p>

                @if($billing->status === 'unpaid')
                <span class="inline-block mt-2 bg-yellow-100 text-yellow-700 text-xs px-2 py-1 rounded">
                    Belum Lunas
                </span>
                @endif
            </div>

            @if($billing->status === 'unpaid')
            <button onclick="openModal()"
                    class="mt-4 w-full bg-blue-600 text-white py-2 rounded-lg">
                Bayar
            </button>
            @endif
            </div>
            @endforeach

      </div>
    </div>

    {{-- Modal Bayar + Upload Bukti (Modern + Ringkasan) --}}
    <div id="modal" class="hidden fixed inset-0 bg-black bg-opacity-60 backdrop-blur-sm flex items-center justify-center">
      <div class="bg-white rounded-2xl w-[480px] p-6 shadow-2xl">
        <div class="flex justify-between items-center mb-4">
          <h3 class="text-lg font-bold">Pembayaran Iuran</h3>
          <button type="button" onclick="hideModal()" class="text-gray-400 hover:text-gray-700">✕</button>
        </div>

        {{-- Progress Bar Langkah (Animasi + Ikon) --}}
        <div class="mb-4">
          <div class="grid grid-cols-3 text-center text-xs mb-2">
            <div id="step-1-label" class="font-semibold text-blue-600">1) Pilih Bulan</div>
            <div id="step-2-label" class="text-gray-400">2) Bayar</div>
            <div id="step-3-label" class="text-gray-400">3) Upload Bukti</div>
          </div>

          <div class="relative w-full h-3 bg-gray-200 rounded-full overflow-hidden">
            <div id="progressBar" class="absolute left-0 top-0 h-3 bg-blue-600 rounded-full transition-all duration-500 ease-in-out" style="width:33%"></div>
          </div>

          <div class="grid grid-cols-3 text-center mt-2">
            <div id="icon-1" class="text-blue-600 text-lg">✔</div>
            <div id="icon-2" class="text-gray-300 text-lg">○</div>
            <div id="icon-3" class="text-gray-300 text-lg">○</div>
          </div>
        </div>

        <div class="bg-blue-50 border border-blue-200 rounded-xl p-3 mb-4 text-sm">
          <p class="font-semibold mb-1">Silakan transfer ke:</p>
          <p>BCA: <span class="font-medium">1234567890</span></p>
          <p>a.n <span class="font-medium">Kas Organisasi</span></p>
        </div>

        {{-- Ringkasan bulan terpilih --}}
        <div class="bg-gray-50 border rounded-xl p-3 mb-4">
          <p class="font-semibold mb-2">Ringkasan Pembayaran</p>
          <ul id="selectedMonths" class="text-sm text-gray-700 list-disc ml-5 mb-2"></ul>
          <p class="text-sm font-semibold">Total: <span id="totalAmount" class="text-blue-600">Rp 0</span></p>
        </div>

        <form method="POST"
                action="{{ route('member.payments.store') }}"
                enctype="multipart/form-data">
                @csrf


            {{-- billing_ids[] akan diisi via JS --}}
            <div id="billingIdsContainer"></div>

            <div class="mb-3">
                <label class="text-sm font-medium">Upload Bukti Pembayaran</label>
                <input type="file"
                    name="proof"
                    accept="image/*"
                    required
                    class="w-full border rounded p-2">
            </div>

            <div class="mb-4">
                <label class="text-sm font-medium">Catatan (opsional)</label>
                <textarea name="note"
                        rows="3"
                        class="w-full border rounded p-2"></textarea>
            </div>

            <div class="flex justify-end gap-2">
                <button type="button"
                        onclick="hideModal()"
                        class="border px-4 py-2 rounded">
                Batal
                </button>

                <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded">
                Kirim Bukti
                </button>
            </div>
            </form>

      </div>
    </div>

  </main>
</div>

<script>
function showModal(){
  document.getElementById('modal').classList.remove('hidden');
}

function hideModal(){
  document.getElementById('modal').classList.add('hidden');
}

function openModal(){
  showModal();

  const list = document.getElementById('selectedMonths');
  const total = document.getElementById('totalAmount');
  const container = document.getElementById('billingIdsContainer');
  const progress = document.getElementById('progressBar');

  list.innerHTML = '';
  container.innerHTML = '';

  // auto-check jika klik tombol Bayar
  const lastCard = window.event?.target?.closest('.month-card');
  if(lastCard){
    const cb = lastCard.querySelector('.month-checkbox');
    if(cb && !cb.checked) cb.checked = true;
  }

  const checked = document.querySelectorAll('.month-checkbox:checked');
  let amount = 0;

  checked.forEach(cb => {
    const card = cb.closest('.month-card');

    // tampilkan bulan
    const li = document.createElement('li');
    li.textContent = card.dataset.month;
    list.appendChild(li);

    // hitung total
    const nominalText = card.querySelector('.amount-text').innerText;
    amount += parseInt(nominalText.replace(/\D/g,''),10);

    // kirim billing_id ke backend
    const input = document.createElement('input');
    input.type = 'hidden';
    input.name = 'billing_ids[]';
    input.value = cb.value;
    container.appendChild(input);
  });

  total.textContent = 'Rp ' + amount.toLocaleString('id-ID');
  progress.style.width = checked.length ? '66%' : '33%';
}
</script>


@endsection