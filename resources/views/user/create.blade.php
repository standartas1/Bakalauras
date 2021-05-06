@extends('layouts.main')

@section('content')
    <style>
        .uper {
            margin-top: 40px;
        }
    </style>
    <div class="card uper">
        <div class="card-header">
            Add a new user
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
            <form method="post" action="{{ route('users.store') }}">
                @csrf
                <div class="form-group">
                    <label for="name">Name: <span style="color:red">*</span></label>
                    <input type="text" value="{{ old('name') }}" class="form-control" name="name"/>
                </div>
                <div class="form-group">
                    <label for="surname">Surname: <span style="color:red">*</span></label>
                    <input type="text" value="{{ old('surname') }}" class="form-control" name="surname"/>
                </div>
                <div class="form-group">
                    <label for="email">Email: <span style="color:red">*</span></label>
                    <input type="email" value="{{ old('email') }}" class="form-control" name="email"/>
                </div>
                <div class="form-group">
                    <label for="username">Username: <span style="color:red">*</span></label>
                    <input type="text" value="{{ old('username') }}" class="form-control" name="username"/>
                </div>
                <div class="form-group">
                    <label for="information">Role: <span style="color:red">*</span></label>
                    <select class="form-control type_select" name="role_id">
                        <option value="" disabled selected hidden>Select</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="name">Password: <span style="color:red">*</span></label>
                    <input type="password" class="form-control" name="password"/>
                </div>
                <div class="form-group">
                    <label for="name">Password confirmation: <span style="color:red">*</span></label>
                    <input type="password" class="form-control" name="password_confirmation"/>
                </div>
                <button type="submit" class="btn btn-primary">Add User</button>
            </form>
        </div>
    </div>
@endsection