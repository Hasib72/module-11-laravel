@extends("admin.layouts.master")
@section("title", "Products")
@section("content")
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Products</h1>
            <a href="{{ route("admin.products.create") }}"
               class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                    class="fas fa-plus fa-sm text-white-50"></i> Create Product</a>
        </div>

        @if (session()->has("success"))
            <div class="alert alert-success">
                {{ session("success") }}
            </div>
        @endif

        @if (session()->has("error"))
            <div class="alert alert-danger">
                {{ session("error") }}
            </div>
        @endif

        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable">
                        <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Stock Quantity</th>
                            <th>Unit Price</th>
                            <th>Status</th>
                            <th style="width: 100px">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($products as $product)
                            <tr>
                                <td>{{ $product->product_name }}</td>
                                <td>{{ $product->quantity }}</td>
                                <td>${{ $product->unit_price }}</td>
                                <td>
                                    @if ($product->status === 1)
                                        <span class="badge badge-success badge-counter">Active</span>
                                    @else
                                        <span class="badge badge-danger badge-counter">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route("admin.products.show", $product->id) }}" class="btn btn-sm"><i
                                            class="fa fa-eye"></i></a>
                                    <a href="{{ route("admin.products.edit", $product->id) }}" class="btn btn-sm"><i
                                            class="fa fa-edit"></i></a>
                                    <form action="{{ route("admin.products.destroy", $product->id) }}" method="post" class="d-inline">
                                        @csrf
                                        @method("DELETE")
                                        <button class="btn btn-sm" onclick="return confirm('Are you sure to delete?')"><i class="fa fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
