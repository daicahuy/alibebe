@extends('client.layouts.master')

@section('content')
    <section class="fresh-vegetable-section section-lg-space">
        <div class="container-fluid-lg">
            <div class="row gx-xl-5 gy-xl-0 g-3 ratio_148_1">
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
                        </div>
                    </div>

                </div>
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
                    <div class="delivery-list mt-4"> <!-- Tạo khoảng cách giữa các khối -->
                        <h2 class="mb-3">Các lưu ý khi mua hoặc hoàn hàng: </h2> <!-- Cách ul xuống -->
                        <ul class="mt-2"> <!-- Tạo khoảng cách giữa h2 và danh sách -->
                            <li>Kiểm tra kỹ thông tin sản phẩm (mô tả, hình ảnh, giá, chính sách bảo hành) trước khi đặt
                                hàng.</li>
                            <li>Đảm bảo địa chỉ giao hàng chính xác để tránh phát sinh chi phí giao hàng lại.</li>
                            <li>Lựa chọn phương thức thanh toán phù hợp (thanh toán khi nhận hàng, chuyển khoản, ví điện tử,
                                v.v.).</li>
                            <li>Kiểm tra mã giảm giá hoặc ưu đãi trước khi thanh toán để không bỏ lỡ khuyến mãi.</li>
                            <li>Hạn chế đặt quá nhiều đơn hàng nhỏ lẻ để tiết kiệm phí vận chuyển.</li>
                            <li>Nếu có thắc mắc về sản phẩm, hãy liên hệ ngay bộ phận hỗ trợ trước khi mua.</li>
                            <li>Sản phẩm hoàn trả phải còn nguyên vẹn, không bị hư hỏng, móp méo, không có dấu hiệu đã qua
                                sử dụng.</li>
                            <li>Nếu sản phẩm bị lỗi do nhà sản xuất, cần chụp ảnh hoặc quay video lỗi để làm bằng chứng khi
                                hoàn hàng.</li>
                            <li>Một số sản phẩm không được áp dụng đổi trả, chẳng hạn như: hàng khuyến mãi đặc biệt, sản
                                phẩm tiêu dùng nhanh, v.v.</li>
                            <li>Sau khi gửi hàng hoàn trả, nên theo dõi tình trạng đơn hàng hoàn trên hệ thống.</li>
                            <li>Hoàn hàng thành công, tiền sẽ được hoàn vào phương thức thanh toán ban đầu hoặc tài khoản ví
                                điện tử (nếu có).</li>
                            <li>Hoàn tiền 100% nếu lỗi từ nhà sản xuất hoặc giao sai sản phẩm.</li>
                            <li>Nếu đổi ý sau khi mua, phí hoàn hàng có thể do khách hàng chi trả.</li>
                            <li>Thời gian hoàn tiền có thể từ 3-7 ngày làm việc tùy vào phương thức thanh toán.</li>
                            <li>Liên hệ hỗ trợ khi có vấn đề về đơn hàng qua hotline, email hoặc chat trực tuyến.</li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
@push('js')
@endpush
