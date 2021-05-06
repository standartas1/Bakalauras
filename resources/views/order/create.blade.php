@extends('layouts.main')

@section('content')
    <style>
        .uper {
            margin-top: 40px;
        }
    </style>
    <div class="card uper">
        <div class="card-header">
            Add a new order
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
            <form method="post" action="{{ route('orders.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="information">Order information:</label>
                    <textarea class="form-control" name="information">{{ old('information') }}</textarea>
                </div>
                <div class="form-group">
                    <label for="client_id">Client: <span style="color:red">*</span></label>
                    <select class="form-control client_select" name="client_id">
                        <option value="" disabled selected hidden>Select</option>
                        @foreach ($clients as $client)
                            <option value="{{ $client->id }}">{{ $client->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="information">Type: <span style="color:red">*</span></label>
                    <select class="form-control type_select" name="type_id">
                        <option value="" disabled selected hidden>Select</option>
                        @foreach ($types as $type)
                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group subtype_group" style="display: none;">
                    <label for="information">Subtype: <span style="color:red">*</span></label>
                    <select class="form-control subtype_select" name="subtype_id">
                        <option value="" disabled selected hidden>Select</option>
                        @foreach ($subtypes as $subtype)
                            <option value="{{ $subtype->id }}">{{ $subtype->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="price_self">Prime cost: <span style="color:red">*</span></label>
                    <input type="text" class="form-control price_self" name="price_self" value="{{ old('price_self') }}"/>
                </div>
                <div class="form-group">
                    <label for="price">Price: <span style="color:red">*</span></label>
                    <input type="text" class="form-control price" name="price" value="{{ old('price') }}"/>
                </div>
                <div class="form-group">
                    <label for="profit">Profit:</label>
                    <input type="text" class="form-control profit" name="profit" value="{{ old('profit') }}" disabled />
                </div>
                <div class="form-group">
                    <label for="file">Upload file:</label>
                    <input type="file" class="custom-file" name="file" value="{{ old('file') }}"/>
                </div>
                <button type="submit" class="btn btn-primary">Add Order</button>
            </form>
        </div>
    </div>
@endsection

@section('js-footer')
    <script src="{{ asset('vendor/select2/js/select2.full.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.type_select').on('change', function() {
                var selected = $(this).children("option:selected").val();
                if (selected !== undefined && selected == 1) {
                    $('.subtype_group').show();
                } else {
                    $('.subtype_group').hide();
                }
            });

            $('.price_self').on('change', function() {
                recalculateProfit();
            });
            $('.price').on('change', function() {
                recalculateProfit();
            });

            function recalculateProfit() {
                var price_self = $('.price_self').val();
                var price = $('.price').val();
                $('.profit').val(price - price_self);
            }
        });
    </script>
@endsection

@section('css-header')
    <link href="{{ asset('vendor/select2/css/select2.min.css') }}" rel="stylesheet">
@endsection