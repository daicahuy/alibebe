@extends('client.layouts.master')


@push('css')
    <style>
        body {
            background-color: #f8f9fa;
        }

        .card {
            padding: 30px;
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #343a40;
        }

        p {
            color: #6c757d;
        }

        .disabled {
            pointer-events: none;
            opacity: 0.6;
        }
    </style>
@endpush

@section('content')
    <div class="container">
        <div class="card text-center mt-5">
            <h1>Xác minh Email</h1>
            <p>Chúng tôi đã gửi một email xác minh đến địa chỉ của bạn. Vui lòng kiểm tra email và làm theo hướng dẫn để xác
                minh tài khoản của bạn.</p>
            <p>Nếu bạn không nhận được email, hãy nhấn vào nút bên dưới để gửi lại.</p>
            <div class="d-flex justify-content-center mt-4">
                @if (auth()->check())
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button type="submit">Gửi lại email xác minh</button>
                    </form>
                @else
                    <p>Vui lòng đăng nhập để gửi lại email xác minh.</p>
                @endif
                <a href="/login" class="btn btn-secondary">Login</a>
            </div>
            <p id="countdownText" class="mt-3 text-danger" style="display: none;"></p>
        </div>
    </div>
@endsection

@push('js')
@endpush
