@extends("admin.layouts.master")
@section("title", "Product Sales")
@section("content")
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Product Sales</h1>
            <a href="{{ route("admin.sales.create") }}"
               class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                    class="fas fa-sync fa-sm text-white-50"></i> Refresh</a>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <ul class="m-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session()->has("success"))
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                {{ session("success") }}
            </div>
        @endif

        @if (session()->has("error"))
            <div class="alert alert-danger">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                {{ session("error") }}
            </div>
        @endif

        <form action="{{ route("admin.sales.store") }}" method="post">
            @csrf
            <div class="row">
                <div class="col-md-8">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Add to Cart</h6>
                        </div>
                        <div class="card-body">
                            <table class="table table-sm">
                                <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Unit Price</th>
                                    <th>Subtotal</th>
                                </tr>
                                </thead>

                                <tbody id="tbody">
                                @foreach($products as $i => $product)
                                    <tr>
                                        <td>
                                            <label>
                                                <input type="checkbox" name="cart[{{ $i }}][product_id]" value="{{ $product->id }}" class="product_id" {{ old("cart.$i.product_id")? "checked" : "" }}> {{ $product->product_name }}
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input type="number" name="cart[{{ $i }}][quantity]" value="{{ old("cart.$i.quantity", 1) }}" class="form-control form-control-sm quantity">
                                                <small>Stock: {{ $product->quantity }}</small>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input type="number" step="0.5" name="cart[{{ $i }}][unit_price]" value="{{ old("cart.$i.unit_price") }}" min="0" class="form-control form-control-sm unit_price">
                                                <small>Price: ${{ $product->unit_price }}</small>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input type="number" class="form-control form-control-sm subtotal" value="" disabled>
                                            </label>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>

                                <tfoot>
                                    <tr>
                                        <td colspan="4" class="text-right">
                                           <b>Total:</b> $<label>
                                                <input type="number" class="form-control form-control-sm total" disabled>
                                            </label>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="customer_name" class="col-form-label">Customer Name *</label>
                                <input type="text" name="customer_name" value="{{ old("customer_name") }}" id="customer_name" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="address" class="col-form-label">Address</label>
                                <textarea name="address" id="address" class="form-control">{{ old("address") }}</textarea>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Product Sales</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push("scripts")
    <script>
        jQuery(document).ready(function() {


            const totalPrice = () => {
                const total_element = jQuery(".total");
                let total = 0;

                jQuery("#tbody tr").each(function() {
                    const product_id_element = jQuery(this).find(".product_id");

                    if (product_id_element.prop("checked") === true) {
                        const subtotal = parseFloat(jQuery(this).find(".subtotal").val());
                        if (!isNaN(subtotal)) {
                            total += subtotal;
                        }
                    }
                })

                total_element.val(total);
            }

            jQuery("#tbody tr").each(function() {
                const product_id_element = jQuery(this).find(".product_id");
                const quantity_element = jQuery(this).find(".quantity");
                const unit_price_element = jQuery(this).find(".unit_price");
                const subtotal_element = jQuery(this).find(".subtotal");

                quantity_element.on("input", function() {
                    const subtotal = quantity_element.val() * unit_price_element.val();
                    subtotal_element.val(subtotal);
                    totalPrice();
                });

                unit_price_element.on("input", function() {
                    const subtotal = quantity_element.val() * unit_price_element.val();
                    subtotal_element.val(subtotal);
                    totalPrice();
                });

                product_id_element.on("input", function() {
                    totalPrice();
                });

                const subtotal = quantity_element.val() * unit_price_element.val();
                subtotal_element.val(subtotal);
                totalPrice();
            });
        });
    </script>
@endpush
