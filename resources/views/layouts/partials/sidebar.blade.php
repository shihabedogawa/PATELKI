<aside class="fixed left-0 top-0 h-screen w-60 bg-white shadow-xl z-40 flex flex-col">

    <!-- ================= HEADER ================= -->
    <div class="h-16 px-4 flex items-center gap-3 border-b
                bg-gradient-to-r from-emerald-600 to-emerald-500 text-white">
        <div class="w-9 h-9 rounded-full bg-white/20 flex items-center justify-center">
            🧬
        </div>
        <div class="leading-tight">
            <p class="text-[11px] uppercase tracking-wider opacity-90">Member Area</p>
            <p class="font-bold text-sm">PATELKI</p>
        </div>
    </div>

    <!-- ================= MINI PROFILE ================= -->
    <div class="px-4 py-4 border-b">
        <div class="flex items-center gap-3">
            <img
                src="{{ auth()->user()->member->foto_file
                        ? asset('storage/'.auth()->user()->member->foto_file)
                        : 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name) }}"
                class="w-10 h-10 rounded-full object-cover border border-emerald-500">

            <div class="flex-1 min-w-0">
                <p class="font-semibold text-slate-800 text-sm truncate">
                    {{ auth()->user()->name }}
                </p>
                <p class="text-[11px] text-slate-500">
                    NAP {{ auth()->user()->member->nap ?? '-' }}
                </p>
            </div>
        </div>

        @if(!auth()->user()->member->is_profile_complete)
        <div class="mt-3 bg-amber-50 border border-amber-200 text-amber-800
                    text-[11px] p-2 rounded-lg">
            ⚠️ Lengkapi profil untuk membuka layanan
        </div>
        @endif
    </div>

    <!-- ================= MENU ================= -->
    <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-1 text-sm font-medium text-slate-700">

        <!-- DASHBOARD -->
        <a href="{{ route('member.dashboard') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-lg
           {{ request()->routeIs('member.dashboard')
                ? 'bg-emerald-50 text-emerald-700 font-semibold'
                : 'hover:bg-slate-50' }}">
            📊 <span>Dashboard</span>
        </a>

        <!-- PROFIL -->
        <a href="{{ route('profile.show') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-lg
           {{ request()->routeIs('profile.*')
                ? 'bg-emerald-50 text-emerald-700 font-semibold'
                : 'hover:bg-slate-50' }}">
            👤 <span>Profil Saya</span>
        </a>

        <!-- TAGIHAN -->
        <a href="{{ route('member.tagihan') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-lg
           {{ request()->routeIs('member.tagihan')
                ? 'bg-emerald-50 text-emerald-700 font-semibold'
                : 'hover:bg-slate-50' }}">
            💳 <span>Tagihan</span>
        </a>

        <!-- ================= DROPDOWN LAYANAN ================= -->
        <div x-data="{ open: false }" class="mt-2">

            <button
                @click="open = !open"
                class="w-full flex items-center justify-between
                       px-3 py-2.5 rounded-lg hover:bg-slate-50">

                <div class="flex items-center gap-3">
                    🛠️ <span>Layanan</span>
                </div>

                <svg :class="open ? 'rotate-180' : ''"
                     class="w-4 h-4 transition-transform"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            <div x-show="open" x-collapse class="mt-1 space-y-1 pl-6 text-[13px]">

                <a href="/layanan/rekomendasi-sip" class="block px-3 py-2 rounded-lg hover:bg-slate-50">
                    📄 Surat Rekomendasi
                </a>

                <a href="/layanan/mutasi" class="block px-3 py-2 rounded-lg hover:bg-slate-50">
                    🔁 Mutasi
                </a>

                <a href="/layanan/lunas-iuran" class="block px-3 py-2 rounded-lg hover:bg-slate-50">
                    ✅ Lunas Iuran
                </a>

                <a href="/layanan/skp" class="block px-3 py-2 rounded-lg hover:bg-slate-50">
                    📊 Surat Kecukupan SKP
                </a>

                <a href="/layanan/tempat-praktik" class="block px-3 py-2 rounded-lg hover:bg-slate-50">
                    🏥 Surat Pernyataan Tempat Praktik
                </a>

                <a href="/layanan/logbook" class="block px-3 py-2 rounded-lg hover:bg-slate-50">
                    📘 Logbook
                </a>

                <a href="/layanan/sk-pelayanan" class="block px-3 py-2 rounded-lg hover:bg-slate-50">
                    🧾 SK Pelayanan Profesi
                </a>

            </div>
        <!-- SECTION -->
        <p class="px-4 pt-4 pb-2 text-xs uppercase tracking-wider text-slate-400">
            Layanan
        </p>

        <!-- ATLAS -->
        <a href="/atlas"
           class="group flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-50">
            <span class="text-lg">📚</span>
            Atlas
        </a>

        <!-- GERAI -->
        <a href="/gerai"
           class="group flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-50">
            <span class="text-lg">🛒</span>
            Gerai
        </a>
        
        </div>

    </nav>

    <!-- ================= FOOTER ================= -->
    <div class="px-3 py-3 border-t">

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button
                class="w-full bg-red-600 text-white py-3 rounded-xl font-semibold shadow-lg">
                    Logout
            </button>
        </form>

        <p class="mt-3 text-[10px] text-center text-slate-400">
            © {{ now()->year }} PATELKI
        </p>
    </div>

</aside>
