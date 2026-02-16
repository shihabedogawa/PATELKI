<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">


    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    <title>Admin Panel | DPC Singkawang</title>
</head>

<body class="bg-gray-50">

<!-- ======= OVERLAY (UNTUK MOBILE) ======= -->
<div id="sidebar-overlay"
     class="fixed inset-0 bg-black bg-opacity-50 hidden z-30 transition-all"></div>

<!-- ========== MOBILE TOP BAR ========== -->
<div class="flex lg:hidden justify-between items-center bg-white px-5 py-4 shadow-md sticky top-0 z-40">
    <div class="flex items-center gap-3">
        <img src="{{ asset('img/Logo PATELKI.png') }}" class="h-10 w-auto">
        <h2 class="font-bold text-xl text-indigo-950">DPC Singkawang</h2>
    </div>

    <button id="toggleSidebar"
        class="p-2 border rounded-full hover:bg-gray-100 transition">
        ☰
    </button>
</div>

<!-- ========== SIDEBAR (ANIMATED) ========== -->
<aside id="sidebar"
   class="fixed top-0 left-0 h-screen w-[260px] bg-white shadow-xl px-5 py-6 
          transform -translate-x-full lg:translate-x-0 transition-transform duration-300 z-40">

    <div class="flex flex-col h-full">

        <!-- LOGO -->
        <div class="flex flex-col items-center mb-8">
            <img src="{{ asset('img/Logo PATELKI.png') }}" class="h-14 mb-2">
            <h2 class="font-bold text-lg text-indigo-950">DPC Singkawang</h2>
        </div>

        <nav class="flex-1 space-y-3">

            <p class="text-xs text-gray-400 px-2">GENERAL</p>
            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center gap-3 px-4 py-2 rounded-xl hover:bg-indigo-50">
               🏠 <span>Dashboard</span>
            </a>

            @if (empty(auth()->user()->division) || auth()->user()->division === 'Keanggotaan')
            <p class="text-xs text-gray-400 px-2 mt-4">DATA ANGGOTA</p>

            <button data-toggle="dropdown" data-target="menu-anggota"
                class="w-full flex justify-between items-center px-4 py-2 rounded-xl hover:bg-indigo-50">
                <span class="flex items-center gap-3">👥 Keanggotaan</span>
                <span>▾</span>
            </button>

            <div id="menu-anggota" class="hidden ml-4 space-y-1">
                <a href="{{ route('admin.members.pending') }}"
                   class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-gray-100">
                   ⏳ Pending
                </a>

                <a href="{{ route('admin.members.approved') }}"
                   class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-gray-100">
                   ✅ Approved
                </a>

                <a href="{{ route('admin.members.all') }}"
                   class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-gray-100">
                   📋 Semua Anggota
                </a>
            </div>
            @endif

            @if (auth()->user()->division === 'Pendidikan dan Pengembangan SDM')
            <p class="text-xs text-gray-400 px-2 mt-4">PENDIDIKAN</p>

            <a href="{{ route('admin.pendidikan.dashboard') }}"
               class="flex items-center gap-3 px-4 py-2 rounded-xl hover:bg-indigo-50">
               🎓 Dashboard Pendidikan
            </a>

            <a href="{{ route('admin.pendidikan.events.index') }}"
               class="flex items-center gap-3 px-4 py-2 rounded-xl hover:bg-indigo-50">
               📅 Kelola Pelatihan
            </a>
            @endif

            
            @if (auth()->user()->division === 'Humas')
            <p class="text-xs text-gray-400 px-2 mt-4">HUMAS</p>

            <a href="{{ route('admin.humas.dashboard') }}"
            class="flex items-center gap-3 px-4 py-2 rounded-xl hover:bg-indigo-50">
            📰 Berita & Kegiatan
            </a>
            @endif


            
        </nav>

        <!-- LOGOUT -->
        <form action="{{ route('logout') }}" method="POST" class="mt-6">
            @csrf
            <button
                    type="submit"
                    class="bg-red-600 text-white
                        p-3 rounded-full w-12 h-12 flex items-center justify-center
                         mx-auto
                        shadow-lg hover:bg-red-700 transition">
                <i class="fa-solid fa-right-from-bracket"></i>
            </button>

        </form>
    </div>
</aside>

<!-- ===== MAIN CONTENT ===== -->
<main class="flex-1 lg:ml-[260px] transition-all">

<div class="bg-white shadow px-8 py-4 sticky top-0 z-20">
    <div class="flex justify-end items-center">

               <div class="hidden md:flex items-center gap-3">
            <div class="text-right">
                <h3 class="font-semibold">Divisi</h3>
                <p class="text-gray-500 text-sm">
                    {{ auth()->user()->division ?? 'Keanggotaan' }}
                </p>
            </div>
        </div>
    </div>
</div>

<div class="p-8">
    @yield('content')
</div>

</main>

<script>
const toggleBtn = document.getElementById("toggleSidebar");
const sidebar = document.getElementById("sidebar");
const overlay = document.getElementById("sidebar-overlay");

toggleBtn.addEventListener("click", () => {
  sidebar.classList.toggle("-translate-x-full");
  overlay.classList.toggle("hidden");
});

overlay.addEventListener("click", () => {
  sidebar.classList.add("-translate-x-full");
  overlay.classList.add("hidden");
});

// Dropdown submenu tetap jalan
document.querySelectorAll("[data-toggle='dropdown']").forEach(btn => {
    btn.addEventListener("click", function(e) {
        e.preventDefault();
        const target = document.getElementById(this.dataset.target);
        target.classList.toggle("hidden");
    });
});
</script>

</body>
</html>
