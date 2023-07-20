<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\{DashboardController as DashAdmin};
use App\Http\Controllers\Admin\Master\AgentController as AgentAdmin;
use App\Http\Controllers\Front\{HomeController as FrontHome,
PropertiesController as FrontProp,
    AgenController as FrontAgen,
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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::group(['middleware' => ['web', 'auth', 'roles']], function () {
    Route::group(['roles' => 'admin'], function () {
        Route::get('/staff/dashboard', [DashAdmin::class, 'index'])->name('adm.dashboard');
        Route::get('/staff/agent', [AgentAdmin::class, 'index'])->name('adm.agent');
    });
});

Route::middleware('guest')->group(function () {
    Route::get('/', [FrontHome::class, 'index'])->name('front.home');
    Route::get('/properties', [FrontProp::class, 'index'])->name('front.properties');
    Route::get('/properties/{id}/detail', [FrontProp::class, 'detail'])->name('front.properties.detail');
    Route::get('/agents', [FrontAgen::class, 'index'])->name('front.agents');
});

require __DIR__.'/auth.php';
