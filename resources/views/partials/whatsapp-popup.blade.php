<!-- WhatsApp Popup -->
<div id="wa-popup" class="fixed bottom-5 right-5 z-50 flex flex-col items-end gap-2">

    <!-- Kotak Popup -->
    <div id="wa-box" class="bg-white w-72 p-4 rounded-2xl shadow-xl border-none hidden animate-fade-in">
        <div class="flex justify-between items-center mb-2">
            <h3 class="text-sm font-bold text-gray-800">Butuh Bantuan?</h3>
            <button onclick="closeWaPopup()" class="text-gray-400 hover:text-gray-600 text-lg">×</button>
        </div>
        <p class="text-sm text-gray-600 mb-3">
            Chat langsung dengan admin PATELKI Singkawang.
        </p>
        <a href="https://wa.me/62895321177645?text=Assalamualaikum%20Admin%20PATELKI%2C%20saya%20ingin%20bertanya."
            target="_blank"
            class="block text-center bg-green-500 hover:bg-green-600 text-white py-2 rounded-lg text-sm font-medium">
            Chat via WhatsApp
        </a>
    </div>

    <!-- Tombol WA Bulat -->
    <button onclick="toggleWaPopup()"
        class="bg-green-500 hover:bg-green-600 text-white w-14 h-14 rounded-full shadow-lg flex items-center justify-center">
        <img src="{{ asset('img/WhatsApp Logo.svg') }}" class="w-7 h-7" alt="WA">
    </button>
</div>
