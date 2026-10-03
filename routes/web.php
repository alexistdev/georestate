<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Super\{DashboardController as DashSuper, AdminController as AdminSuper};
use App\Http\Controllers\Admin\{DashboardController as DashAdmin,
    ListingController as ListAdmin,
    InquiryController as InquiryAdmin,
    PasswordController as PasswordAdmin,
    PesanController as PesanAdmin
};
use App\Http\Controllers\Admin\Master\{AgentController as AgentAdmin,
    DisctricController as WilayahAdmin,
    FasilitasController as FasilitasAdmin,
    KategoriController as KategoriAdmin,
    UserController as UserAdmin
};

use App\Http\Controllers\Agen\{DashboardController as DashAgen, ListingController as ListAgen, InquiryController as InquiryAgen, ProfilController as ProfilAgen};
use App\Http\Controllers\User\AkunController as AkunUser;

use App\Http\Controllers\Front\{HomeController as FrontHome,
PropertiesController as FrontProp,
    AgenController as FrontAgen,
    AboutController as FrontAbout,
    ContactController as FrontContact,
    FavoritController as FrontFavorit,
    SeoController as FrontSeo,
    InquiryController as FrontInquiry
};

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});

/** Arahkan ke dashboard sesuai role user */
Route::get('/dashboard', function () {
    return redirect(auth()->user()->homeUrl());
})->middleware('auth')->name('dashboard');

