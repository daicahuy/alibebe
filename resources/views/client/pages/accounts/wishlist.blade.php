@extends('client.pages.accounts.layouts.master')

@section('content_account')
    <div class="dashboard-wishlist">
        <div class="title">
            <h2>{{ __('form.wishlists') }}</h2>
            <span class="title-leaf title-leaf-gray">
                <svg class="icon-width bg-gray">
                    <use xlink:href="https://themes.pixelstrap.com/fastkart/assets/svg/leaf.svg#leaf">
                    </use>
                </svg>
            </span>
        </div>
        <div class="row g-sm-4 g-3">
            @foreach ($wishlist as $item)
                <div class="col-xxl-3 col-lg-3 col-md-3 col-sm-6">
                    <div>
                        <div class="product-box-3 h-100 wow fadeInUp" data-wow-delay="0.65s">
                            <div class="product-header">
                                <div class="product-image">
                                    <a href="{{ route('products', $item->product->id) }}">
                                        <img src="{{ Storage::url($item->product->thumbnail) }}"
                                            class="img-fluid blur-up lazyload" alt="">
                                    </a>

                                    <div class="product-header-top">
                                      <form action="{{route('account.remove-wishlist',$item->id)}}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn wishlist-button close_button">
                                            <i data-feather="x"></i>
                                        </button>
                                      </form>
                                    </div>
                                </div>
                            </div>

                            <div class="product-footer">
                                <div class="product-detail">
                                    <span class="span-name">{{ $item->product->brand->name }}</span>
                                    <a href="{{ route('products', $item->product->id) }}">
                                        <h5 class="name">{{ $item->product->name }}</h5>
                                    </a>
                                    <h5 class="price">
                                        <span class="theme-color">{{ number_format($item->product->price, 0, ',', '.') }}
                                            VND</span>
                                    </h5>
                                    <div class="add-to-cart-box bg-white">
                                        <button class="btn btn-add-cart addcart-button">
                                            {{ __('message.add') }}
                                            <span class="add-icon bg-light-gray">
                                                <i class="fa-solid fa-plus"></i>
                                            </span>
                                        </button>
                                        <div class="cart_qty qty-box">
                                            <div class="input-group bg-white">
                                                <button type="button" class="qty-left-minus bg-gray" data-type="minus"
                                                    data-field="">
                                                    <i class="fa fa-minus"></i>
                                                </button>
                                                <input class="form-control input-number qty-input" type="text"
                                                    name="quantity" value="0">
                                                <button type="button" class="qty-right-plus bg-gray" data-type="plus"
                                                    data-field="">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            <nav class="custom-pagination">
                {{ $wishlist->links() }}
            </nav>
        </div>

    </div>
@endsection
