@extends('client.layouts.master')


@push('css_library')
@endpush



@push('css')
@endpush


@section('content')
    <section class="py-24 relative">
        <div class="w-full max-w-7xl px-4 md:px-5 lg-6 mx-auto">
            <h2 class="font-manrope font-bold text-4xl leading-10 text-black text-center">
                Cảm ơn bạn đã mua hàng
            </h2>
            <p class="mt-4 font-normal text-lg leading-8 text-gray-500 mb-11 text-center">Đặt hàng thành công</p>
        </div>
    </section>
@endsection
