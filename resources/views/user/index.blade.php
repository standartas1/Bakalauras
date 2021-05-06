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
                <h1 class="h3 mb-2 text-gray-800">Users</h1>

                <!-- DataTales Example -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <a href="{{ route('users.create')}}" class="btn btn-primary">Add New</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0" style="border: 0px">
                                <thead>
                                <tr>
                                    <th style="width: 5%">ID</th>
                                    <th style="width: 10%">Name</th>
                                    <th style="width: 15%">Surname</th>
                                    <th style="width: 30%">Email</th>
                                    <th style="width: 20%">Username</th>
                                    <th style="width: 20%">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <td>{{$user->id}}</td>
                                        <td>{{$user->name}}</td>
                                        <td>{{$user->surname}}</td>
                                        <td>{{$user->email}}</td>
                                        <td>{{$user->username}}</td>
                                        <td> <div style="display: inline-flex">
                                                <a href="{{ route('users.edit', $user->id)}}" class="btn btn-primary">Edit</a>
                                                <form action="{{ route('users.destroy', $user->id)}}" method="post" style="margin-left: 5px">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger" type="button">Delete</button>
                                                </form>
                                            </div>

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

@section('js-footer')
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('js/demo/datatables-demo.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script>
        $('.btn-danger').on('click', function (e) {
            e.preventDefault();
            var form = $(this).parent('form');
            Swal.fire({
                title: 'Warning!',
                text: 'Do you really want to delete user?',
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