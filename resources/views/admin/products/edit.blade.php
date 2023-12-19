@extends("admin.layouts.master")
@section("title", "Edit Product")
@section("content")
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Edit Product</h1>
            <a href="{{ route("admin.products.index") }}"
               class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                    class="fas fa-eye fa-sm text-white-50"></i> Products</a>
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

    <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-body">
                <form action="{{ route("admin.products.update", $product->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method("PUT")
                    <div class="form-group row">
                        <label for="product_name" class="col-sm-3 col-form-label text-right font-weight-bold">Product Name *</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="product_name" value="{{ $product->product_name }}" name="product_name"
                                   autofocus>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="quantity" class="col-sm-3 col-form-label text-right font-weight-bold">Quantity
                            *</label>
                        <div class="col-sm-6">
                            <input type="number" class="form-control" id="quantity" value="{{ $product->quantity }}"
                                   name="quantity">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="unit_price"
                               class="col-sm-3 col-form-label text-right font-weight-bold">Unit Price ($) *</label>
                        <div class="col-sm-6">
                            <input type="number" step="0.5" class="form-control" id="unit_price" value="{{ $product->unit_price }}"
                                   name="unit_price">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="status" class="col-sm-3 col-form-label text-right font-weight-bold">Status</label>
                        <div class="col-sm-6">
                            <select name="status" id="status" class="form-control">
                                <option value="1" {{ $product->status === 1 ? "selected" : "" }}>Active</option>
                                <option value="0" {{ $product->status === 0 ? "selected" : "" }}>Inactive</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="offset-3 col-sm-6">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection
