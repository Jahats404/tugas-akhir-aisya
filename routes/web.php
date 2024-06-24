<?php

use App\Http\Controllers\arsip\KependudukanController;
use App\Http\Controllers\arsip\KesehatanController;
use App\Http\Controllers\arsip\PendidikanController;
use App\Http\Controllers\arsip\PribadiController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\dashboard\DashboardController;
use App\Http\Controllers\KoranController;
use App\Http\Controllers\Masyarakat\MasyarakatKoranController;
use App\Http\Controllers\Petugas\PetugasKoranController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('landing');
});
Route::get('/example', function () {
    return view('admin.index');
});


Route::controller(AuthController::class)->group(function() {
    Route::get('/register', 'register')->name('register');
    Route::post('/store', 'store')->name('store');
    Route::get('/login', 'login')->name('login');
    Route::post('/authenticate', 'authenticate')->name('authenticate');
    Route::get('/home', 'home')->name('home');
    Route::post('/logout', 'logout')->name('logout');
});

// Define Custom Verification Routes
Route::controller(VerificationController::class)->group(function() {
    Route::get('/email/verify', 'notice')->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', 'verify')->name('verification.verify');
    Route::post('/email/resend', 'resend')->name('verification.resend');
});

// Fallback route untuk menangani 404
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});

Route::post('/getkecamatan', [AuthController::class, 'getkecamatan'])->name('getkecamatan');

Route::middleware(['auth'])->group(function () {
    Route::prefix('admin')->name('admin.')->middleware('CekUserLogin:1')->group(function () {
        Route::get('dashboard', [DashboardController::class, 'dashboardA'])->name('dashboard');


        // =============================================== MAP ===============================================================
        $routes = [
            'Adipala', 'Kesugihan', 'Dayeuhluhur', 'Wanareja', 'Majenang', 'Cimanggu', 'Cipari',
            'Karangpucung', 'Sidareja', 'Kedungreja', 'Gandrungmangu', 'Patimuan', 'Bantarsari',
            'Kampunglaut', 'Kawunganten', 'Jeruklegi', 'Cilacaptengah', 'Nusakambangan',
            'Cilacaputara', 'Maos', 'Sampang', 'Kroya', 'Binangun', 'Nusawungu'
            ];
        
            foreach ($routes as $route) {
                Route::get("/desa-{$route}", [DashboardController::class, $route])->name($route);
            }
        // =============================================== KORAN ===============================================================
        Route::get('koran', [PetugasKoranController::class, 'index'])->name('koran');
        Route::post('koran-store', [MasyarakatKoranController::class, 'store'])->name('koran-store');
        Route::put('koran-update/{id}', [MasyarakatKoranController::class, 'update'])->name('koran-update');
        Route::delete('koran-destroy/{id}', [MasyarakatKoranController::class, 'destroy'])->name('koran-destroy');
        Route::post('status/{id}', [PetugasKoranController::class, 'status'])->name('status');
        Route::get('detail-koran/{id}', [PetugasKoranController::class, 'detail'])->name('koran-detail');

    });

    Route::prefix('masyarakat')->name('masyarakat.')->middleware('CekUserLogin:2')->group(function () {
        Route::get('dashboard', [DashboardController::class, 'dashboardM'])->name('dashboard');
        // =============================================== PROFILE ===============================================================
        Route::get('/profile', [UserController::class, 'index'])->name('profile');
        // Route::get('api', [DashboardController::class, 'index'])->name('api');
        Route::put('/profile-update',[UserController::class, 'update_profile'])->name('update-profile');
        Route::put('/password-update',[UserController::class, 'update_password'])->name('update-password');
        Route::post('/fotodir-update',[UserController::class, 'update_fotodir'])->name('update-fotodir');
        Route::post('/foto-update',[UserController::class, 'update_foto'])->name('update-foto');
        // =============================================== ARKEP ===============================================================
        Route::get('arkep', [KependudukanController::class, 'index'])->name('arkep');
        Route::post('arkep-store', [KependudukanController::class, 'store'])->name('arkep-store');
        Route::put('arkep-update/{id_arkep}', [KependudukanController::class, 'update'])->name('arkep-update');
        Route::delete('arkep-destroy/{id_arkep}', [KependudukanController::class, 'destroy'])->name('arkep-destroy');
        // =============================================== ARKES ===============================================================
        Route::get('arkes', [KesehatanController::class, 'index'])->name('arkes');
        Route::post('arkes-store', [KesehatanController::class, 'store'])->name('arkes-store');
        Route::put('arkes-update/{id_arkes}', [KesehatanController::class, 'update'])->name('arkes-update');
        Route::delete('arkes-destroy/{id_arkes}', [KesehatanController::class, 'destroy'])->name('arkes-destroy');
        // =============================================== ARPEN ===============================================================
        Route::get('arpen', [PendidikanController::class, 'index'])->name('arpen');
        Route::post('arpen-store', [PendidikanController::class, 'store'])->name('arpen-store');
        Route::put('arpen-update/{id_arpen}', [PendidikanController::class, 'update'])->name('arpen-update');
        Route::delete('arpen-destroy/{id_arpen}', [PendidikanController::class, 'destroy'])->name('arpen-destroy');
        // =============================================== ARPRI ===============================================================
        Route::get('arpri', [PribadiController::class, 'index'])->name('arpri');
        Route::post('arpri-store', [PribadiController::class, 'store'])->name('arpri-store');
        Route::put('arpri-update/{id_arpri}', [PribadiController::class, 'update'])->name('arpri-update');
        Route::delete('arpri-destroy/{id_arpri}', [PribadiController::class, 'destroy'])->name('arpri-destroy');
        // =============================================== KORAN ===============================================================
        Route::get('koran', [MasyarakatKoranController::class, 'index'])->name('koran-pengajuan');
        Route::post('koran-store', [MasyarakatKoranController::class, 'store'])->name('koran-pengajuan-store');
        Route::put('koran-update/{id}', [MasyarakatKoranController::class, 'update'])->name('koran-pengajuan-update');
        Route::delete('koran-destroy/{id}', [MasyarakatKoranController::class, 'destroy'])->name('koran-pengajuan-destroy');
        Route::get('detail-koran/{id}', [MasyarakatKoranController::class, 'detail'])->name('koran-pengajuan-detail');
        // =============================================== DETAIL KORAN ===============================================================
        Route::post('detail-koran-store', [MasyarakatKoranController::class, 'storeImage'])->name('koran-pengajuan-image-store');
        Route::delete('koran-detail-destroy/{id}', [MasyarakatKoranController::class, 'destroyImage'])->name('koran-detail-pengajuan-destroy');
    });
});

