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
                <h1 class="h3 mb-2 text-gray-800">Clients</h1>

                <!-- DataTales Example -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        @if (Auth::user()->role_id > 1)
                        <a href="{{ route('clients.create')}}" class="btn btn-primary">Add New</a>
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0" style="border: 0px">
                                <thead>
                                <tr>
                                    <th style="width: {{ Auth::user()->role_id > 1 ? '10%' : '20%'}}">ID</th>
                                    <th style="width: {{ Auth::user()->role_id > 1 ? '70%' : '80%'}}">Name</th>
                                    @if (Auth::user()->role_id > 1)
                                    <th style="width: 20%">Actions</th>
                                    @endif
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($clients as $client)
                                    <tr>
                                        <td>{{$client->id}}</td>
                                        <td>{{$client->name}}</td>
                                        @if (Auth::user()->role_id > 1)
                                        <td> <div style="display: inline-flex">
                                                <a href="{{ route('orders.client', $client->id)}}" class="btn btn-secondary">Orders</a>
                                                <a href="{{ route('clients.edit', $client->id)}}" class="btn btn-primary" style="margin-left: 5px">Edit</a>
                                                <form action="{{ route('clients.destroy', $client->id)}}" method="post" class="delete_form" style="margin-left: 5px">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger" type="button">Delete</button>
                                                </form>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script>
        $('.btn-danger').on('click', function (e) {
            e.preventDefault();
            var form = $(this).parent('form');
            Swal.fire({
                title: 'Warning!',
                text: 'Do you really want to delete client?',
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
    <!-- Page level custom scripts -->
    <script src="{{ asset('js/demo/datatables-demo.js') }}"></script>
@endsection

@section('css-header')
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection