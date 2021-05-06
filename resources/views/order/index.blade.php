@extends('layouts.main')

@section('content')

            <div class="container-fluid">

                @if(session()->get('success'))
                    <div class="alert alert-success">
                        {{ session()->get('success') }}
                    </div><br />
                @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div><br />
                @endif

                <!-- Page Heading -->
                <h1 class="h3 mb-2 text-gray-800">Orders</h1>

                <!-- DataTales Example -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        @if (Auth::user()->role_id > 1)
                        <a href="{{ route('orders.create')}}" class="btn btn-primary">Add New</a>
                        @endif
                        <div class="order-filter-container" style="max-width: 550px; display: inline-block; float: right;">
                            <form method="post" action="{{ route('orders.filter') }}">
                                @csrf
                                <div style="max-width: 200px; display: inline-block">
                                    <label for="information" hidden>Type:</label>
                                    <select class="form-control type_select" name="type_id">
                                        <option value="" disabled selected hidden>Type</option>
                                        @foreach ($types as $type)
                                            <option value="{{ $type->id }}" {{ $typeSelected == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="subtype_block" style="max-width: 200px; display: inline-block">
                                    <label for="information" hidden>Subtype:</label>
                                    <select class="form-control subtype_select" name="subtype_id">
                                        <option value="" disabled selected hidden>Subtype</option>
                                        @foreach ($subtypes as $subtype)
                                            <option value="{{ $subtype->id }}" {{ $subtypeSelected == $subtype->id ? 'selected' : '' }}>{{ $subtype->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div style="max-width: 50px; display: inline-block; margin-right: 10px;">
                                    <button type="submit" class="btn btn-primary">Filter</button>
                                </div>
                                <div style="max-width: 50px; display: inline-block">
                                    <a href="{{ route('orders.index')}}" class="btn btn-secondary">Clear</a>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0" style="border: 0px">
                                <thead>
                                <tr>
                                    <th style="width: {{ Auth::user()->role_id > 1 ? '4%' : '15%'}}">ID</th>
                                    <th style="width: {{ Auth::user()->role_id > 1 ? '8%' : '25%'}}">Type</th>
                                    <th style="width: {{ Auth::user()->role_id > 1 ? '8%' : '25%'}}">Subtype</th>
                                    <th style="width: {{ Auth::user()->role_id > 1 ? '10%' : '35%'}}">Client</th>
                                    @if (Auth::user()->role_id > 1)
                                    <th style="width: 10%">Price</th>
                                    <th style="width: 10%">Profit</th>
                                    <th style="width: 10%">Prime cost</th>
                                    <th style="width: 15%">Information</th>
                                    <th style="width: 10%">Created at</th>
                                    <th style="width: 15%">Actions</th>
                                    @endif
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($orders as $order)
                                    <tr>
                                        <td>{{$order->id}}</td>
                                        <td>{{$order->type->name}}</td>
                                        <td>{{isset($order->subtype) ? $order->subtype->name : ''}}</td>
                                        <td>{{$order->client->name}}</td>
                                        @if (Auth::user()->role_id > 1)
                                        <td>{{$order->price}}</td>
                                        <td>{{$order->profit}}</td>
                                        <td>{{$order->price_self}}</td>
                                        <td>{{ Str::limit($order->information, 100) }}</td>
                                        <td>{{$order->created_at}}</td>
                                        <td> <div style="display: inline-flex">
                                                <a href="{{ route('orders.edit', $order->id)}}" class="btn btn-primary">Edit</a>
                                                <form action="{{ route('orders.destroy', $order->id)}}" method="post" style="margin-left: 5px">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger" type="button">Delete</button>
                                                </form>
                                                @if (isset($order->file->name))
                                                    <a href="{{ route('orders.download', [ 'id' => $order->file_id ]) }}" style="margin-left: 5px" class="btn btn-secondary">Download</a>
                                                @endif
                                            </div>
                                        </td>
                                        @endif
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
@endsection

@section('js-footer')
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('js/demo/datatables-demo.js') }}"></script>
    <script>
        $( document ).ready(function() {
            if ($('.type_select').val() != 1) {
                $('.subtype_block').hide();
            }
            $('.type_select').on('change', function () {
                if ($(this).val() == 1) {
                    $('.subtype_block').show();
                } else {
                    $('.subtype_block').hide();
                }

            })
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script>
        $('.btn-danger').on('click', function (e) {
            e.preventDefault();
            var form = $(this).parent('form');
            Swal.fire({
                title: 'Warning!',
                text: 'Do you really want to delete order?',
                icon: 'warning',
                confirmButtonText: 'Yes',
                showCancelButton: true,
            }).then((result) => {
                if (result.value) {
                    form.submit();
                }
            });
        });
    </script>
@endsection

@section('css-header')
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection