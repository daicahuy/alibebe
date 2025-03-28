@extends('client.layouts.master')

@section('content')
    <section class="fresh-vegetable-section section-lg-space">
        <div class="container-fluid-lg">
            <div class="row gx-xl-5 gy-xl-0 g-3 ratio_148_1">
                <div class="col-xl-6 col-12">
                    <div class="row g-sm-4 g-2">
                        <div class="col-6">
                            <div class="fresh-image-2">
                                <div>
                                    <img src="https://cdn-media.sforum.vn/storage/app/media/haianh/video-thuc-te-kinh-galaxy-xr-thumb.jpg"
                                        class="bg-img blur-up lazyload" alt="">
                                </div>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="fresh-image">
                                <div>
                                    <img src="https://cdn-media.sforum.vn/storage/app/media/trannghia/Insta360-Flow-2-Pro-ra-mat-1.jpg"
                                        class="bg-img blur-up lazyload" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="review-title">
                            <h2>Hướng Dẫn Hoàn Hàng</h2>
                        </div>
                        <div class="delivery-list">
                            <p class="text-content">Khi Hoàn Hàng , bạn làm theo các bước sau : </p>

                            <ul class="delivery-box">
                                <li>
                                    <div class="delivery-box">
                                        <div class="delivery-detail">
                                            <h5 class="text">- Vào phần đơn hàng và chọn đơn hàng cần hoàn trả và click
                                                nut Hoàn Trả.</h5>
                                        </div>
                                        <div class="delivery-icon">
                                            <img src="{{ asset('theme/client/assets/images/huongDan8.png') }}"
                                                class="blur-up lazyload" alt="" style="width: 600px; height: 300px">
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="delivery-box">
                                        <div class="delivery-detail">
                                            <h5 class="text">- Sau đó bạn cần điền đầy đủ thông tin của bạn .</h5>
                                        </div>
                                        <div class="delivery-icon">
                                            <img src="{{ asset('theme/client/assets/images/huongDan5.png') }}"
                                                class="blur-up lazyload" alt="" style="width: 600px; height: 300px">
                                        </div>
                                        <div class="delivery-icon">
                                            <img src="{{ asset('theme/client/assets/images/huongDan6.png') }}"
                                                class="blur-up lazyload" alt="" style="width: 600px; height: 300px">
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="delivery-box">
                                        <div class="delivery-detail">
                                            <h5 class="text">- Như vậy bạn đã gửi yêu cầu hoàn hàng thành công .</h5>
                                        </div>
                                        <div class="delivery-icon">
                                            <img src="{{ asset('theme/client/assets/images/huongDan7.png') }}"
                                                class="blur-up lazyload" alt="" style="width: 600px; height: 300px">
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-12">
                    <div class="fresh-contain p-center-left">
                        <div>
                            <div class="review-title">
                                <h4>Trợ Giúp</h4>
                                <h2>Hướng Dẫn Mua Hàng</h2>
                            </div>
                            <div class="delivery-list">
                                <p class="text-content">Khi mua Hàng , bạn làm theo các bước sau : </p>

                                <ul class="delivery-box">
                                    <li>
                                        <div class="delivery-box">
                                            <div class="delivery-detail">
                                                <h5 class="text">- Chọn thêm vào giỏ hàng ( Đối với sản phẩm có biến thể ,
                                                    chọn biến thể mong muốn).</h5>
                                            </div>
                                            <div class="delivery-icon">
                                                <img src="{{ asset('theme/client/assets/images/huongDan1.png') }}"
                                                    class="blur-up lazyload" alt=""
                                                    style="width: 600px; height: 300px">
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="delivery-box">
                                            <div class="delivery-detail">
                                                <h5 class="text">- Sau khi thêm vào giỏ hàng, chọn thanh toán hoặc click
                                                    vào giỏ hàng để xem chi tiết giỏ hàng.</h5>
                                            </div>
                                            <div class="delivery-icon">
                                                <img src="{{ asset('theme/client/assets/images/huongDan2.png') }}"
                                                    class="blur-up lazyload" alt=""
                                                    style="width: 600px; height: 300px">
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="delivery-box">
                                            <div class="delivery-detail">
                                                <h5 class="text">- Chọn sản phẩm để thanh toán .</h5>
                                            </div>
                                            <div class="delivery-icon">
                                                <img src="{{ asset('theme/client/assets/images/huongDan3.png') }}"
                                                    class="blur-up lazyload" alt=""
                                                    style="width: 600px; height: 300px">
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="delivery-box">
                                            <div class="delivery-detail">
                                                <h5 class="text">- Điền đầy đủ thông tin ,chọn phương thức thanh toán, sử
                                                    dụng voucher (nếu có), sau đó Xác nhận đơn hàng.</h5>
                                            </div>
                                            <div class="delivery-icon">
                                                <img src="{{ asset('theme/client/assets/images/huongDan4.png') }}"
                                                    class="blur-up lazyload" alt=""
                                                    style="width: 600px; height: 300px">
                                            </div>
                                        </div>
                                    </li>
                                    <h4> Như vậy đơn hàng đã được đặt thành công! </h4>
                                </ul>
                            </div>

                            <div class="delivery-list mt-4"> <!-- Tạo khoảng cách giữa các khối -->
                                <h2 class="mb-3">Các lưu ý khi mua hoặc hoàn hàng: </h2> <!-- Cách ul xuống -->
                                <ul class="mt-2"> <!-- Tạo khoảng cách giữa h2 và danh sách -->
                                    <li>Kiểm tra kỹ sản phẩm trước khi xác nhận đặt hàng.</li>
                                    <li>Đọc kỹ chính sách đổi trả trước khi hoàn hàng.</li>
                                    <li>Chỉ hoàn hàng trong thời gian quy định.</li>
                                </ul>
                            </div>

                        </div>


                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection
@push('js')
@endpush
