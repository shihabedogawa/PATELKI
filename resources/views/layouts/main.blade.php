<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    <link rel="stylesheet" href="{{ asset('css/whatsapp-popup.css') }}">

</head>

<body>
    <header id="navbar" class="fixed top-0 w-full z-50 transition-all duration-300">
        <div class="bg-white backdrop-blur shadow">
            <div class="max-w-7xl mx-auto px-6">
                <nav class="flex items-center justify-between h-16">

                    <!-- LOGO -->
                    <div class="flex items-center gap-2">
                        <img src="{{ asset('img/Logo PATELKI.png') }}" alt="Logo" class="h-8 w-auto">
                        <span class="text-lg font-bold text-green-700">
                            DPC SINGKAWANG
                        </span>
                    </div>

                    <!-- HAMBURGER (MOBILE) -->
                    <button id="menuBtn" class="md:hidden text-gray-700 focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>

                    <!-- MENU DESKTOP -->
                    <div class="hidden md:flex items-center gap-6">

                        <ul class="flex items-center gap-6 text-sm font-medium text-gray-700">

                            <li>
                                <a href="/" class="hover:text-green-600">
                                    Home
                                </a>

                            </li>

                            <!-- About Us -->
                            <li class="relative group">
                                <button class="flex items-center gap-1 hover:text-green-600 focus:outline-none">
                                    About Us
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>

                                <ul
                                    class="absolute left-0 mt-3 w-40 bg-white rounded-lg shadow-lg py-1.5 opacity-0 invisible translate-y-1 group-hover:opacity-100 group-hover:visible group-hover:translate-y-0 transition-all duration-200">
                                    <li><a href="/visimisi" class="block px-4 py-2 hover:bg-green-50">Visi & Misi</a>
                                    </li>
                                    <li><a href="/struktur" class="block px-4 py-2 hover:bg-green-50">Struktur
                                            Organisasi</a></li>
                                </ul>
                            </li>

                            <!-- Event -->
                            <li class="relative group">
                                <button class="flex items-center gap-1 hover:text-green-600 focus:outline-none">
                                    Event
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>

                                <ul
                                    class="absolute left-0 mt-3 w-40 bg-white rounded-lg shadow-lg py-1.5 opacity-0 invisible translate-y-1 group-hover:opacity-100 group-hover:visible group-hover:translate-y-0 transition-all duration-200">
                                    <li><a href="/gallery" class="block px-4 py-2 hover:bg-green-50">Galeri</a></li>
                                    <li><a href="{{ route('training.calendar') }}"
                                            class="block px-4 py-2 hover:bg-green-50">Jadwal Pelatihan</a></li>
                                    <li>
                                        <a href="{{ route('baksos.schedule') }}"
                                            class="block px-4 py-2 hover:bg-green-50">
                                            Jadwal Baksos
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <!-- Layanan -->
                            <li class="relative group">
                                <button class="flex items-center gap-1 hover:text-green-600 focus:outline-none">
                                    Layanan
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>

                                <ul
                                    class="absolute left-0 mt-3 w-40 bg-white rounded-lg shadow-lg py-1.5
                       opacity-0 invisible translate-y-1
                       group-hover:opacity-100 group-hover:visible group-hover:translate-y-0
                       transition-all duration-200">
                                    <li><a href="/daftar-simk" class="block px-4 py-2 hover:bg-green-50">Daftar SIMK</a>
                                    </li>
                                </ul>
                            </li>

                        </ul>

                        <!-- MASUK -->
                        <a href="{{ route('login') }}"
                            class="bg-green-600 text-white px-4 py-2 rounded-md text-sm font-semibold
          hover:bg-green-700 transition">
                            LOGIN
                        </a>

                    </div>
                </nav>

                <!-- MENU MOBILE -->
                <div id="mobileMenu" class="hidden md:hidden pb-4">
                    <ul class="space-y-2 text-gray-700 font-medium">
                        <li><a href="/home" class="block py-2">Home</a></li>
                        <li><a href="/visimisi" class="block py-2">Visi & Misi</a></li>
                        <li><a href="/struktur" class="block py-2">Struktur Organisasi</a></li>
                        <li><a href="#" class="block py-2">Galeri</a></li>
                        <li><a href="#" class="block py-2">Pelatihan</a></li>
                        <li><a href="#" class="block py-2">Baksos</a></li>
                        <li><a href="#" class="block py-2">Daftar SIMK</a></li>
                        <li>
                            <a href="{{ url('/login') }}"
                                class="block bg-green-700 text-white text-center py-2 rounded-md">
                                LOGIN
                            </a>

                        </li>
                    </ul>
                </div>

            </div>
        </div>
    </header>


    <div class="max-w-6xl mx-auto px-6 lg:px-8 pt-5 pb-8">
        @yield('container')
    </div>




    <script>
        const menuBtn = document.getElementById('menuBtn');
        const mobileMenu = document.getElementById('mobileMenu');
        const navbar = document.getElementById('navbar');

        menuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        window.addEventListener('scroll', () => {
            if (window.scrollY > 10) {
                navbar.classList.add('shadow-lg');
            } else {
                navbar.classList.remove('shadow-lg');
            }
        });
    </script>

    <script src="{{ asset('js/whatsapp-popup.js') }}"></script>

    @push('scripts')
        <script>
            document.querySelectorAll('input[type="file"]').forEach(input => {
                input.addEventListener('change', function() {
                    const fileNameElement = this.closest('.border').querySelector('.file-name');

                    if (this.files.length > 0) {
                        fileNameElement.textContent = this.files[0].name;
                        fileNameElement.classList.add('text-green-600');
                    } else {
                        fileNameElement.textContent = 'Belum ada file';
                        fileNameElement.classList.remove('text-green-600');
                    }
                });
            });
        </script>
    @endpush


</body>

</html>
