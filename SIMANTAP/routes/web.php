<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TempatController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\VerifikasiController;
use App\Http\Controllers\JenisBarangController;
use App\Http\Controllers\BarangLokasiController;
use App\Http\Controllers\JenisTeknisiController;
use App\Http\Controllers\PerbaikanController;
use App\Http\Controllers\PeriodeController;
use App\Http\Controllers\KategoriKerusakanController;
use App\Http\Controllers\BobotController;
use App\Http\Controllers\FeedbackController;

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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [WelcomeController::class,'landing'])->name('landing');


Route::get('login', [AuthController::class,'login'])->name('login');
Route::post('login', [AuthController::class,'postlogin']);
Route::get('logout', [AuthController::class,'logout'])->middleware('auth');

Route::get('register', [AuthController::class, 'register'])->name('register');
Route::post('register', [AuthController::class, 'postregister']);

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/dashboard', [WelcomeController::class,'dashboard'])->name('dashboard');
    Route::get('/dashboard/chart-data', [WelcomeController::class, 'chartData'])->name('dashboard.chartData');
    Route::get('/dashboard/chart-data2', [WelcomeController::class, 'chartData2'])->name('dashboard.chartData2');

    // notifikasi
    Route::get('/notifikasi', [NotifikasiController::class, 'index'])->name('notifikasi.index');
    Route::post('/notifikasi/{id}/read', [NotifikasiController::class, 'markRead'])->name('notifikasi.read');

    Route::middleware(['authorize:ADM'])->group(function () {
        Route::get('user', [UserController::class,'index'])->name('user.index');
        Route::post('user/list', [UserController::class,'list'])->name('user.list');
        Route::get('user/create', [UserController::class,'create'])->name('user.create');
        Route::get('user/{id}/show/', [UserController::class,'show'])->name('user.show');
        Route::post('user/store', [UserController::class,'store'])->name('user.store');
        Route::get('user/{id}/edit/', [UserController::class,'edit'])->name('user.edit');
        Route::put('user/{id}/update/', [UserController::class,'update'])->name('user.update');
        Route::get('user/{id}/delete/', [UserController::class,'confirmDelete'])->name('user.confirmDelete');
        Route::delete('user/{id}/delete/', [UserController::class,'destroy'])->name('user.delete');
        Route::post('/user/toggle-status', [UserController::class, 'toggleStatus'])->name('user.toggleStatus');
        Route::get('user/import', [UserController::class, 'import'])->name('user.import');
        Route::post('user/import_ajax', [UserController::class, 'import_ajax'])->name('user.importAjax');

        //role
        Route::get('role', [RoleController::class,'index'])->name('role.index');
        Route::post('role/list', [RoleController::class,'list'])->name('role.list');
        Route::get('role/create', [RoleController::class,'create'])->name('role.create');
        Route::get('role/{id}/show/', [RoleController::class,'show'])->name('role.show');
        Route::post('role/store', [RoleController::class,'store'])->name('role.store');
        Route::get('role/{id}/edit/', [RoleController::class,'edit'])->name('role.edit');
        Route::put('role/{id}/update/', [RoleController::class,'update'])->name('role.update');
        Route::get('role/{id}/delete/', [RoleController::class,'confirmDelete'])->name('role.confirmDelete');
        Route::delete('role/{id}/delete/', [RoleController::class,'destroy'])->name('role.delete');

        //jenis teknisi
        Route::get('jenisteknisi', [JenisTeknisiController::class,'index'])->name('jenisteknisi.index');
        Route::post('jenisteknisi/list', [JenisTeknisiController::class,'list'])->name('jenisteknisi.list');
        Route::get('jenisteknisi/create', [JenisTeknisiController::class,'create'])->name('jenisteknisi.create');
        Route::get('jenisteknisi/{id}/show/', [JenisTeknisiController::class,'show'])->name('jenisteknisi.show');
        Route::post('jenisteknisi/store', [JenisTeknisiController::class,'store'])->name('jenisteknisi.store');
        Route::get('jenisteknisi/{id}/edit/', [JenisTeknisiController::class,'edit'])->name('jenisteknisi.edit');
        Route::put('jenisteknisi/{id}/update/', [JenisTeknisiController::class,'update'])->name('jenisteknisi.update');
        Route::get('jenisteknisi/{id}/delete/', [JenisTeknisiController::class,'confirmDelete'])->name('jenisteknisi.confirmDelete');
        Route::delete('jenisteknisi/{id}/delete/', [JenisTeknisiController::class,'destroy'])->name('jenisteknisi.delete');

        // Unit
        Route::get('unit', [UnitController::class,'index'])->name('unit.index');
        Route::post('unit/list', [UnitController::class,'list'])->name('unit.list');
        Route::get('unit/create', [UnitController::class,'create'])->name('unit.create');
        Route::get('unit/{id}/show/', [UnitController::class,'show'])->name('unit.show');
        Route::post('unit/store', [UnitController::class,'store'])->name('unit.store');
        Route::get('unit/{id}/edit/', [UnitController::class,'edit'])->name('unit.edit');
        Route::put('unit/{id}/update/', [UnitController::class,'update'])->name('unit.update');
        Route::get('unit/{id}/delete/', [UnitController::class,'confirmDelete'])->name('unit.confirmDelete');
        Route::delete('unit/{id}/delete/', [UnitController::class,'destroy'])->name('unit.delete');

        // Tempat
        Route::get('tempat/{unit_id}/popup', [TempatController::class, 'popup']);
        Route::get('tempat/{unit_id}/show/{tempat_id}', [TempatController::class, 'show']);
        Route::get('tempat/{unit_id}/create', [TempatController::class, 'create']);
        Route::post('tempat/{unit_id}/store', [TempatController::class, 'store']);
        Route::get('tempat/{unit_id}/edit/{tempat_id}', [TempatController::class, 'edit']);
        Route::put('tempat/{unit_id}/update/{tempat_id}', [TempatController::class, 'update']);
        Route::get('tempat/{unit_id}/delete/{tempat_id}', [TempatController::class, 'confirmDelete']);
        Route::delete('tempat/{unit_id}/delete/{tempat_id}', [TempatController::class, 'destroy']);

        // Jenis Barang
        Route::get('jenisbarang', [JenisBarangController::class,'index'])->name('jenisbarang.index');
        Route::post('jenisbarang/list', [JenisBarangController::class,'list'])->name('jenisbarang.list');
        Route::get('jenisbarang/create', [JenisBarangController::class,'create'])->name('jenisbarang.create');
        Route::get('jenisbarang/{id}/show/', [JenisBarangController::class,'show'])->name('jenisbarang.show');
        Route::post('jenisbarang/store', [JenisBarangController::class,'store'])->name('jenisbarang.store');
        Route::get('jenisbarang/{id}/edit/', [JenisBarangController::class,'edit'])->name('jenisbarang.edit');
        Route::put('jenisbarang/{id}/update/', [JenisBarangController::class,'update'])->name('jenisbarang.update');
        Route::get('jenisbarang/{id}/delete/', [JenisBarangController::class,'confirmDelete'])->name('jenisbarang.confirmDelete');
        Route::delete('jenisbarang/{id}/delete/', [JenisBarangController::class,'destroy'])->name('jenisbarang.delete');

        // Lokasi Barang
        Route::get('lokasibarang', [BarangLokasiController::class, 'index'])->name('lokasibarang.index');
        Route::post('lokasibarang/list', [BarangLokasiController::class, 'list'])->name('lokasibarang.list');
        Route::get('lokasibarang/{tempat_id}/show', [BarangLokasiController::class, 'show'])->name('lokasibarang.show');
        Route::get('lokasibarang/{tempat_id}/create', [BarangLokasiController::class, 'create'])->name('lokasibarang.create');
        Route::post('lokasibarang/{tempat_id}/store', [BarangLokasiController::class, 'store'])->name('lokasibarang.store');
        Route::put('/lokasibarang/{barang_lokasi_id}/updateJumlah', [BarangLokasiController::class, 'updateJumlah'])->name('lokasibarang.updateJumlah');
        Route::get('/lokasibarang/{tempat_id}/confirmDelete/{jenis_barang_id}', [BarangLokasiController::class, 'confirmDelete'])->name('lokasibarang.confirmDelete');
        Route::delete('/lokasibarang/{tempat_id}/delete/{jenis_barang_id}', [BarangLokasiController::class, 'delete'])->name('lokasibarang.delete');

        // Bobot
        Route::get('bobot', [BobotController::class, 'index'])->name('bobot.index');
        Route::post('bobot/list', [BobotController::class, 'list'])->name('bobot.list');
        Route::get('bobot/edit', [BobotController::class, 'edit'])->name('bobot.edit');
        Route::post('bobot/update-all', [BobotController::class, 'updateAll'])->name('bobot.updateAll');

        // Periode
        Route::get('periode', [PeriodeController::class, 'index'])->name('periode.index');
        Route::post('periode/list', [PeriodeController::class, 'list'])->name('periode.list');
        Route::get('periode/create', [PeriodeController::class, 'create'])->name('periode.create');
        Route::post('periode/store', [PeriodeController::class, 'store'])->name('periode.store');
        Route::get('periode/{id}/edit', [PeriodeController::class, 'edit'])->name('periode.edit');
        Route::put('periode/{id}/update', [PeriodeController::class, 'update'])->name('periode.update');
        Route::get('periode/{id}/show', [PeriodeController::class, 'show'])->name('periode.show');
        Route::get('periode/{id}/delete', [PeriodeController::class, 'confirmDelete'])->name('periode.confirmDelete');
        Route::delete('periode/{id}/delete', [PeriodeController::class, 'destroy'])->name('periode.delete');

        // Kategori Kerusakan
        Route::get('kategoriKerusakan', [KategoriKerusakanController::class, 'index'])->name('jenisKerusakan.index');
        Route::post('kategoriKerusakan/list', [KategoriKerusakanController::class, 'list'])->name('jenisKerusakan.list');
        Route::get('kategoriKerusakan/create', [KategoriKerusakanController::class, 'create'])->name('jenisKerusakan.create');
        Route::post('kategoriKerusakan/store', [KategoriKerusakanController::class, 'store'])->name('jenisKerusakan.store');
        Route::get('kategoriKerusakan/{id}/edit', [KategoriKerusakanController::class, 'edit'])->name('jenisKerusakan.edit');
        Route::put('kategoriKerusakan/{id}/update', [KategoriKerusakanController::class, 'update'])->name('jenisKerusakan.update');
        Route::get('kategoriKerusakan/{id}/show', [KategoriKerusakanController::class, 'show'])->name('jenisKerusakan.show');
        Route::get('kategoriKerusakan/{id}/delete', [KategoriKerusakanController::class, 'confirmDelete'])->name('jenisKerusakan.confirmDelete');
        Route::delete('kategoriKerusakan/{id}/delete', [KategoriKerusakanController::class, 'destroy'])->name('jenisKerusakan.delete');

    });

    Route::middleware(['authorize:MHS,DSN,TDK'])->group(function () {
        Route::get('laporan', [LaporanController::class,'index'])->name('laporan.index');
        Route::get('/riwayatlaporan', [LaporanController::class, 'riwayatLaporan'])->name('riwayatlaporan');
        Route::post('laporan/list', [LaporanController::class,'list'])->name('laporan.list');
        Route::get('/laporan/{id}/show', [LaporanController::class, 'show'])->name('laporan.show');
        Route::post('laporan/store', [LaporanController::class,'store'])->name('laporan.store');
        // Route::get('laporan/{id}/edit/', [LaporanController::class,'edit'])->name('laporan.edit');
        // Route::put('laporan/{id}/update/', [LaporanController::class,'update'])->name('laporan.update');
        Route::get('laporan/{id}/delete/', [LaporanController::class,'confirmDelete'])->name('laporan.confirmDelete');
        Route::delete('laporan/{id}/delete/', [LaporanController::class,'destroy'])->name('laporan.delete');
        Route::get('/statusperbaikan', [LaporanController::class, 'statusPerbaikan'])->name('statusperbaikan');
        Route::get('/statusperbaikan/{laporan_id}/show', [LaporanController::class, 'showStatusPerbaikan'])->name('statusperbaikan.show');

        // Feedback
        Route::get('feedback', [FeedbackController::class, 'index'])->name('feedback.index');
        Route::get('feedback/list', [FeedbackController::class, 'list'])->name('feedback.list');
        Route::get('/feedback/{id}/show', [FeedbackController::class, 'show'])->name('feedback.show');
        Route::post('feedback/{id}/store', [FeedbackController::class, 'store'])->name('feedback.store');
        Route::put('feedback/{id}/update', [FeedbackController::class, 'update'])->name('feedback.update');


    });

    Route::middleware(['authorize:ADM,SRN'])->group(function () {
        // Verif Laporan
        Route::get('verifikasi', [VerifikasiController::class, 'index'])->name('verifikasi.index');
        Route::post('verifikasi/list', [VerifikasiController::class, 'list'])->name('verifikasi.list');
        Route::get('verifikasi/{laporan_id}/show', [VerifikasiController::class, 'show'])->name('verifikasi.show');
        Route::post('verifikasi/{laporan_id}/verify', [VerifikasiController::class, 'verify'])->name('verifikasi.verify');
        Route::post('verifikasi/{laporan_id}/reject', [VerifikasiController::class, 'reject'])->name('verifikasi.reject');
        Route::get('riwayatverifikasi', [VerifikasiController::class, 'riwayatVerifikasi'])->name('riwayatverifikasi');
        Route::get('/riwayatverifikasi/{laporan_id}/show', [VerifikasiController::class, 'showRiwayatVerif'])->name('riwayatverifikasi.show');
        Route::get('/riwayatverifikasi/{laporan_id}/feedback', [VerifikasiController::class, 'showFeedback']);
        Route::get('verifikasi/{laporan_id}/prioritas', [VerifikasiController::class, 'showPrioritas'])->name('verifikasi.prioritas.show');

        Route::get('laporan/laporanadmin', [LaporanController::class, 'laporanadmin'])->name('laporan.laporanadmin'); // laporan pdf admin
    });

    Route::middleware(['authorize:TKS'])->group(function () {
        // perbaikan
        Route::get('perbaikan', [PerbaikanController::class, 'index'])->name('perbaikan.index');
        Route::post('perbaikan/list', [PerbaikanController::class, 'list'])->name('perbaikan.list');
        Route::get('perbaikan/{perbaikan_id}/show', [PerbaikanController::class, 'show'])->name('perbaikan.show');
        Route::put('perbaikan/{id}/kerjakan/', [PerbaikanController::class,'kerjakan'])->name('perbaikan.kerjakan');

        Route::get('dikerjakan', [PerbaikanController::class, 'dikerjakan'])->name('dikerjakan');
        Route::post('/dikerjakan/list2', [PerbaikanController::class, 'list2'])->name('perbaikan.list2');
        Route::get('dikerjakan/{perbaikan_id}/show', [PerbaikanController::class, 'showdikerjakan'])->name('dikerjakan.show');
        Route::get('dikerjakan/{perbaikan_id}/konfirmasi', [PerbaikanController::class, 'konfirmasi'])->name('perbaikan.konfirmasi');
        Route::put('dikerjakan/{id}/selesai/', [PerbaikanController::class,'selesai'])->name('perbaikan.selesai');

        Route::get('riwayatperbaikan', [PerbaikanController::class, 'riwayatPerbaikan'])->name('riwayatperbaikan');
        Route::post('/riwayatperbaikan/list', [PerbaikanController::class, 'riwayatList'])->name('perbaikan.riwayatList');
        Route::get('riwayatperbaikan/{perbaikan_id}/show', [PerbaikanController::class, 'showRiwayatPerbaikan'])->name('riwayatperbaikan.show');
        Route::get('riwayatperbaikan/{perbaikan_id}/feedback', [PerbaikanController::class, 'showFeedback']);

    });
});
