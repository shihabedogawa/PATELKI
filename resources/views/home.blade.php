@if(auth()->check())
    @extends('layouts.main')
@endif

@section('container')

<body class="font-sans text-gray-800 max-w-7xl mx-auto px-6">

      <div id="navbar-placeholder">
    </div>

    @include('partials.whatsapp-popup')


                <!-- Hero Section -->
        <section class="relative h-[70vh] flex items-center bg-cover bg-center"
            style="background-image: url('{{ asset('img/' . $heroImage) }}');">
            <!-- Overlay -->
            <div class="absolute inset-0 bg-black/40"></div>

            <!-- Content -->
            <div class="relative z-10 max-w-3xl px-6 lg:px-12 text-white">
                <h1 class="text-3xl md:text-5xl font-bold leading-tight">
                    Bersama PATELKI,<br>
                    Wujudkan Kualitas<br>
                    Pelayanan Laboratorium Terbaik
                </h1>
            </div>
        </section>


        <!-- Event Section -->
        {{-- <section class="py-16 bg-green-50">
            <div class="max-w-7xl mx-auto px-6">
                <h2 class="text-center text-2xl md:text-3xl font-bold mb-12">Event Selanjutnya</h2>

                <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
                    <!-- Card 1 -->
                    <div class="bg-white rounded-2xl shadow-md overflow-hidden hover:scale-105 transition">
                        <img src="https://images.unsplash.com/photo-1519389950473-47ba0277781c" alt="Webinar"
                            class="w-full h-48 object-cover">
                        <div class="p-6">
                            <h3 class="text-lg font-bold">Webinar</h3>
                            <p class="text-gray-600 mt-2">Lorem ipsum dolor, sit amet consectetur adipisicing elit.</p>
                        </div>
                    </div>

                    <!-- Card 2 -->
                    <div class="bg-white rounded-2xl shadow-md overflow-hidden hover:scale-105 transition">
                        <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f" alt="Webinar"
                            class="w-full h-48 object-cover">
                        <div class="p-6">
                            <h3 class="text-lg font-bold">Webinar</h3>
                            <p class="text-gray-600 mt-2">Lorem ipsum dolor, sit amet consectetur adipisicing elit.</p>
                        </div>
                    </div>

                    <!-- Card 3 -->
                    <div class="bg-white rounded-2xl shadow-md overflow-hidden hover:scale-105 transition">
                        <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f" alt="Webinar"
                            class="w-full h-48 object-cover">
                        <div class="p-6">
                            <h3 class="text-lg font-bold">Webinar</h3>
                            <p class="text-gray-600 mt-2">Lorem ipsum dolor, sit amet consectetur adipisicing elit.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section> --}}

        <!-- ================= EVENT SELANJUTNYA ================= -->
        <section class="py-16 bg-green-50">
            <div class="max-w-7xl mx-auto px-6">
                <h2 class="text-center text-2xl md:text-3xl font-bold mb-12">
                    Event Selanjutnya
                </h2>

                @if ($nextEvents->isEmpty())
                    <p class="text-center text-gray-500">
                        Belum ada event terjadwal.
                    </p>
                @else
                    <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach ($nextEvents as $event)
                            <a href="{{ route('activities.show', $event->slug) }}"
                            class="bg-white rounded-2xl shadow-md overflow-hidden
                                    hover:shadow-lg hover:-translate-y-1 transition block">

                                <img src="{{ asset('storage/'.$event->cover_image) }}"
                                    alt="{{ $event->title }}"
                                    class="w-full h-48 object-cover">

                                <div class="p-6">
                                    <span class="inline-block mb-2 px-3 py-1 rounded-full text-xs font-semibold
                                        {{ $event->type === 'baksos'
                                            ? 'bg-emerald-100 text-emerald-700'
                                            : 'bg-blue-100 text-blue-700' }}">
                                        {{ strtoupper($event->type) }}
                                    </span>

                                    <h3 class="text-lg font-bold">
                                        {{ $event->title }}
                                    </h3>

                                    <p class="text-gray-600 mt-2 line-clamp-2">
                                        {{ $event->description }}
                                    </p>

                                    <p class="text-sm text-gray-500 mt-3">
                                        <i class="far fa-calendar-alt mr-1"></i>
                                        {{ $event->event_date->translatedFormat('d F Y') }}
                                    </p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        </section>



        <!-- Footer -->
        <footer class="bg-gray-100 border-t border-gray-200 py-10">
            <div class="max-w-7xl mx-auto px-6">

                <!-- INFO + MAP -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-start mb-8">

                    <!-- INFO (lebih lebar) -->
                    <div class="md:col-span-2">
                        <h3 class="text-2xl font-bold">PATELKI Singkawang</h3>
                        <p class="mt-3 text-sm leading-relaxed">
                            Jl. Dr. Sutomo No.28, Pasiran, Kec. Singkawang Barat<br>
                            Kota Singkawang, Kalimantan Barat 79123
                        </p>
                        <p class="mt-3 text-sm">
                            Phone: +62895321177645<br>
                            Email: patelki.dpcskw@gmail.com
                        </p>
                    </div>

                    <!-- MAP (lebih kecil & proporsional) -->
                    <div class="md:col-span-1">
                        <div class="w-full h-40 md:h-44 rounded-xl overflow-hidden shadow-md border">
                            <iframe class="w-full h-full border-0" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3646.497982962398!2d108.9726852!3d0.8953983999999998!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31e3725e382c01a7%3A0x5d24155cee78333!2sDr.%20Abdul%20Aziz%20Hospital!5e1!3m2!1sen!2sid!4v1764122545406!5m2!1sen!2sid"
                                width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade">
                            </iframe>
                        </div>
                    </div>
    </div>
    
    @include('footer')
        
@endsection