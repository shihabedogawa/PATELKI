@extends('layouts.main')
@section('container')

<body class="font-sans text-gray-800 max-w-7xl mx-auto px-6>
  <div id = navbar-placeholder">
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
                    About Us
                </h1>
            </div>

        </section>

        <!-- Sejarah -->
        <section class="bg-green-50 py-12 px-6">
            <div class="container mx-auto max-w-4xl text-center">
                <h2 class="text-2xl md:text-3xl font-bold mb-6">Sejarah</h2>
                <p class="text-gray-700 leading-relaxed text-justify">
                    Organisasi PATELKI lahir pada tanggal 26 April 1986 di Jakarta. Lahirnya PATELKI diprakarsai oleh Bapak
                    Drs. Sjarifuddin Djalil yang kala itu menjabat Kepala Pusat Laboratorium Kesehatan Indonesia. Setelah
                    itu, asosiasi seprofesi di negara-negara ASEAN lainnya menyampaikan undangan kepada PATELKI untuk
                    bergabung dengan AAMLT (ASEAN Association of Medical Laboratory Technologist), yang pada masa itu
                    Indonesia belum memiliki asosiasi seprofesi di bidang ini.
                </p>
            </div>
        </section>

        <!-- Visi -->
        <section class="bg-white py-12 px-6">
            <div class="container mx-auto max-w-3xl text-center">
                <h2 class="text-2xl md:text-3xl font-bold mb-6">Visi</h2>
                <p class="text-gray-700 leading-relaxed">
                    Menjadikan organisasi profesi yang mandiri, profesional, peduli dan mampu memberi solusi serta aktif
                    dalam peningkatan mutu pelayanan laboratorium medik bagi peningkatan kualitas kesehatan masyarakat untuk
                    mewujudkan Visi Indonesia Sehat 2025.
                </p>
            </div>
        </section>

        <!-- Misi -->
        <section class="bg-green-50 py-12 px-6">
            <div class="container mx-auto max-w-4xl">
                <h2 class="text-2xl md:text-3xl font-bold text-center mb-6">Misi</h2>
                <ul class="list-disc list-outside space-y-4 text-gray-700 leading-relaxed text-justify">
                    <li>Meningkatkan kekuatan kepemimpinan PATELKI dalam mewujudkan organisasi profesi yang mandiri,
                        profesional, dan berwibawa.</li>
                    <li>Meningkatkan kemampuan dan pengembangan diri Ahli Teknologi Laboratorium Medik (ATLM) sebagai tenaga
                        kesehatan profesional dan beretika serta berdaya saing internasional.</li>
                    <li>Mengembangkan Ilmu Pengetahuan dan Teknologi untuk peningkatan pelayanan laboratorium dan penjaminan
                        mutu hasil pemeriksaan laboratorium.</li>
                    <li>Mengoptimalkan sistem remunerasi, upah minimum, penghargaan dan jenjang karir profesional yang
                        didukung oleh sistem pendidikan berkelanjutan dan sistem sertifikasi yang kuat.</li>
                    <li>Penguatan eksistensi organisasi dan kemampuan advokasi melalui pengembangan jejaring kemitraan yang
                        kuat baik di dalam maupun luar negeri.</li>
                </ul>
            </div>

            @include('footer')

@endsection
