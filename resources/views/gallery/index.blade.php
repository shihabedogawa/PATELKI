@extends('layouts.main')

@section('container')
@include('partials.whatsapp-popup')

<main class="max-w-7xl mx-auto px-6 py-12 text-gray-800">

    <!-- ================= FILTER SECTION ================= -->
    <section class="mb-12">
        <div class="glass-card rounded-2xl p-6">
            <p class="text-center text-gray-600 mb-6">
                Pilih kategori untuk menampilkan dokumentasi kegiatan
            </p>

            <div class="flex flex-wrap justify-center gap-3">
                <button class="filter-btn px-5 py-2 rounded-full bg-gray-100 active"
                        data-filter="all">
                    Semua
                </button>
                <button class="filter-btn px-5 py-2 rounded-full bg-gray-100"
                        data-filter="news">
                    Kegiatan
                </button>
                <button class="filter-btn px-5 py-2 rounded-full bg-gray-100"
                        data-filter="baksos">
                    Baksos
                </button>
            </div>

            <div class="mt-8 max-w-md mx-auto">
                <input type="text"
                       id="searchGallery"
                       placeholder="Cari dokumentasi..."
                       class="w-full px-4 py-3 rounded-xl border border-gray-300
                              focus:outline-none focus:ring-2 focus:ring-primary">
            </div>
        </div>
    </section>

    <!-- ================= HEADER ================= -->
    <section id="gallery-grid">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h3 class="text-2xl font-bold">Dokumentasi Kegiatan</h3>
                <p class="text-gray-500 text-sm">
                    Menampilkan <span id="photo-count">{{ $activities->total() }}</span> foto
                </p>
            </div>

            <div class="flex items-center gap-2">
                <button id="grid-view"
                        class="p-2 rounded-lg bg-blue-100 text-blue-600">
                    <i class="fas fa-th-large"></i>
                </button>
                <button id="list-view"
                        class="p-2 rounded-lg bg-gray-100 text-gray-600 hover:bg-gray-200">
                    <i class="fas fa-list"></i>
                </button>
            </div>
        </div>

        <!-- ================= GRID VIEW ================= -->
        <div id="grid-container"
             class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">

            @forelse ($activities as $item)
            <div class="grid-item gallery-item"
                 data-category="{{ $item->type }}"
                 data-title="{{ strtolower($item->title) }}">

                <!-- 🔗 LINK KE DETAIL -->
                <a href="{{ route('activities.show', $item->slug) }}"
                   class="block h-full">

                    <div class="bg-white rounded-2xl shadow-md hover:shadow-lg
                                hover:scale-[1.02] transition overflow-hidden h-full">

                        <!-- IMAGE -->
                        <div class="aspect-[4/3] overflow-hidden">
                            <img src="{{ asset('storage/'.$item->cover_image) }}"
                                 alt="{{ $item->title }}"
                                 class="w-full h-full object-cover">
                        </div>

                        <!-- CONTENT -->
                        <div class="p-4">
                            <h3 class="font-semibold text-gray-800 line-clamp-2">
                                {{ $item->title }}
                            </h3>

                            <p class="text-xs text-gray-500 mt-2">
                                <i class="far fa-calendar-alt mr-1"></i>
                                {{ $item->created_at->translatedFormat('d F Y') }}
                            </p>
                        </div>
                    </div>

                </a>
            </div>
            @empty
                <p class="col-span-full text-center text-gray-500 py-12">
                    Belum ada dokumentasi kegiatan.
                </p>
            @endforelse
        </div>

        <!-- ================= LIST VIEW ================= -->
        <div id="list-container" class="hidden space-y-4 mt-6">

            @foreach ($activities as $item)
            <div class="grid-item bg-white rounded-xl shadow p-4 flex gap-4"
                 data-category="{{ $item->type }}">

                <!-- 🔗 LINK KE DETAIL -->
                <a href="{{ route('activities.show', $item->slug) }}"
                   class="flex gap-4 w-full">

                    <div class="w-24 h-24 rounded-lg overflow-hidden flex-shrink-0">
                        <img src="{{ asset('storage/'.$item->cover_image) }}"
                             alt="{{ $item->title }}"
                             class="w-full h-full object-cover">
                    </div>

                    <div class="flex-1">
                        <h3 class="font-semibold text-gray-800">
                            {{ $item->title }}
                        </h3>
                        <p class="text-sm text-gray-500 mt-1">
                            {{ $item->created_at->translatedFormat('d F Y') }}
                        </p>
                    </div>

                </a>
            </div>
            @endforeach
        </div>

        @if ($activities->hasPages())
        <div class="mt-12 flex justify-center">
            {{ $activities->links() }}
        </div>
        @endif

    </section>

</main>

<!-- ================= BACK TO TOP ================= -->
<button id="backToTop"
        class="fixed bottom-8 right-8 w-12 h-12 bg-primary text-white rounded-full
               shadow-lg hover:shadow-xl transition-all opacity-0 translate-y-10">
    <i class="fas fa-arrow-up"></i>
</button>

<!-- ================= SCRIPT ================= -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const filterButtons = document.querySelectorAll('.filter-btn');
    const galleryItems  = document.querySelectorAll('.grid-item');
    const searchInput   = document.getElementById('searchGallery');
    const gridViewBtn   = document.getElementById('grid-view');
    const listViewBtn   = document.getElementById('list-view');
    const gridContainer = document.getElementById('grid-container');
    const listContainer = document.getElementById('list-container');
    const photoCount    = document.getElementById('photo-count');
    const backToTopBtn  = document.getElementById('backToTop');

    function updatePhotoCount() {
        const visibleItems = Array.from(galleryItems).filter(item =>
            item.style.display !== 'none'
        ).length;

        photoCount.textContent = visibleItems + ' dari {{ $activities->total() }}';
    }


    // FILTER
    filterButtons.forEach(btn => {
        btn.addEventListener('click', function () {
            filterButtons.forEach(b => b.classList.remove('active'));
            this.classList.add('active');

            const filter = this.dataset.filter;

            galleryItems.forEach(item => {
                const category = item.dataset.category;
                item.style.display =
                    filter === 'all' || category === filter ? 'block' : 'none';
            });

            updatePhotoCount();
        });
    });

    // SEARCH
    searchInput.addEventListener('input', function () {
        const term = this.value.toLowerCase();

        galleryItems.forEach(item => {
            const title = item.dataset.title;
            item.style.display = title.includes(term) ? 'block' : 'none';
        });

        updatePhotoCount();
    });

    // TOGGLE VIEW
    gridViewBtn.addEventListener('click', () => {
        gridContainer.classList.remove('hidden');
        listContainer.classList.add('hidden');
    });

    listViewBtn.addEventListener('click', () => {
        gridContainer.classList.add('hidden');
        listContainer.classList.remove('hidden');
    });

    // BACK TO TOP
    window.addEventListener('scroll', () => {
        if (window.scrollY > 300) {
            backToTopBtn.classList.remove('opacity-0', 'translate-y-10');
        } else {
            backToTopBtn.classList.add('opacity-0', 'translate-y-10');
        }
    });

    backToTopBtn.addEventListener('click', () => {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });

    updatePhotoCount();
});
</script>

@include('footer')

@endsection
