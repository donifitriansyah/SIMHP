<?php

use App\Http\Controllers\AuditeeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IrbanController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\LhpController;
use App\Http\Controllers\MatriksTindakLanjutController;
use App\Http\Controllers\PihakKetigaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfilInspektoratController;
use App\Http\Controllers\RekomendasiController;
use App\Http\Controllers\TemuanController;
use App\Http\Controllers\TindakLanjutController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get("/", function () {
    // return view('welcome');
    return view("auth.login");
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');
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

    Route::resource("irban", IrbanController::class);

    Route::resource("auditee", AuditeeController::class);

    Route::resource("pihak-ketiga", PihakKetigaController::class);

    Route::resource("lhp", LhpController::class);

    Route::prefix("lhp/{lhp}")->group(function () {
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

    Route::get("/laporan", [LaporanController::class, "index"])->name(
        "laporan.index"
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

    Route::get("/laporan/irban", [LaporanController::class, "irban"])->name(
        "laporan.irban"
    );

    Route::get("/laporan/irban/cetak", [
        LaporanController::class,
        "cetakIrban",
    ])->name("laporan.irban.cetak");

    Route::get("/laporan/irban/cetak", [
        LaporanController::class,
        "cetakIrban",
    ])->name("laporan.irban.cetak");
});

require __DIR__ . "/auth.php";
