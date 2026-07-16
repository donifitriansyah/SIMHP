<?php

use App\Http\Controllers\AuditeeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IrbanController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\LhpController;
use App\Http\Controllers\MatriksTindakLanjutController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\PihakKetigaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfilInspektoratController;
use App\Http\Controllers\RekomendasiController;
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

Route::get("/dashboard", [DashboardController::class, "index"])
    ->middleware(["auth"])
    ->name("dashboard");

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

    Route::prefix("laporan-hasil-pemeriksaan/{lhp}")->group(function () {
        Route::get("temuan/tambah-data", [TemuanController::class, "create"])->name(
            "temuan.create"
        );

        Route::post("temuan", [TemuanController::class, "store"])->name(
            "temuan.store"
        );
    });

    Route::resource("temuan", TemuanController::class)->except([
        "index",
        "create",
        "store",
    ]);

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

    Route::resource("rekomendasi", RekomendasiController::class)->except([
        "index",
        "create",
        "store",
    ]);

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

    Route::post("/lhp/{lhp}/tetapkan-nihil", [
        LhpController::class,
        "tetapkanNihil",
    ])->name("lhp.tetapkan-nihil");

    Route::put("/lhp/{lhp}/selesai", [LhpController::class, "selesai"])->name(
        "lhp.selesai"
    );

    Route::get("/lhp/filter/{status}", [LhpController::class, "filter"])->name(
        "lhp.filter"
    );

    Route::get("/laporan", [LaporanController::class, "index"])->name(
        "laporan.index"
    );
    Route::get("/laporan-cetak", [LaporanController::class, "cetak"])->name(
        "laporan.cetak"
    );

    Route::get("/auditee/{auditee}/pejabat", [
        LhpController::class,
        "getPejabat",
    ])->name("auditee.pejabat");

    Route::get("/matriks-tindak-lanjut", [
        MatriksTindakLanjutController::class,
        "index",
    ])->name("matriks.index");



    // Akses Khusus Role Super User
    Route::middleware(['auth', 'role:super_user'])->group(function () {


        Route::prefix("master-data")->group(function () {
            Route::resource('pegawai', PegawaiController::class);
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

        // Route::resource("laporan-hasil-pemeriksaan", LhpController::class);

        Route::prefix("laporan-hasil-pemeriksaan/{lhp}")->group(function () {
            Route::get("temuan/create", [TemuanController::class, "create"])->name(
                "temuan.create"
            );

            Route::post("temuan", [TemuanController::class, "store"])->name(
                "temuan.store"
            );
        });

        Route::resource("temuan", TemuanController::class)->except([
            "index",
            "create",
            "store",
        ]);

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

        Route::resource("rekomendasi", RekomendasiController::class)->except([
            "index",
            "create",
            "store",
        ]);

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

        Route::post("/lhp/{lhp}/tetapkan-nihil", [
            LhpController::class,
            "tetapkanNihil",
        ])->name("lhp.tetapkan-nihil");

        Route::put("/lhp/{lhp}/selesai", [LhpController::class, "selesai"])->name(
            "lhp.selesai"
        );

        Route::get("/lhp/filter/{status}", [LhpController::class, "filter"])->name(
            "lhp.filter"
        );


        Route::get("/auditee/{auditee}/pejabat", [
            LhpController::class,
            "getPejabat",
        ])->name("auditee.pejabat");
    });

    Route::get("/lhp", [
        LhpController::class,
        "index",
    ])->name("lhp.index");

    Route::get('/lhp/{lhp}', [
        LhpController::class,
        'show',
    ])->name('lhp.show');

    Route::get("/laporan/irban", [LaporanController::class, "irban"])->name(
        "laporan.irban"
    );

    Route::get(
        '/laporan/irban/cetak',
        [LaporanController::class, 'cetakIrban']
    )->name('laporan.irban.cetak');

    Route::get(
        '/laporan/semua-irban/cetak',
        [LaporanController::class, 'cetakSemuaIrban']
    )->name('laporan.semua-irban.cetak');

    // Route::get("/laporan/irban/cetak", [
    //     LaporanController::class,
    //     "cetakIrban",
    // ])->name("laporan.irban.cetak");


    Route::get("/laporan", [LaporanController::class, "index"])->name(
        "laporan.index"
    );
    Route::get("/laporan-cetak", [LaporanController::class, "cetak"])->name(
        "laporan.cetak"
    );

    Route::get("/matriks-tindak-lanjut", [
        MatriksTindakLanjutController::class,
        "index",
    ])->name("matriks.index");

    Route::get('/lhp/{lhp}/cetak', [LhpController::class, 'cetak'])
        ->name('lhp.cetak');

    Route::get(
        '/laporan/pns-temuan',
        [LaporanController::class, 'pnsTemuan']
    )
        ->name('laporan.pns.temuan');


    Route::get(
        '/laporan/pns-temuan/cetak',
        [LaporanController::class, 'cetakPnsTemuan']
    )
        ->name('laporan.pns.temuan.cetak');

    Route::get(
        '/laporan/pihak-ketiga-temuan/cetak',
        [LaporanController::class, 'cetakPihakKetigaTemuan']
    )->name('laporan.pihak.ketiga.temuan.cetak');

    Route::get(
        '/laporan/pihak-ketiga-temuan',
        [LaporanController::class, 'pihakKetigaTemuan']
    )->name('laporan.pihak.ketiga.temuan');
});

require __DIR__ . "/auth.php";
