@extends("admin.layouts.master")
@section("title", "Transactions")
@section("content")
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Transactions</h1>
            <a href="{{ route("admin.sales.index") }}"
               class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                    class="fas fa-sync fa-sm text-white-50"></i> Refresh</a>
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
                            <th>#</th>
                            <th>Customer Name</th>
                            <th>Address</th>
                            <th>Time</th>
                            <th>Total Price</th>
                            <th style="width: 100px">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($sales as $i => $sale)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $sale->customer_name }}</td>
                                <td>{{ $sale->address }}</td>
                                <td>{{ date("d-m-Y, h:i A", strtotime($sale->created_at)) }}</td>
                                <td>${{ $sale->total_price }}</td>
                                <td>
                                    <a href="{{ route("admin.sales.show", $sale->id) }}" class="btn btn-sm"><i
                                            class="fa fa-eye"></i></a>
                                    <a href="#" class="btn btn-sm disabled"><i class="fa fa-edit"></i></a>
                                    <a href="#" class="btn btn-sm disabled"><i class="fa fa-trash"></i></a>
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
