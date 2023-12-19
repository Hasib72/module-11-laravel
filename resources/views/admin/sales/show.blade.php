@extends("admin.layouts.master")
@section("title", "Transaction Detail")
@section("content")
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Transaction Detail</h1>
            <a href=""
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
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Unit Price</th>
                                    <th class="text-right">Subtotal</th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($sale_products as $i => $product)
                                    <tr>
                                        <td>{{ $product->product_name }}</td>
                                        <td>{{ $product->quantity }}</td>
                                        <td>${{ $product->unit_price }}</td>
                                        <td class="text-right">${{ $product->subtotal }}</td>
                                    </tr>
                                @endforeach
                                </tbody>

                                <tfoot>
                                    <tr>
                                        <td colspan="4" class="text-right">
                                            <b>Total Price: ${{ $sale->total_price }}</b>
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
                                <input type="text" name="customer_name" value="{{ $sale->customer_name }}" id="customer_name" class="form-control" disabled>
                            </div>

                            <div class="form-group">
                                <label for="address" class="col-form-label">Address</label>
                                <textarea name="address" id="address" class="form-control" disabled>{{ $sale->address }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
