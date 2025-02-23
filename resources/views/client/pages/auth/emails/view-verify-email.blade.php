@extends('client.layouts.master')

@push('css')
    <style>
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .success {
            color: green;
        }

        .error {
            color: red;
        }
    </style>
@endpush


@section('content')
    <div class="container">
        @if ($status == 200)
            <h1 class="success">Xác minh thành công!</h1>
        @elseif ($status == 404)
            <h1 class="error">Đường link không còn khả dụng.</h1>
            <p>Vui lòng yêu cầu một email xác minh mới.</p>
        @else
            <h1 class="error">Có lỗi xảy ra.</h1>
            <p>Vui lòng thử lại sau.</p>
        @endif
    </div>
@endsection
