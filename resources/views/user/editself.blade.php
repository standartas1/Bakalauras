@extends('layouts.main')

@section('content')
    <style>
        .uper {
            margin-top: 40px;
        }
    </style>
    <div class="card uper">
        <div class="card-header">
            Settings
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
            <form method="post" action="{{ route('users.updateself') }}">
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
                    <label for="email">Email:</label>
                    <input type="email" value="{{ $user->email }}" class="form-control" name="email" disabled/>
                </div>
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" value="{{ $user->username }}" class="form-control" name="username" disabled/>
                </div>
                <div class="form-group">
                    <label for="information">Role:</label>
                    @foreach ($roles as $role)
                        @if ($user->role_id == $role->id)
                        <input type="text" value="{{ $role->name }}" class="form-control" name="role" disabled/>
                        @endif
                    @endforeach

                </div>
                <div class="form-group">
                    <label for="name">Current Password: <span style="color:red">*</span></label>
                    <input type="password" class="form-control" name="password_old"/>
                </div>
                <div class="form-group">
                    <label for="name">New Password:</label>
                    <input type="password" class="form-control" name="password"/>
                </div>
                <div class="form-group">
                    <label for="name">New password confirmation:</label>
                    <input type="password" class="form-control" name="password_confirmation"/>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
@endsection