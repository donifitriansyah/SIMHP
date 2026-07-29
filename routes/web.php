<?php

use App\Http\Controllers\AuditeeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EditRequestController;
use App\Http\Controllers\IrbanController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\LhpController;
use App\Http\Controllers\MatriksTindakLanjutController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\PenandatanganLaporanController;
use App\Http\Controllers\PerangkatDesaController;
use App\Http\Controllers\PihakKetigaController;
use App\Http\Controllers\PihakLainController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfilInspektoratController;
use App\Http\Controllers\RegisterLhpController;
use App\Http\Controllers\RekomendasiController;
use App\Http\Controllers\SkpdController;
use App\Http\Controllers\TemuanController;
use App\Http\Controllers\TindakLanjutController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;




Route::get('/', function () {

    if (Auth::check()) {
        return redirect()->route('dashboard');
    }

    return redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {
    Route::get("/dashboard", [DashboardController::class, "index"])->name("dashboard");

    Route::get('/pemeriksaan/internal', [LhpController::class, 'index'])->defaults('jenis', 'internal')->name('pemeriksaan.internal');

    Route::get('/pemeriksaan/eksternal', [LhpController::class, 'index'])->defaults('jenis', 'eksternal')->name('pemeriksaan.eksternal');

    Route::get('/dashboard/internal', [DashboardController::class, 'index'])
        ->defaults('jenis', 'internal')
        ->name('dashboard.internal');

    Route::get('/lhp/{lhp}/cetak', [LhpController::class, 'cetak'])
        ->name('lhp.cetak');



    Route::get('/dashboard/eksternal', [DashboardController::class, 'index'])
        ->defaults('jenis', 'eksternal')
        ->name('dashboard.eksternal');
    Route::get(
        '/register-lhp',
        [RegisterLhpController::class, 'index']
    )->name('register.lhp.index');
});

Route::middleware(['auth', 'role:super_user,user_entry'])->group(function () {
    Route::post(
        '/lhp/{lhp}/tetapkan-tt',
        [LhpController::class, 'tetapkanTT']
    )
        ->name('lhp.tetapkan-tt');
    Route::prefix('pihak-lain')->name('pihak-lain.')->group(function () {

        Route::get('/', [PihakLainController::class, 'index'])->name('index');

        Route::post('/', [PihakLainController::class, 'store'])->name('store');

        Route::put('/{pihakLain}', [PihakLainController::class, 'update'])->name('update');

        Route::delete('/{pihakLain}', [PihakLainController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('perangkat-desa')->name('perangkat-desa.')->group(function () {

        Route::get('/', [PerangkatDesaController::class, 'index'])->name('index');

        Route::post('/', [PerangkatDesaController::class, 'store'])->name('store');

        Route::put('/{perangkatDesa}', [PerangkatDesaController::class, 'update'])->name('update');

        Route::delete('/{perangkatDesa}', [PerangkatDesaController::class, 'destroy'])->name('destroy');
    });

    Route::get('/laporan/pihak-ketiga-temuan', [LaporanController::class, 'pihakKetigaTemuan'])->name('laporan.pihak.ketiga.temuan');

    Route::get('/laporan/irban', [LaporanController::class, 'irban'])->name('laporan.irban');

    Route::get("/laporan-cetak", [LaporanController::class, "cetak"])->name("laporan.cetak");

    Route::get('/laporan/pns-temuan', [LaporanController::class, 'pnsTemuan'])->name('laporan.pns.temuan');

    Route::get('/laporan/pns-temuan/cetak', [LaporanController::class, 'cetakPnsTemuan'])->name('laporan.pns.temuan.cetak');

    Route::get('/laporan/pihak-ketiga-temuan/cetak', [LaporanController::class, 'cetakPihakKetigaTemuan'])->name('laporan.pihak.ketiga.temuan.cetak');

    Route::get('/laporan/irban/cetak', [LaporanController::class, 'cetakIrban'])->name('laporan.irban.cetak');

    Route::get('/laporan/semua-irban/cetak', [LaporanController::class, 'cetakSemuaIrban'])->name('laporan.semua-irban.cetak');

    Route::get("/laporan", [LaporanController::class, "index"])->name("laporan.index");

    Route::get("/matriks-tindak-lanjut", [MatriksTindakLanjutController::class, "index",])->name("matriks.index");
    Route::get('/pegawai/template', [PegawaiController::class, 'downloadTemplate'])
        ->name('pegawai.template');

    Route::post('/pegawai/import', [PegawaiController::class, 'import'])
        ->name('pegawai.import');

    Route::resource('penandatangan', PenandatanganLaporanController::class)
        ->except(['show', 'create', 'edit']);



    Route::get(
        '/register-lhp/cetak',
        [RegisterLhpController::class, 'cetak']
    )->name('register.lhp.cetak');
    Route::resource('skpd', SkpdController::class);

    Route::get('/pemeriksaan/internal/create', [LhpController::class, 'create'])->defaults('jenis', 'internal')->name('lhp.internal.create');

    Route::resource('irban', IrbanController::class);

    Route::resource('auditee', AuditeeController::class);

    Route::resource('pihak-ketiga', PihakKetigaController::class);

    Route::resource('pegawai', PegawaiController::class);

    // Manajemen User
    Route::resource('users', UserController::class);

    // Profil Inspektorat jika hanya admin
    Route::resource('profil-inspektorat', ProfilInspektoratController::class);

    // Input LHP
    Route::get('/lhp/create/{jenis?}', [LhpController::class, 'create'])->name('lhp.create');

    Route::post('/lhp/store', [LhpController::class, 'store'])->name('lhp.store');

    Route::prefix("temuan/{temuan}")->group(function () {
        Route::get("rekomendasi/create", [
            RekomendasiController::class,
            "create",
        ])->name("rekomendasi.create");

        Route::post("rekomendasi", [
            RekomendasiController::class,
            "store",
        ])->name("rekomendasi.store");
    });

    Route::resource("temuan", TemuanController::class)->except([
        "index",
        "create",
        "store",
    ]);

    Route::resource("rekomendasi", RekomendasiController::class)->except([
        "index",
        "create",
        "store",
    ]);

    Route::put(
        '/edit-requests/{editRequest}/complete',
        [EditRequestController::class, 'complete']
    )->name('edit-requests.complete');

    Route::post('/edit-requests', [EditRequestController::class, 'store'])->name('edit-requests.store');
});

Route::middleware(['auth', 'role:super_user'])->group(function () {

    Route::prefix('edit-requests')->name('edit-requests.')
        ->group(function () {
            Route::get('/', [EditRequestController::class, 'index'])
                ->name('index');

            Route::put('/{editRequest}/approve', [EditRequestController::class, 'approve'])
                ->name('approve');

            Route::put('/{editRequest}/reject', [EditRequestController::class, 'reject'])
                ->name('reject');
        });
});


Route::prefix("laporan-hasil-pemeriksaan/{lhp}")->group(function () {
    Route::get("temuan/tambah-data", [TemuanController::class, "create"])->name(
        "temuan.create"
    );

    Route::post("temuan", [TemuanController::class, "store"])->name(
        "temuan.store"
    );
});

Route::middleware("auth")->group(function () {
    Route::get("/profile", [ProfileController::class, "edit"])->name(
        "profile.edit"
    );
    Route::patch("/profile", [ProfileController::class, "update"])->name(
        "profile.update"
    );
    Route::delete("/profile", [ProfileController::class, "destroy"])->name(
        "profile.destroy"
    );

    Route::prefix("master-data")->group(function () {
        Route::get("/profil-inspektorat", [
            ProfilInspektoratController::class,
            "index",
        ])->name("profil-inspektorat.index");

        Route::post("/profil-inspektorat", [
            ProfilInspektoratController::class,
            "store",
        ])->name("profil-inspektorat.store");

        Route::put("/profil-inspektorat/{profil_inspektorat}", [
            ProfilInspektoratController::class,
            "update",
        ])->name("profil-inspektorat.update");
    });

    Route::resource("master-data/users", UserController::class)->names("users");

    Route::resource("master-data/irban", IrbanController::class);

    Route::resource("master-data/auditee", AuditeeController::class);

    Route::resource("master-data/pihak-ketiga", PihakKetigaController::class);

    Route::resource("lhp", LhpController::class);

    Route::prefix("rekomendasi/{rekomendasi}")->group(function () {
        Route::get("tindak-lanjut/create", [
            TindakLanjutController::class,
            "create",
        ])->name("tindak-lanjut.create");

        Route::post("tindak-lanjut", [
            TindakLanjutController::class,
            "store",
        ])->name("tindak-lanjut.store");
    });

    Route::resource("tindak-lanjut", TindakLanjutController::class)->except([
        "index",
        "create",
        "store",
    ]);

    Route::put("/lhp/{lhp}/selesai", [LhpController::class, "selesai"])->name(
        "lhp.selesai"
    );

    Route::get("/lhp/filter/{status}", [LhpController::class, "filter"])->name(
        "lhp.filter"
    );

    Route::get(
        '/auditee/{auditee}/pejabat',
        [LhpController::class, 'getPejabat']
    )->name('auditee.pejabat');

    Route::get(
        '/get-pejabat/{auditee}',
        [LhpController::class, 'getPejabat']
    )->name('get.pejabat');

    Route::delete(
        '/lhp-objek-pemeriksaan/{id}',
        [LhpController::class, 'hapusObjek']
    )->name('lhp.objek.hapus');


    // Akses Khusus Role Super User
    Route::middleware(['auth', 'role:super_user'])->group(function () {
        Route::post("/lhp/{lhp}/tetapkan-nihil", [
            LhpController::class,
            "tetapkanNihil",
        ])->name("lhp.tetapkan-nihil");
    });



    Route::get('/temuan', [TemuanController::class, 'index'])
        ->name('temuan.index');

    Route::get('/lhp/{lhp}/cetak', [LhpController::class, 'cetak'])
        ->name('lhp.cetak');


    Route::get('/rekomendasi', [RekomendasiController::class, 'index'])
        ->name('rekomendasi.index');

    Route::get('/tindak-lanjut', [TindakLanjutController::class, 'index'])
        ->name('tindak-lanjut.index');

    Route::get('/lhp-lengkap', [LhpController::class, 'lengkap'])
        ->name('lhp.lengkap');

    Route::get('/lhp-belum-lengkap', [LhpController::class, 'belumLengkap'])
        ->name('lhp.belum-lengkap');

    Route::get(
        '/pemeriksaan/eksternal/create',
        [LhpController::class, 'create']
    )
        ->defaults('jenis', 'eksternal')
        ->name('lhp.eksternal.create');
});

require __DIR__ . "/auth.php";
