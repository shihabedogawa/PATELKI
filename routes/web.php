<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Admin\HumasActivityController;
use App\Http\Controllers\{
    GalleryController,
    TrainingController,
    LoginController,
    RegisterController,
    AdminController,
    MemberController,
    ProfileController,
    MemberBillingController,
    MemberPaymentController,
    TreasurerController,
    MemberDashboardController,
    HomeController,
    BaksosController,
    ActivityController

};


/*
|--------------------------------------------------------------------------
| PUBLIC / GUEST ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index']);

// Route::get ('/', 'HomeController@index');

Route::view('/visimisi', 'visimisi', [
    'heroImage' => 'Mikroskop.jpg',
    'title'     => 'About Us',
]);

Route::view('/struktur', 'struktur', [
    'heroImage' => 'Mikroskop.jpg',
    'title'     => 'Struktur Organisasi',
]);

Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery.index');
Route::get('/gallery/album/{id}', [GalleryController::class, 'album'])->name('gallery.album');
Route::get('/gallery/category/{category}', [GalleryController::class, 'category'])->name('gallery.category');

Route::get('/daftar-simk', fn () => view('register'))->name('simk.register');
Route::post('/pendaftaran-simk', [RegisterController::class, 'store'])
    ->name('simk.register.submit');

Route::get('/jadwal-pelatihan', [TrainingController::class, 'calendar'])
    ->name('training.calendar');

Route::get('/baksos/jadwal', [BaksosController::class, 'index'])
    ->name('baksos.schedule');
    
Route::get('/kegiatan/{slug}', [ActivityController::class, 'show'])
    ->name('activities.show');

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'store'])->name('login.submit');

Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout');

/*
|--------------------------------------------------------------------------
| PROFILE (AUTH ONLY – SELALU BOLEH DIAKSES)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/profil', [ProfileController::class, 'show'])
        ->name('profile.show');

    Route::get('/profil/edit', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::put('/profil', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::post('/profil/photo', [ProfileController::class, 'uploadPhoto'])
        ->name('profile.photo');

    Route::post('/profil/password', [ProfileController::class, 'changePassword'])
        ->name('profile.password');
});

/*
|--------------------------------------------------------------------------
| MEMBER AREA (AUTH + PROFILE COMPLETE)
|--------------------------------------------------------------------------
| Semua route DI SINI TERKUNCI sampai profil 100% lengkap
*/

    Route::middleware(['auth', 'profile.complete'])
    // Route::middleware('auth')

    ->prefix('member')
    ->name('member.')
    ->group(function () {

        Route::get('/dashboard', [MemberDashboardController::class, 'index'])
            ->name('dashboard');

        Route::get('/invoices', [MemberController::class, 'invoices'])
            ->name('invoices');

        Route::get('/tagihan', [MemberController::class, 'tagihan'])
            ->name('tagihan');

        Route::post('/payments', [MemberPaymentController::class, 'store'])
            ->name('payments.store');

        // Informasi
        Route::view('/informasi/sip', 'pages.informasi.sip');
        Route::view('/informasi/mutasi', 'pages.informasi.mutasi');
        Route::view('/informasi/skp', 'pages.informasi.skp');
        Route::view('/informasi/ilmiah', 'pages.informasi.ilmiah');

        // Layanan
        Route::view('/layanan/rekomendasi-sip', 'pages.layanan.rekomendasi-sip');
        Route::view('/layanan/pengajuan-mutasi', 'pages.layanan.pengajuan-mutasi');

        // Atlas
        Route::view('/atlas/buku-saku', 'pages.atlas.buku-saku');
        Route::view('/atlas/kuis', 'pages.atlas.kuis');

        // Gerai
        Route::view('/gerai', 'pages.gerai.index');
    });

/*
|--------------------------------------------------------------------------
| ADMIN AREA
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/admin', [AdminController::class, 'dashboard'])
        ->name('admin.dashboard');

    // MEMBER MANAGEMENT
    Route::get('/admin/members/pending', [AdminController::class, 'pendingMembers'])
        ->name('admin.members.pending');

    Route::get('/admin/members/approved', [AdminController::class, 'approvedMembers'])
        ->name('admin.members.approved');

    Route::get('/admin/members/all', [MemberController::class, 'all'])
        ->name('admin.members.all');

    Route::post('/admin/members/{id}/approve', [AdminController::class, 'approveMember'])
        ->name('admin.members.approve');

    Route::delete('/admin/members/{id}', [AdminController::class, 'destroyMember'])
        ->name('admin.members.destroy');

    Route::post('/admin/members/download-zip', [AdminController::class, 'downloadZip'])
        ->name('admin.members.downloadZip');

    Route::put('/admin/members/{id}/nap', [MemberController::class, 'updateNap'])
        ->name('admin.members.updateNap');
    
    Route::get('/admin/files/{member}/{type}', [AdminController::class, 'viewFile'])
    ->name('admin.files.view');

    // ADMIN PENDIDIKAN
    Route::middleware('division:Pendidikan dan Pengembangan SDM')
        ->prefix('admin/pendidikan')
        ->name('admin.pendidikan.')
        ->group(function () {
            Route::view('/', 'admin.pendidikan.dashboard')->name('dashboard');
            Route::resource('events', \App\Http\Controllers\Admin\EventController::class);
        });

    // ADMIN TREASURER
    Route::prefix('admin/treasurer')->group(function () {
            Route::get('/', [TreasurerController::class, 'index'])
                ->name('treasurer.dashboard');

            Route::post('/approve/{id}', [TreasurerController::class, 'approve'])
                ->name('treasurer.approve');

            Route::post('/reject/{id}', [TreasurerController::class, 'reject'])
                ->name('treasurer.reject');

            Route::post('/dues', [TreasurerController::class, 'storeDues'])
                ->name('treasurer.dues.store');
        });

    
    // ADMIN HUMAS
        Route::middleware(['auth', 'division:Humas'])
            ->prefix('admin/humas')
            ->name('admin.humas.')
            ->group(function () {

                Route::get('/', [HumasActivityController::class, 'index'])
                    ->name('dashboard');

                Route::get('/activities/create', [HumasActivityController::class, 'create'])
                    ->name('activities.create');

                Route::post('/activities', [HumasActivityController::class, 'store'])
                    ->name('activities.store');

                Route::get('/activities/{activity}/edit', [HumasActivityController::class, 'edit'])
                    ->name('activities.edit');

                Route::put('/activities/{activity}', [HumasActivityController::class, 'update'])
                    ->name('activities.update');

                Route::delete('/activities/{activity}', [HumasActivityController::class, 'destroy'])
                    ->name('activities.destroy');
            });

});
