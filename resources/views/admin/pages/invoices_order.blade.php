<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>In Đơn Hàng</title>
    <style>
        body {
            font-family: system-ui, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }

        .container {
            width: 80%;
            margin: 20px auto;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .header {
            text-align: center;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #333;
        }

        .order-info {
            margin-bottom: 20px;
        }

        .order-info p {
            margin: 5px 0;
            font-size: 16px;
        }

        .order-info strong {
            color: #333;
        }

        .products-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .products-table th,
        .products-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        .products-table th {
            background-color: #f4f4f4;
            font-weight: bold;
        }

        .products-table td {
            font-size: 14px;
        }

        .total {
            text-align: right;
            margin-top: 20px;
            font-size: 18px;
            font-weight: bold;
        }

        .customer-info {
            margin-top: 20px;
            padding: 15px;
            background-color: #f4f4f4;
            border-radius: 8px;
        }

        .customer-info h3 {
            margin: 0;
            font-size: 18px;
            margin-bottom: 10px;
        }

        .customer-info p {
            margin: 5px 0;
            font-size: 14px;
        }

        .qr-code {
            text-align: center;
            margin-top: 20px;
        }

        .qr-code img {
            max-width: 150px;
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 8px;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>Thông Tin Đơn Hàng</h1>
        </div>

        <!-- Order Information -->
        <div class="order-info">
            <p><strong>Mã Đơn Hàng:</strong> #123456789</p>
            <p><strong>Ngày Đặt Hàng:</strong> 15/01/2025</p>
        </div>

        <!-- Products Table -->
        <table class="products-table">
            <thead>
                <tr>
                    <th>Tên Sản Phẩm</th>
                    <th>Biến Thể</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Áo Thun Nam</td>
                    <td>Màu Đen - Size L</td>
                </tr>
                <tr>
                    <td>Quần Jean</td>
                    <td>Màu Xanh - Size 32</td>
                </tr>
            </tbody>
        </table>

        <!-- Total Price -->
        <div class="total">
            Tổng Tiền: 900,000đ
        </div>

        <!-- Customer Information -->
        <div class="customer-info">
            <h3>Thông Tin Người Nhận</h3>
            <p><strong>Họ và Tên:</strong> Nguyễn Văn A</p>
            <p><strong>Số Điện Thoại:</strong> 0123 456 789</p>
            <p><strong>Địa Chỉ:</strong> 123 Đường ABC, Quận 1, TP. Hồ Chí Minh</p>
        </div>

        <!-- QR Code -->
        <div class="qr-code">
            <p><strong>Mã QR Quét Thông Tin:</strong></p>
            <img src="https://via.placeholder.com/150" alt="QR Code">
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Cảm ơn quý khách đã mua sắm tại cửa hàng của chúng tôi!</p>
        </div>
    </div>
</body>

</html>
