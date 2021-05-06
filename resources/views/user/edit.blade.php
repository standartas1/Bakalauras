@extends('layouts.main')

@section('content')
    <style>
        .uper {
            margin-top: 40px;
        }
    </style>
    <div class="card uper">
        <div class="card-header">
            Edit User
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
            <form method="post" action="{{ route('users.update', $user->id ) }}">
                @csrf
                @method('PATCH')
                <div class="form-group">
                    <label for="name">Name: <span style="color:red">*</span></label>
                    <input type="text" value="{{ $user->name }}" class="form-control" name="name"/>
                </div>
                <div class="form-group">
                    <label for="surname">Surname: <span style="color:red">*</span></label>
                    <input type="text" value="{{ $user->surname }}" class="form-control" name="surname"/>
                </div>
                <div class="form-group">
                    <label for="email">Email: <span style="color:red">*</span></label>
                    <input type="email" value="{{ $user->email }}" class="form-control" name="email" disabled/>
                </div>
                <div class="form-group">
                    <label for="username">Username: <span style="color:red">*</span></label>
                    <input type="text" value="{{ $user->username }}" class="form-control" name="username" disabled/>
                </div>
                <div class="form-group">
                    <label for="information">Role: <span style="color:red">*</span></label>
                    <select class="form-control type_select" name="role_id">
                        <option value="" disabled selected hidden>Select</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="name">New Password:</label>
                    <input type="password" class="form-control" name="password"/>
                </div>
                <div class="form-group">
                    <label for="name">Password confirmation:</label>
                    <input type="password" class="form-control" name="password_confirmation"/>
                </div>
                <button type="submit" class="btn btn-primary">Edit User</button>
            </form>
        </div>
    </div>
@endsection