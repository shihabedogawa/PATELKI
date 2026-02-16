@extends('layouts.main')
@section('container')

    <body class="font-sans text-gray-800 max-w-7xl mx-auto px-6>
      <div id=navbar-placeholder">
        </div>

@include('partials.whatsapp-popup')

        <!-- Hero Section -->
        <section class="relative h-[70vh] flex items-center bg-cover bg-center"
            style="background-image: url('{{ asset('img/' . $heroImage) }}');">

            <!-- Overlay -->
            <div class="absolute inset-0 bg-black/40"></div>

            <!-- Content -->
            <div dir="rtl" class="text-white">
                <h1 class="absolute bottom-6 right-8 text-3xl md:text-5xl font-bold">
                    Struktur Organisasi
                </h1>
            </div>

        </section>

        <!-- KONTEN -->
        <section class="py-16 bg-gray-50">
            <div class="container mx-auto px-6">

                <!-- DEWAN PENASIHAT -->
                <h2 class="text-3xl font-bold text-center mb-10">PENASIHAT</h2>

                <div class="mb-16">

                    @php
                        $pimpinan = [['Muhammmad Animsyah, AMd.Kes', 'Penasihat', 'anim.jpeg']];
                    @endphp

                    @foreach ($pimpinan as $item)
                        <div class="bg-stone-300 rounded-xl shadow hover:shadow-lg transition p-5 text-center mx-auto max-w-xs">
                            <!-- mx-auto untuk margin horizontal otomatis -->
                            <img src="{{ asset('img/pengurus/' . $item[2]) }}"
                                class="w-full aspect-[3/4] object-cover rounded-lg mb-4" alt="{{ $item[1] }}">
                            <h3 class="text-lg font-semibold">{{ $item[1] }}</h3>
                            <p class="text-gray-600 text-sm">{{ $item[0] }}</p>
                        </div>
                    @endforeach

                </div>

                <!-- PIMPINAN -->
                <h2 class="text-3xl font-bold text-center mb-10">Pimpinan</h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 mb-16">

                    @php
                        $pimpinan = [
                            ['Ketua', 'Cik Verra Budi Lestari, S.Tr.Kes', 'ketua.jpeg'],
                            ['Wakil Ketua', 'Kaltarina, A.Md.Kes', 'wakil-ketua.jpeg'],
                            ['Sekretaris', 'Dian Marliyana, S.Tr.Kes', 'sekretaris.jpeg'],
                            ['Wakil Sekretaris', 'Hadjpi Rona Dinihari, S.Tr.Kes', 'wakil-sekretaris.jpeg'],
                            ['Bendahara', 'Vica Desmartha, S.Tr.Kes', 'bendahara.jpeg'],
                            ['Wakil Bendahara', 'Dwi Novia Setyorini, S.Tr.Kes', 'wakil-bendahara.jpeg'],
                        ];
                    @endphp

                    @foreach ($pimpinan as $item)
                        <div class="bg-stone-300 rounded-xl shadow hover:shadow-lg transition p-5 text-center">
                            <img src="{{ asset('img/pengurus/' . $item[2]) }}"
                                class="w-full aspect-[3/4] object-cover rounded-lg mb-4" alt="{{ $item[1] }}">
                            <h3 class="text-lg font-semibold">{{ $item[0] }}</h3>
                            <p class="text-gray-600 text-sm">{{ $item[1] }}</p>
                        </div>
                    @endforeach

                </div>

                <!-- SEKSI-SEKSI -->
                <h2 class="text-3xl font-bold text-center mb-12">Seksi-Seksi</h2>

                @php
                    $seksi =[
                        [
                            'Seksi Organisasi, Keanggotaan dan Kaderisasi',
                            [
                                ['Ketua', 'Hilman Amrullah, A.Md.AK', 'hilman.jpeg'],
                                ['Anggota', 'Shihab Qurtuby, S.Tr.Kes', 'qurtuby.jpeg'],
                                ['Anggota', 'Dia Sukmawati, A.Md.AK', 'dia.jpeg'],
                            ],
                        ],
                        [
                            'Seksi Pendidikan dan Pengembangan SDM',
                            [
                                ['Ketua', 'Yeni Indah Tri Utami, S.Tr.Kes', 'yeni.jpeg'],
                                ['Anggota', 'Fitriani, A.Md.AK', 'fitriani.jpeg'],
                                ['Anggota', 'Nurbaiti, S.Tr.Kes', 'nurbaiti.jpeg'],
                            ],
                        ],
                        [
                            'Seksi Ilmiah, Penelitian dan Pengembangan IPTEK',
                            [
                                ['Ketua', 'Utin Eka Handayani, A.Md.AK', 'utin.jpeg'],
                                ['Anggota', 'Reskiya Safraiani, S.Tr.TLM', 'reskiya.jpeg'],
                                ['Anggota', 'Glorya Viltanymora Damar Wangi, S.Tr.Kes', 'glorya.jpeg'],
                            ],
                        ],
                        [
                            'Seksi Standarisasi dan Sertifikasi',
                            [
                                ['Ketua', 'Henny Junita, S.Si', 'henny.jpeg'],
                                ['Anggota', 'Disa Fajri Putriani, A.Md.AK', 'disa.jpeg'],
                                ['Anggota', 'Hardiansyah, A.Md.AK', 'hardiansyah.jpeg'],
                            ],
                        ],
                        [
                            'Seksi Hukum dan Advokasi',
                            [
                                ['Ketua', 'Eni Rosiana, SKM', 'eni.jpeg'],
                                ['Anggota', 'Wiwik Nurleny, A.Md.Kes', 'wiwik.jpeg'],
                                ['Anggota', 'Hudari Mudaf, A.Md.AK', 'mudaf.jpeg'],
                            ],
                        ],
                        [
                            'Seksi Hubungan Masyarakat dan Antar Lembaga',
                            [
                                ['Ketua', 'Merry Chrismalia, S.Tr.Kes', 'merry.jpeg'],
                                ['Anggota', 'Rista Mariana Nainggolan, S.Tr.Kes', 'rista.jpeg'],
                                ['Anggota', 'Ogi Ananda Saputra, A.Md.Kes', 'ogi.jpeg'],
                            ],
                        ],
                        [
                            'Seksi Usaha dan Kesejahteraan Anggota',
                            [
                                ['Ketua', 'Triwijaya, A.Md.Kes', 'triwijaya.jpeg'],
                                ['Anggota', 'Nazifah, A.Md.AK', 'nazifah.jpeg'],
                                ['Anggota', 'Arantsa Acikayudia, A.Md.AK', 'arantsa.jpeg'],
                            ],
                        ],
                    ];
                @endphp

                @foreach ($seksi as $bagian)
                    <div class="mb-16">
                        <h3 class="text-2xl font-semibold mb-6 text-center">
                            {{ $bagian[0] }}
                        </h3>

                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                            @foreach ($bagian[1] as $anggota)
                                <div class="bg-stone-300 rounded-xl shadow hover:shadow-lg transition p-5 text-center">
                                    <img src="{{ asset('img/pengurus/' . $anggota[2]) }}"
                                        class="w-full aspect-[3/4] object-cover rounded-lg mb-4" alt="{{ $anggota[1] }}">
                                    <h4 class="text-md font-semibold">{{ $anggota[0] }}</h4>
                                    <p class="text-gray-600 text-sm">{{ $anggota[1] }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach

            </div>
   
        </section>

        @include('footer')
        <br>
        
    @endsection