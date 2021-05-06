@extends('layouts.main')

@section('content')
    <style>
        .uper {
            margin-top: 40px;
        }
    </style>
    <div class="card uper">
        <div class="card-header">
            Edit Order
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
            <form method="post" action="{{ route('orders.update', [ 'order'=>$order->id ]) }}" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="form-group">
                    <label for="information">Order information:</label>
                    <textarea class="form-control" name="information">{{ $order->information }}</textarea>
                </div>
                <div class="form-group">
                    <label for="client_id">Client: <span style="color:red">*</span></label>
                    <select class="form-control client_select" name="client_id">
                        <option value="" disabled selected hidden>Select</option>
                        @foreach ($clients as $client)
                            <option value="{{ $client->id }}" {{ $client->id == $order->client_id ? 'selected' : '' }}>{{ $client->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="information">Type: <span style="color:red">*</span></label>
                    <select class="form-control type_select" name="type_id">
                        <option value="" disabled selected hidden>Select</option>
                        @foreach ($types as $type)
                            <option value="{{ $type->id }}" {{ $type->id == $order->type_id ? 'selected' : '' }}>{{ $type->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group subtype_group" style="display: none;">
                    <label for="information">Subtype: <span style="color:red">*</span></label>
                    <select class="form-control subtype_select" name="subtype_id">
                        <option value="" disabled selected hidden>Select</option>
                        @foreach ($subtypes as $subtype)
                            <option value="{{ $subtype->id }}" {{ $subtype->id == $order->subtype_id ? 'selected' : '' }}>{{ $subtype->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="price_self">Prime cost: <span style="color:red">*</span></label>
                    <input type="text" class="form-control price_self" name="price_self" value="{{ $order->price_self }}"/>
                </div>
                <div class="form-group">
                    <label for="price">Price: <span style="color:red">*</span></label>
                    <input type="text" class="form-control price" name="price" value="{{ $order->price }}"/>
                </div>
                <div class="form-group">
                    <label for="profit">Profit:</label>
                    <input type="text" class="form-control profit" name="profit" value="{{ $order->profit }}" disabled />
                </div>
                <div class="form-group">
                    <label for="file">Upload file:</label>
                    <input type="file" class="custom-file" name="file" value="{{ old('file') }}"/>
                    @if (isset($order->file->name))
                        <a href="{{ route('orders.download', [ 'id' => $order->file_id ]) }}">Download Uploaded</a>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary">Edit Order</button>
            </form>
        </div>
    </div>
@endsection