Route::middleware('auth')->group(function () {
    /** Halaman profil Breeze tidak dipakai: arahkan ke halaman profil/akun sesuai peran. */
    Route::get('/profile', function () {
        return redirect()->route(match (auth()->user()->roleEnum()) {
            \App\Enums\Role::Agen => 'agn.profil',
            \App\Enums\Role::Admin, \App\Enums\Role::Super => 'adm.password',
            default => 'usr.password',
        });
    })->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::group(['middleware' => ['web', 'auth', 'roles']], function () {
    Route::group(['roles' => 'super'], function () {
        Route::get('/super/dashboard', [DashSuper::class, 'index'])->name('sup.dashboard');

        /** kelola akun admin */
        Route::get('/super/admin', [AdminSuper::class, 'index'])->name('sup.admin');
        Route::post('/super/admin', [AdminSuper::class, 'store'])->name('sup.admin.save');
        Route::whereNumber('user')->group(function () {
            Route::patch('/super/admin/{user}', [AdminSuper::class, 'update'])->name('sup.admin.update');
            Route::patch('/super/admin/{user}/password', [AdminSuper::class, 'resetPassword'])->name('sup.admin.password');
            Route::delete('/super/admin/{user}', [AdminSuper::class, 'destroy'])->name('sup.admin.delete');
            Route::patch('/super/admin/{user}/pulihkan', [AdminSuper::class, 'restore'])->withTrashed()->name('sup.admin.restore');
        });
    });

    /** Area admin; super admin juga punya semua hak admin */
    Route::group(['roles' => ['admin', 'super']], function () {
        Route::get('/staff/dashboard', [DashAdmin::class, 'index'])->name('adm.dashboard');
        Route::get('/staff/password', [PasswordAdmin::class, 'edit'])->name('adm.password');

        /** moderasi listing */
        Route::get('/staff/listing', [ListAdmin::class, 'index'])->name('adm.listing');
        Route::whereUuid('property')->group(function () {
            Route::get('/staff/listing/{property}', [ListAdmin::class, 'show'])->name('adm.listing.show');
            Route::patch('/staff/listing/{property}/approve', [ListAdmin::class, 'approve'])->name('adm.listing.approve');
            Route::patch('/staff/listing/{property}/reject', [ListAdmin::class, 'reject'])->name('adm.listing.reject');
        });

        /** pertanyaan calon penyewa ke agen (lihat & hapus spam) */
        Route::get('/staff/pertanyaan', [InquiryAdmin::class, 'index'])->name('adm.pertanyaan');
        Route::delete('/staff/pertanyaan/{inquiry}', [InquiryAdmin::class, 'destroy'])->whereNumber('inquiry')->name('adm.pertanyaan.delete');

        /** pesan dari form kontak */
        Route::get('/staff/pesan', [PesanAdmin::class, 'index'])->name('adm.pesan');
        Route::get('/staff/pesan/{pesan}', [PesanAdmin::class, 'show'])->whereNumber('pesan')->name('adm.pesan.show');
        Route::delete('/staff/pesan/{pesan}', [PesanAdmin::class, 'destroy'])->whereNumber('pesan')->name('adm.pesan.delete');
        /** kelola agen */
        Route::get('/staff/agent', [AgentAdmin::class, 'index'])->name('adm.agent');
        Route::whereUuid('agent')->group(function () {
            Route::get('/staff/agent/{agent}', [AgentAdmin::class, 'show'])->withTrashed()->name('adm.agent.show');
            Route::patch('/staff/agent/{agent}/suspend', [AgentAdmin::class, 'suspend'])->name('adm.agent.suspend');
            Route::patch('/staff/agent/{agent}/aktifkan', [AgentAdmin::class, 'aktifkan'])->name('adm.agent.aktifkan');
            Route::patch('/staff/agent/{agent}/password', [AgentAdmin::class, 'resetPassword'])->name('adm.agent.password');
            Route::delete('/staff/agent/{agent}', [AgentAdmin::class, 'destroy'])->name('adm.agent.delete');
            Route::patch('/staff/agent/{agent}/pulihkan', [AgentAdmin::class, 'restore'])->withTrashed()->name('adm.agent.restore');
        });

        /** master kategori & fasilitas */
        foreach (['kategori' => KategoriAdmin::class, 'fasilitas' => FasilitasAdmin::class] as $nama => $controller) {
            Route::get("/staff/{$nama}", [$controller, 'index'])->name("adm.{$nama}");
            Route::post("/staff/{$nama}", [$controller, 'store'])->name("adm.{$nama}.save");
            Route::patch("/staff/{$nama}/{id}", [$controller, 'update'])->whereNumber('id')->name("adm.{$nama}.update");
            Route::delete("/staff/{$nama}/{id}", [$controller, 'destroy'])->whereNumber('id')->name("adm.{$nama}.delete");
            Route::patch("/staff/{$nama}/{id}/pulihkan", [$controller, 'restore'])->whereNumber('id')->name("adm.{$nama}.restore");
        }

        /** kelola pencari properti */
        Route::get('/staff/user', [UserAdmin::class, 'index'])->name('adm.user');
        Route::delete('/staff/user/{user}', [UserAdmin::class, 'destroy'])->whereNumber('user')->name('adm.user.delete');
        Route::patch('/staff/user/{user}/password', [UserAdmin::class, 'resetPassword'])->whereNumber('user')->name('adm.user.password');
        Route::patch('/staff/user/{user}/pulihkan', [UserAdmin::class, 'restore'])->whereNumber('user')->withTrashed()->name('adm.user.restore');
        Route::get('/staff/wilayah', [WilayahAdmin::class, 'index'])->name('adm.disctrict');
        Route::post('/staff/wilayah/provinsi', [WilayahAdmin::class, 'provinsi_store'])->name('adm.disctrict.provinsi.save');
        Route::patch('/staff/wilayah/provinsi', [WilayahAdmin::class, 'provinsi_update'])->name('adm.disctrict.provinsi.update');
        Route::delete('/staff/wilayah/provinsi', [WilayahAdmin::class, 'provinsi_destroy'])->name('adm.disctrict.provinsi.delete');

        Route::post('/staff/wilayah/kabupaten', [WilayahAdmin::class, 'kabupaten_store'])->name('adm.disctrict.kabupaten.save');
        Route::patch('/staff/wilayah/kabupaten', [WilayahAdmin::class, 'kabupaten_update'])->name('adm.disctrict.kabupaten.update');
        Route::delete('/staff/wilayah/kabupaten', [WilayahAdmin::class, 'kabupaten_destroy'])->name('adm.disctrict.kabupaten.delete');

        Route::post('/staff/wilayah/kecamatan', [WilayahAdmin::class, 'kecamatan_store'])->name('adm.disctrict.kecamatan.save');
        Route::patch('/staff/wilayah/kecamatan', [WilayahAdmin::class, 'kecamatan_update'])->name('adm.disctrict.kecamatan.update');
        Route::delete('/staff/wilayah/kecamatan', [WilayahAdmin::class, 'kecamatan_destroy'])->name('adm.disctrict.kecamatan.delete');

        /** ajax */
        Route::middleware(['clean', 'ajax'])->group(function () {
            Route::get('/staff/ajax/provinsi', [WilayahAdmin::class, 'get_provinsi'])->name('adm.ajax.provinsi');
            Route::get('/staff/ajax/kabupaten', [WilayahAdmin::class, 'get_kabupaten'])->name('adm.ajax.kabupaten');
            Route::get('/staff/ajax/kecamatan', [WilayahAdmin::class, 'get_kecamatan'])->name('adm.ajax.kecamatan');
        });
    });

    Route::group(['roles' => 'agen'], function () {
        Route::get('/agent/profil', [ProfilAgen::class, 'edit'])->name('agn.profil');
        Route::patch('/agent/profil', [ProfilAgen::class, 'update'])->name('agn.profil.update');
        Route::patch('/agent/profil/email', [ProfilAgen::class, 'updateEmail'])->name('agn.profil.email');
        Route::get('/agent/pertanyaan', [InquiryAgen::class, 'index'])->name('agn.pertanyaan');
        Route::get('/agent/pertanyaan/{inquiry}', [InquiryAgen::class, 'show'])->whereNumber('inquiry')->name('agn.pertanyaan.show');
        Route::patch('/agent/pertanyaan/{inquiry}/status', [InquiryAgen::class, 'updateStatus'])->whereNumber('inquiry')->name('agn.pertanyaan.status');
        Route::get('/agent/dashboard', [DashAgen::class, 'index'])->name('agn.dashboard');
        Route::get('/agent/lists', [ListAgen::class, 'index'])->name('agn.lists');
        Route::post('/agent/lists', [ListAgen::class, 'store'])->name('agn.lists.save');
        Route::get('/agent/lists/add', [ListAgen::class, 'create'])->name('agn.lists.add');
        Route::get('/agent/lists/kabupaten/{id}', [ListAgen::class, 'getKabupaten'])->name('agn.lists.kabupaten');
        Route::get('/agent/lists/kecamatan/{id}', [ListAgen::class, 'getKecamatan'])->name('agn.lists.kecamatan');

        Route::whereUuid('property')->group(function () {
            Route::get('/agent/lists/{property}', [ListAgen::class, 'show'])->name('agn.lists.show');
            Route::get('/agent/lists/{property}/edit', [ListAgen::class, 'edit'])->name('agn.lists.edit');
            Route::patch('/agent/lists/{property}', [ListAgen::class, 'update'])->name('agn.lists.update');
            Route::delete('/agent/lists/{property}', [ListAgen::class, 'destroy'])->name('agn.lists.delete');
            Route::delete('/agent/lists/{property}/gambar/{gambar}', [ListAgen::class, 'destroyGambar'])->name('agn.lists.gambar.delete');
            Route::patch('/agent/lists/{property}/gambar/{gambar}/utama', [ListAgen::class, 'setGambarUtama'])->name('agn.lists.gambar.utama');
        });
    });
});

/** Area pencari properti */
Route::group(['middleware' => ['web', 'auth', 'roles'], 'roles' => 'user'], function () {
    Route::get('/akun/favorit', [AkunUser::class, 'favorit'])->name('usr.favorit');
    Route::get('/akun/pertanyaan', [AkunUser::class, 'pertanyaan'])->name('usr.pertanyaan');
    Route::get('/akun/password', [AkunUser::class, 'password'])->name('usr.password');
    Route::post('/properties/{slug}/favorit', [FrontFavorit::class, 'toggle'])->name('front.favorit.toggle');
});

/** Halaman publik: bisa diakses tamu maupun user yang sudah login */
Route::group([], function () {
    Route::get('/', [FrontHome::class, 'index'])->name('front.home');
    Route::get('/properties', [FrontProp::class, 'index'])->name('front.properties');
    Route::get('/properties/{slug}', [FrontProp::class, 'show'])->name('front.properties.detail');
    Route::get('/agents', [FrontAgen::class, 'index'])->name('front.agents');
    Route::get('/agents/{agent}', [FrontAgen::class, 'show'])->whereUuid('agent')->name('front.agents.detail');
    Route::get('/about', [FrontAbout::class, 'index'])->name('front.about');
    Route::get('/contact', [FrontContact::class, 'index'])->name('front.contact');
    Route::post('/contact', [FrontContact::class, 'store'])->middleware('throttle:5,1')->name('front.contact.store');
    Route::post('/properties/{slug}/tanya', [FrontInquiry::class, 'store'])->middleware('throttle:5,1')->name('front.inquiry.store');
    Route::get('/properties/{slug}/favorit/masuk', [FrontFavorit::class, 'masuk'])->middleware('guest')->name('front.favorit.masuk');

    Route::get('/sitemap.xml', [FrontSeo::class, 'sitemap'])->name('front.sitemap');
    Route::get('/robots.txt', [FrontSeo::class, 'robots'])->name('front.robots');

    /** ajax dropdown wilayah untuk filter pencarian */
    Route::get('/wilayah/kabupaten/{provinsi}', [FrontProp::class, 'kabupaten'])->whereNumber('provinsi')->name('front.wilayah.kabupaten');
    Route::get('/wilayah/kecamatan/{kabupaten}', [FrontProp::class, 'kecamatan'])->whereNumber('kabupaten')->name('front.wilayah.kecamatan');
});

require __DIR__.'/auth.php';
