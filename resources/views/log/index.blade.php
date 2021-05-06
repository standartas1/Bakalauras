@extends('layouts.main')

@section('content')

            <div class="container-fluid">

                @if(session()->get('success'))
                    <div class="alert alert-success">
                        {{ session()->get('success') }}
                    </div><br />
                @endif

                <!-- Page Heading -->
                <h1 class="h3 mb-2 text-gray-800">Logs</h1>

                <!-- DataTales Example -->
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0" style="border: 0px">
                                <thead>
                                <tr>
                                    <th style="width: 10%">ID</th>
                                    <th style="width: 20%">Type</th>
                                    <th style="width: 20%">Action</th>
                                    <th style="width: 30%">Datetime</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($logs as $log)
                                    <tr>
                                        <td>{{$log->id}}</td>
                                        <td>{{$log->type}}</td>
                                        <td>{{$log->action}}</td>
                                        <td>{{$log->created_at}}</td>
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
@endsection

@section('css-header')
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection