<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SaleController;
use App\Http\Middleware\Authenticate;
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

Route::get("/", function () {
    return redirect("admin/login");
});

// AuthController
Route::get("admin/login", [AuthController::class, "index"])->name("admin.auth.index");
Route::post("admin/login", [AuthController::class, "login"])->name("admin.auth.login");

Route::middleware([Authenticate::class])->group(function () {
    // AuthController
    Route::get("admin/logout", [AuthController::class, "logout"])->name("admin.auth.logout");

    // DashboardController
    Route::get("admin/dashboard", [DashboardController::class, "index"])->name("admin.dashboard.index");

    // ProductController
    Route::get("admin/products", [ProductController::class, "index"])->name("admin.products.index");
    Route::get("admin/products/create", [ProductController::class, "create"])->name("admin.products.create");
    Route::post("admin/products", [ProductController::class, "store"])->name("admin.products.store");
    Route::get("admin/products/{id}", [ProductController::class, "show"])->name("admin.products.show");
    Route::get("admin/products/{id}/edit", [ProductController::class, "edit"])->name("admin.products.edit");
    Route::put("admin/products/{id}", [ProductController::class, "update"])->name("admin.products.update");
    Route::delete("admin/products/{id}", [ProductController::class, "destroy"])->name("admin.products.destroy");

    // SaleController
    Route::get("admin/sales", [SaleController::class, "index"])->name("admin.sales.index");
    Route::get("admin/sales/create", [SaleController::class, "create"])->name("admin.sales.create");
    Route::post("admin/sales", [SaleController::class, "store"])->name("admin.sales.store");
    Route::get("admin/sales/{id}", [SaleController::class, "show"])->name("admin.sales.show");
});

