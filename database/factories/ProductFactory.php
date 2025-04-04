<?php

namespace Database\Factories;

use App\Enums\ProductType;
use App\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $name = $this->fakeName();
        $price = $this->faker->numberBetween(50000, 10000000);
        $salePrice = $this->faker->boolean(40) ? ceil($price * 0.9) : null;

        return [
            'brand_id' => Brand::inRandomOrder()->first()->id ?? 1,
            'name' => $name,
            'slug' => Str::slug($name),
            'views' => $this->faker->numberBetween(0, 10000),
            'short_description' => $this->faker->sentence(10),
            'description' => $this->fakeDescription(),
            'thumbnail' => 'products/product_1.png',
            'type' => $this->faker->randomElement([ProductType::SINGLE, ProductType::VARIANT]),
            'sku' => $this->faker->unique()->numerify('SP-#####'),
            'price' => $price,
            'sale_price' => $salePrice,
            'sale_price_start_at' => $salePrice ? now()->subDays(rand(1, 30)) : null,
            'sale_price_end_at' => $salePrice ? now()->addDays(rand(1, 30)) : null,
            'is_sale' => $salePrice !== null,
            'is_featured' => $this->faker->boolean(20),
            'is_trending' => $this->faker->boolean(10),
            'is_active' => $this->faker->boolean(90)
        ];
    }

    public function single()
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => ProductType::SINGLE,
                'thumbnail' => 'products/product_1.png',
            ];
        });
    }

    public function variant()
    {

        return $this->state(function (array $attributes) {
            $isSale = $this->faker->boolean(50);
            return [
                'type' => ProductType::VARIANT,
                'thumbnail' => 'products/product_2.png',
                'price' => null,
                'sale_price' => null,
                'sale_price_start_at' => $isSale ? now()->subDays(rand(1, 30)) : null,
                'sale_price_end_at' => $isSale ? now()->addDays(rand(1, 30)) : null,
                'is_sale' => $isSale,
            ];
        });
    }

    public function fakeName()
    {
        $productTypes = ['Phone', 'Laptop', 'Tablet', 'Smartwatch', 'Monitor', 'TV', 'Watch', 'Iphone', 'Macbook'];
        $modelNumbers = ['Pro', 'Max', 'Ultra', 'Plus', 'Air', 'Mini'];

        $productType = $productTypes[array_rand($productTypes)];
        $model = $this->faker->randomElement(['S', 'M', 'X', 'Z']) . rand(10, 99);
        $extra = $this->faker->randomElement($modelNumbers);
        $unique = $this->faker->unique()->randomNumber();

        return "$productType $model $extra $unique";
    }

    public function fakeDescription()
    {
        return "<h2><strong>Đặc điểm nổi bật của iPhone 14 128GB | Chính hãng VN/A</strong></h2><ol><li>Tuyệt đỉnh thiết kế, tỉ mỉ từng đường nét - Nâng cấp toàn diện với kiểu dáng mới, nhiều lựa chọn màu sắc trẻ trung</li><li>Nâng tầm trải ngiệm giải trí đỉnh cao - Màn hình 6,1 cùng tấm nền OLED có công nghệ Super Retina XDR cao cấp</li><li>Chụp ảnh chuyên nghiệp hơn - Cụm 2 camera 12 MP đi kèm nhiều chế độ và chức năng chụp hiện đại</li><li>Hiệu năng hàng đầu thế giới - Apple A15 Bionic 6 nhân xử lí nhanh, ổn định</li></ol><h2><strong>Ưu đãi hấp dẫn khi mua hàng - trả góp iPhone 14 series tại CellphoneS</strong></h2><p>Khi lựa chọn mua iPhone 14 Series tại CellphoneS, quý khách hàng không chỉ nhận được sản phẩm chất lượng, chính hãng VN/A mmaf bên cạnh đó còn được trải nghiệm nhiều <strong>chương trình giảm giá</strong> hấp dẫn, trừ thẳng vào giá sản phẩm. Chi tiết ưu đãi cho khách hàng khi <strong>mua điện thoại iPhone 14 series tại CellphoneS</strong> như sau:</p><ul><li>Nhận ưu đãi mua hàng hấp dẫn cho khách hàng thành viên Smember: Giảm thêm đến 1% (tuỳ sản phẩm và cấp bậc thành viên).</li><li>1 ĐỔI 1 trong 30 ngày nếu có lỗi phần cứng nhà sản xuất. Bảo hành 12 tháng tại trung tâm bảo&nbsp;uỷ quyền Apple của CellphoneS&nbsp;-&nbsp;CareS.vn</li><li>Mua trả góp 3 KHÔNG: KHÔNG thu phí chuyển đổi với kỳ hạn trả góp 3 -&nbsp; 6 tháng, KHÔNG lãi suất và KHÔNG thêm phí dịch vụ</li><li>Khu demo sản phẩm giúp khách hàng có thể trải nghiệm và trên tay trực tiếp sản phẩm</li></ul><p>Ngoài ra, mới đây Apple cũng đã trình làng dòng điện thoại iPhone 15 Series với nhiều nâng cấp mới so với thế hệ trước. Khách hàng có thể đặt trước các phiên bản trong đó có <a href='https://cellphones.com.vn/iphone-15.html'><strong>iPhone 15 128GB</strong></a> tại CellphoneS từ ngày 22/9 để được hưởng nhiều khuyến mãi hấp dẫn.</p><h2><strong>iPhone 14 màu vàng (Yellow) mới</strong></h2><p><strong>iPhone 14 vàng&nbsp;</strong>là phiên bản màu sắc mới được Apple cập nhật vào&nbsp;<strong>tháng 3/2023</strong>. Điện thoại iPhone 14 <strong>vàng chanh</strong> này được hoàn thiệt mặt sau bằng kinh và cạnh viền nhôm màu vàng rực rõ. Các chi tiết khác sẽ giống những mẫu iPhone 14 phiên bản màu khác. Cụ thể, iPhone 14 vàng được trang bị màn hình&nbsp;OLED 6.1 inch siêu sắc nét. Hiệu năng vượt trội tới từ chipset đầu bảng - A15 Bionic. Hệ thống camera với nhiều cải tiến mới cùng dung lượng pin 3279mAh giúp nâng cao trải nghiệm của người dùng.</p><h3><strong>Mở hộp iPhone 14 màu vàng</strong></h3><p>Ấn tượng đầu tiên của người dùng khi mở hộp iPhone 14 phiên bản màu vàng có lẽ là sự <strong>chỉn chu, tinh tế</strong> trong cách đóng gói của Apple. Cácc lớp Seal, nhãn mác của hộp iPhone 14 màu vàng được kiểm tra kỹ và bảo đảm nguyên vẹn. Qua đó, ta có thể dễ dàng thấy được là Apple cực kỳ coi trọng khâu đóng gói sản phẩm. </p><p>Về tổng quan, vỏ hộp của iPhone 14 có tông màu trắng chủ đạo. Phía trước hộp là hình ảnh lớn, được in khá rõ nét của sản phẩm. Ở phía mặt sau, Apple thông tin đầy đủ đến người dùng các thông số chi tiết của iPhone 14 vàng như: số máy, mã máy. </p><p>Ngay sau khi mở hộp, người dùng có thể thấy ngay được chiếc <strong>iPhone 14 vàng</strong> được đặt gọn gàng ở phía bên trong. Máy được đặt úp trong hộp, để lộ phần mặt lưng bóng bẩy cùng cụm camera đôi sang trọng.</p><p><span class='image-inline ck-widget' contenteditable='false'><img src='https://cdn2.cellphones.com.vn/insecure/rs:fill:0:0/q:90/plain/https://cellphones.com.vn/media/wysiwyg/Phone/Apple/iphone-14/iphone-14-plus-128gb-vang-1_1.jpg' alt='Mở hộp iPhone 14 màu vàng'></span></p><p>Đi kèm theo đó vẫn là những phụ kiện không thể thiếu của iPhone 14 phiên bản màu vàng là: que chọc Sim, giấy hướng dẫn sử dụng, dây sạc Lightning và miếng dán hình quả Táo. Do chính sách bảo vệ môi trường nên trong phiên bản này, người dùng cũng sẽ không được trang bị hộp sạc bên trong hộp sản phẩm.</p><p>Mẫu <strong>iPhone 14 vàng chanh</strong> được hoàn thiện với mặt lưng kinh vàng và cạnh nhôm. Tổng thể sắc vàng trên iPhone 14 mới này khá rực rỡ. Khung nhôm trên iPhone cũng được trang bị sắc vàng, nhưng so với mặt lưng thì sắc vàng này có phần xỉn màu hơn đôi chút.</p><p>So với sắc vàng đã từng xuất hiện trên iPhone Xr thì&nbsp;Phone 14 vàng chanh sở hữu màu sắc rực rỡ hơn.</p><h3><strong>Trên tay iPhone 14 vàng - Sang trọng, thời thượng trong từng chi tiết</strong></h3><p>Điện thoại&nbsp;<strong>iPhone 14 vàng&nbsp;</strong>được người tiêu dùng đánh giá là smartphone mạnh mẽ và đáng mua ở thời điểm hiện tại. Thiết bị hấp dẫn người dùng nhờ sở hữu hàng loạt những thông số kỹ thuật ấn tượng về cả thiết kế bên ngoài lẫn hiệu năng bên trong. Vậy cụ thể thì đột phá công nghệ này được Apple ưu ái trang bị cho những gì? Cùng mình tìm hiểu ngay về iPhone 14 vàng trong bài viết này nhé!</p><h4><strong>Thiết kế sang trọng, sắc vàng thời thượng, tinh tế</strong></h4><p>Ngoài sự khác biệt về sắc vàng thì phiên bản màu mới này của iPhone 14 sẽ không có sự thay đổi về thiết kế.&nbsp;Phần viền thân máy của iPhone 14 khá mỏng chỉ khoảng 7.8mm. Thiết kế tai thỏ trên iPhone 14 vàng cũng gọn hơn so với thế hệ iPhone 13.</p><p><span class='image-inline ck-widget' contenteditable='false'><img src='https://cdn2.cellphones.com.vn/insecure/rs:fill:0:0/q:90/plain/https://cellphones.com.vn/media/wysiwyg/Phone/Apple/iphone-14/iphone-14-plus-128gb-vang-5_1.jpg' alt='Thiết kế iPhone 14 vàng'></span></p><p>Các thông số còn lại của iPhone 14 so với thế hệ tiền nhiệm là gần như không có gì thay đổi. Máy vẫn sở hữu kiểu dáng vô cùng sang trọng, thời thượng. Những đường con bo mềm mại ở góc cùng cạnh viền thân máy được thiết kế dạng phẳng, giúp người dùng có cảm giác cầm nắm nhẹ nhàng, thoải mái.</p><h4><strong>Màn hình hiển thị sắc nét, chân thực trong từng khung hình hiển thị</strong></h4><p>Về chất lượng hình ảnh, <strong>iPhone 14</strong> vàng được người dùng đánh giá khá cao về khả năng hiển thị siêu mượt mà và <strong>cực kỳ sống động</strong>. Cụ thể, màn hình của iPhone 14 được hoàn thiện từ tấm nền Super Retina XDR 6.1 inch cùng với độ phân giải lên tới 2532 x 1170 pixels.</p><p>Đồng thời, iPhone 14 còn sở hữu tốc độ làm mới 60Hz cùng các cảm biến màn hình hiện đại như: cảm biến tiệm cận, cảm biến ánh sáng xung quanh. Nhờ đó, mọi khung hình chuyển động được thể hiện trên iPhone 14 vàng đều vô cùng mượt mà, chân thực.</p><p><span class='image-inline ck-widget' contenteditable='false'><img src='https://cdn2.cellphones.com.vn/insecure/rs:fill:0:0/q:90/plain/https://cellphones.com.vn/media/wysiwyg/Phone/Apple/iphone-14/iphone-14-plus-128gb-vang-11.jpg' alt='Màn hình iPhone 14 vàng'></span></p><p>Thông số màn hình này của thế hệ iPhone mới khá tương đồng với các màu sắc khác. Chất lượng hiển thị của nó cũng đã được kiểm nghiệm qua nhiều phiên bản khác nhau. Do đó, bạn hoàn toàn có thể an tâm về chất lượng hình ảnh khi trải nghiệm xem phim, chơi game trên iPhone 14 nhé!</p><h4><strong>Cấu hình mạnh mẽ, dung lượng bộ nhớ cao</strong></h4><p>So với những smartphone cùng phân khúc khác thì hiệu năng xử lý của <strong>iPhone 14 128GB</strong> không hề thua kém bất kỳ sản phẩm nào. Máy được tích hợp chipset A15 Bionic siêu mạnh mẽ. Do được cải thiện đáng kể về GPU nên hiệu suất xử lý của iPhone 14 đã tăng lên 18% so với thế hệ trước đó.</p><p>Với thông số này, mọi tựa game đồ hoạ cao cấp nhất cũng đều có thể được trải nghiệm vô cùng mượt mà trên iPhone 14 bản vàng tiêu chuẩn. </p><p><span class='image-inline ck-widget' contenteditable='false'><img src='https://cdn2.cellphones.com.vn/insecure/rs:fill:0:0/q:90/plain/https://cellphones.com.vn/media/wysiwyg/Phone/Apple/iphone-14/iphone-14-plus-128gb-vang-2_1.jpg' alt='Cấu hình iPhone 14 vàng'></span></p><p>Chưa dừng lại ở đó, iPhone thế hệ thứ 14 cũng nổi trội với những thông số dung lượng cực kỳ ấn tượng. Smartphone mới này được trang bị bộ nhớ RAM lên tới 6GB. Với khả năng đa nhiệm hoàn hảo tới từ bộ nhớ RAM này, người dùng có thể cùng lúc trải nghiệm được nhiều tác vụ mà không gặp bất kỳ tình trạng giật, lag nào. </p><p>Ngoài ra, máy còn sở hữu 128GB bộ nhớ trong, đem tới cho người dùng không gian lưu trữ tuyệt vời. Bạn có thể thoải mái lưu trữ dữ liệu cá nhân, tải về nhiều ứng dụng lớn mà không phải lo về tình trạng thiếu hụt bộ nhớ.</p><h4><strong>Thời lượng pin lớn, công nghệ sạc nhanh hiện đại</strong></h4><p>Cung cấp năng lượng hoạt động cho <strong>iPhone 14 vàng 128GB</strong> là viên pin <strong>3279mAh</strong>. Đối với một thiết bị iPhone thì đây là số liệu khá ấn tượng. Với thông số nổi trội về dung lượng pin này, bạn có thể trải nghiệm được smartphone mới này trong nhiều giờ liên tục.</p><p>Quá trình nạp lại năng lượng cho iPhone thế hệ thứ 14 này cũng được tối ưu hơn rất nhiều nhờ sở hữu công suất sạc 20W. Thông qua cổng sạc Lightning, hiệu suất nạp pin 20W này có thể giúp người dùng tiết kiệm được kha khá thời gian. Quá trình nạp lại pin cho iPhone giờ đây không còn là nỗi lo đối với các iFan rồi nhé!</p><p><span class='image-inline ck-widget' contenteditable='false'><img src='https://cdn2.cellphones.com.vn/insecure/rs:fill:0:0/q:90/plain/https://cellphones.com.vn/media/wysiwyg/Phone/Apple/iphone-14/iphone-14-plus-128gb-vang-10.jpg' alt='Pin iPhone 14 vàng'></span></p><p>Ngoài ra, iPhone 14 còn được tích hợp tính năng sạc không dây thường và sạc không dây Magsafe, đem tới cho người dùng những trải nghiệm sạc Pin tốt nhất.</p><h4><strong>Cụm camera chất lượng cao, nhiều tính năng quay chụp hiện đại</strong></h4><p>Hệ thống quay chụp trên <strong>thế hệ iPhone thứ 14</strong> này có khá nhiều nâng cấp đáng giá. Dù vẫn sở hữu 2 ống kính hệt như phiên bản trước nhưng bên trong đó đã được tuỳ chỉnh đặc biệt để mang tới cho người dùng những trải nghiệm quay chụp sống động nhất.</p><p>Cụ thể, hai camera 12MP của iPhone 14 được trang bị hàng loạt những công nghệ đỉnh cao như: quay phim 4K 60FPS, quay siêu chậm, chống rung quang học, chụp đêm. Nhờ đó, bạn có thể thỏa mãn được niềm đam mê quay chụp của mình dưới lăng kính hiện đại của iPhone 14 vàng.</p><p><span class='image-inline ck-widget ck-widget_selected' contenteditable='false'><img src='https://cdn2.cellphones.com.vn/insecure/rs:fill:0:0/q:90/plain/https://cellphones.com.vn/media/wysiwyg/Phone/Apple/iphone-14/iphone-14-plus-128gb-vang-12.jpg' alt='Camera iPhone 14 vàng'></span></p><div class='ck-fake-selection-container' style='position: fixed; top: 0px; left: -9999px; width: 42px;'>Camera iPhone 14 vàng image widget</div>";
    }
}
