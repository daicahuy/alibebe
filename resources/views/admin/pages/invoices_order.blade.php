<!DOCTYPE html>
<html lang="en">

<head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
</head>

<?php
function formatCurrencyVND($number)
{
    // Định dạng số thành dạng 123.123,00
    return number_format($number, 2, ',', '.');
}

?>

<style>
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



    .order-info p {
        margin: 5px 0;
        font-size: 12px;
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
        padding: 20px;
        text-align: left;
    }

    .products-table th {
        background-color: #f4f4f4;
        font-weight: bold;
    }

    .products-table td,
    .products-table tr {
        font-size: 8px;
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
        font-size: 14px;
        margin-bottom: 10px;
    }

    .customer-info p {
        margin: 5px 0;
        font-size: 12px;
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


<body>

    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>Thông Tin Đơn Hàng</h1>
        </div>

        <!-- Order Information -->
        <div class="order-info d-flex flex-row" style="align-items: center; justify-content: center">
            <div>
                <p><strong>Mã Đơn Hàng:</strong> {{ $dataOrder[0]['order']['code'] }}</p>
            </div>

        </div>

        <!-- Products Table -->
        <table class="products-table">
            <thead>
                <tr>
                    <th>Tên Sản Phẩm</th>
                    <th>Loại</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($dataOrder as $item)
                    <tr>
                        <td>{{ $item['name'] }}</td>
                        <td>{{ $item['name_variant'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Total Price -->
        <div class="total">Thu tiền:
            {{ $dataOrder[0]['order']['is_paid'] == 0 ? formatCurrencyVND($dataOrder[0]['order']['total_amount']) : '0' }}đ
        </div>

        <!-- Customer Information -->
        <div class="customer-info">
            <h3>Thông Tin Người Nhận</h3>
            <p><strong>Họ và Tên:</strong> {{ $dataOrder[0]['order']['fullname'] }}</p>
            <p><strong>Số Điện Thoại:</strong> {{ $dataOrder[0]['order']['phone_number'] }}</p>
            <p><strong>Địa Chỉ: </strong> {{ $dataOrder[0]['order']['address'] }}
            </p>
            <p><strong>Note: </strong> {{ $dataOrder[0]['order']['note'] }}
            </p>
        </div>

        <!-- QR Code -->
        <div class="qr-code">
            <p><strong>Mã QR Quét Thông Tin:</strong></p>
            <img src="https://cdn.pixabay.com/photo/2013/07/12/14/45/qr-code-148732_640.png"
                style="width: 50px; height: 50px" alt="" />
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Cảm ơn quý khách đã mua sắm tại cửa hàng của chúng tôi!</p>
        </div>
    </div>
</body>

</html>
