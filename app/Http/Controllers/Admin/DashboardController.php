<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {

        $today = DB::table("sales")
            ->leftJoin("sale_products", "sales.id", "=", "sale_products.sale_id")
            ->whereDate("sales.created_at", today()->toDateString())
            ->sum(DB::raw("sale_products.quantity * sale_products.unit_price"));


        $yesterday = DB::table("sales")
            ->leftJoin("sale_products", "sales.id", "=", "sale_products.sale_id")
            ->whereDate("sales.created_at", now()->subDay()->toDateString())
            ->sum(DB::raw("sale_products.quantity * sale_products.unit_price"));

        $thisMonth = DB::table("sales")
            ->leftJoin("sale_products", "sales.id", "=", "sale_products.sale_id")
            ->whereYear("sales.created_at", now()->year)
            ->whereMonth("sales.created_at", now()->month)
            ->sum(DB::raw("sale_products.quantity * sale_products.unit_price"));

        $lastMonth = DB::table("sales")
            ->leftJoin("sale_products", "sales.id", "=", "sale_products.sale_id")
            ->whereYear("sales.created_at", now()->subMonth()->year)
            ->whereMonth("sales.created_at", now()->subMonth()->month)
            ->sum(DB::raw("sale_products.quantity * sale_products.unit_price"));

        return view("admin.index", compact("today", "yesterday", "thisMonth", "lastMonth"));
    }
}
