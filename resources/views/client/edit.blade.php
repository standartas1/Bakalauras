@extends('layouts.main')

@section('content')
    <style>
        .uper {
            margin-top: 40px;
        }
    </style>
    <div class="card uper">
        <div class="card-header">
            Edit Client
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div><br />
            @endif
            <form method="post" action="{{ route('clients.update', $client->id ) }}">
                @csrf
                @method('PATCH')
                <div class="form-group">
                    <label for="country_name">Client name: <span style="color:red">*</span></label>
                    <input type="text" class="form-control" name="name" value="{{ $client->name }}"/>
                </div>
                <button type="submit" class="btn btn-primary">Update client</button>
            </form>
        </div>
    </div>
@endsection