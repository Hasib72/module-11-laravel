<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class SaleController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        $sales = DB::table("sales")
            ->leftJoin("sale_products", "sales.id", "=", "sale_products.sale_id")
            ->select(
                "sales.id",
                "sales.customer_name",
                "sales.address",
                "sales.created_at",
                DB::raw("SUM(sale_products.quantity * sale_products.unit_price) AS total_price")
            )
            ->groupBy("sales.id")
            ->get();

        return view("admin.sales.index", compact("sales"));
    }

    /**
     * @return View
     */
    public function create(): View
    {
        $products = DB::table("products")
            ->where("status", 1)
            ->get();

        return view("admin.sales.create", compact("products"));
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        // Form Validation
        $request->validate([
            "customer_name" => "required",
            "cart.*.product_id" => "nullable|exists:products,id",
            "cart.*.quantity" => "nullable|integer|min:1",
            "cart.*.unit_price" => "nullable|numeric|min:0",
        ]);

        DB::beginTransaction();

        try {
            DB::table("sales")
                ->insert([
                    "customer_name" => $request->input("customer_name"),
                    "address" => $request->input("address"),
                    "created_at" => now(),
                    "updated_at" => now(),
                ]);

            $sale_id = DB::getPdo()->lastInsertId();

            foreach ($request->input("cart") as $cart) {
                // Will be skipped if product not select
                if (empty($cart["product_id"])) {
                    continue;
                }

                // Retrieve product details
                $product = DB::table("products")->find($cart["product_id"]);

                // Validate unit price
                if ($cart["unit_price"] == "") {
                    throw new Exception("Unit price cannot be empty for '$product->product_name'");
                }

                // Validate quantity
                if ($cart["quantity"] > $product->quantity) {
                    throw new Exception("Stock for product '$product->product_name' not available");
                }

                // Insert Sale Products
                DB::table("sale_products")->insert([
                    "sale_id" => $sale_id,
                    "product_id" => $cart["product_id"],
                    "quantity" => $cart["quantity"],
                    "unit_price" => $cart["unit_price"],
                ]);

                // Decrement Quantity From Products Table
                DB::table("products")
                    ->where("id", $cart["product_id"])
                    ->decrement("quantity", $cart["quantity"]);
            }

            DB::commit();
        } catch (QueryException) {
            DB::rollBack();
            return redirect()
                ->back()
                ->with("error", "Error occurred while inserting the sale product.")
                ->withInput();
        } catch (Exception $exception) {
            DB::rollBack();
            return redirect()
                ->back()
                ->with("error", $exception->getMessage())
                ->withInput();
        }

        return redirect()->back()->with("success", "Product has been sale successfully.");
    }

    /**
     * @param int $id
     * @return View
     */
    public function show(int $id): View
    {
        $sale = DB::table("sales")
            ->leftJoin("sale_products", "sales.id", "=", "sale_products.sale_id")
            ->select(
                "sales.id",
                "sales.customer_name",
                "sales.address",
                "sales.created_at",
                DB::raw("SUM(sale_products.quantity * sale_products.unit_price) AS total_price")
            )
            ->groupBy("sales.id")
            ->where("sales.id", $id)
            ->first();

        $sale_products = DB::table("sale_products")
            ->join("products", "sale_products.product_id", "=", "products.id")
            ->select(
                "sale_products.*",
                "products.product_name",
                DB::raw("sale_products.quantity * sale_products.unit_price AS subtotal")
            )
            ->where("sale_id", $id)
            ->get();

        if ($sale === null) {
            abort(404);
        }

        return view("admin.sales.show", compact("sale", "sale_products"));
    }
}
