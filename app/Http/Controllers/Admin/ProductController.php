<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        $products = DB::table("products")->get();

        return view("admin.products.index", compact("products"));
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return view("admin.products.create");
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        // Form Validation
        $request->validate([
            "product_name" => "required|unique:products",
            "quantity" => "required|integer",
            "unit_price" => "required|numeric",
            "status" => "required|digits_between:0,1",
        ]);

        try {
            // Insert New Product
            DB::table("products")->insert([
                "product_name" => $request->input("product_name"),
                "quantity" => $request->input("quantity"),
                "unit_price" => $request->input("unit_price"),
                "status" => $request->input("status"),
                "created_at" => now(),
                "updated_at" => now(),
            ]);
        } catch (QueryException) {
            return redirect()->back()->with("error", "Error occurred while inserting the product.");
        }

        return redirect()->back()->with("success", "Product has been inserted successfully.");
    }

    /**
     * @param int $id
     * @return View
     */
    public function show(int $id): View
    {
        $product = DB::table("products")->find($id);

        if ($product === null) {
            abort(404);
        }

        return view("admin.products.show", compact("product"));
    }

    /**
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $product = DB::table("products")->find($id);

        if ($product === null) {
            abort(404);
        }

        return view("admin.products.edit", compact("product"));
    }

    /**
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        // Form Validation
        $request->validate([
            "product_name" => "required|unique:products,product_name,$id",
            "quantity" => "required|integer",
            "unit_price" => "required|numeric",
            "status" => "required|digits_between:0,1",
        ]);

        try {
            // Update Exist Product
            DB::table("products")
                ->where("id", $id)
                ->update([
                "product_name" => $request->input("product_name"),
                "quantity" => $request->input("quantity"),
                "unit_price" => $request->input("unit_price"),
                "status" => $request->input("status"),
                "updated_at" => now(),
            ]);
        } catch (QueryException) {
            return redirect()->back()->with("error", "Error occurred while updating the product.");
        }

        return redirect()->back()->with("success", "Product has been updated successfully.");
    }

    /**
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        try {
            DB::table("products")->delete($id);
        } catch (QueryException) {
            return redirect()->back()->with("error", "Error occurred while deleting the product.");
        }

        return redirect()->back()->with("success", "Product has been deleted successfully.");
    }
}
