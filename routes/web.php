<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Super\DashboardController as DashSuper;
use App\Http\Controllers\Admin\{DashboardController as DashAdmin};
use App\Http\Controllers\Admin\Master\{AgentController as AgentAdmin,
    DisctricController as WilayahAdmin
};

use App\Http\Controllers\Agen\{DashboardController as DashAgen,ListingController as ListAgen};

use App\Http\Controllers\Front\{HomeController as FrontHome,
PropertiesController as FrontProp,
    AgenController as FrontAgen,
    AboutController as FrontAbout,
    ContactController as FrontContact
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
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::group(['middleware' => ['web', 'auth', 'roles']], function () {
    Route::group(['roles' => 'super'], function () {
        Route::get('/super/dashboard', [DashSuper::class, 'index'])->name('sup.dashboard');
    });

    Route::group(['roles' => 'admin'], function () {
        Route::get('/staff/dashboard', [DashAdmin::class, 'index'])->name('adm.dashboard');
        Route::get('/staff/agent', [AgentAdmin::class, 'index'])->name('adm.agent');
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

    /** ajax dropdown wilayah untuk filter pencarian */
    Route::get('/wilayah/kabupaten/{provinsi}', [FrontProp::class, 'kabupaten'])->whereNumber('provinsi')->name('front.wilayah.kabupaten');
    Route::get('/wilayah/kecamatan/{kabupaten}', [FrontProp::class, 'kecamatan'])->whereNumber('kabupaten')->name('front.wilayah.kecamatan');
});

require __DIR__.'/auth.php';
