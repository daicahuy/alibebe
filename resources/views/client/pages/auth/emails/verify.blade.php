<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác minh Email</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
            width: 80%;
            max-width: 600px;
            text-align: center;
        }

        h1 {
            color: #333;
        }

        p {
            color: #555;
            line-height: 1.6;
        }

        .button {
            display: inline-block;
            padding: 12px 24px;
            background-color: #007bff;
            /* Màu xanh dương, bạn có thể thay đổi */
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .button:hover {
            background-color: #0056b3;
            /* Màu xanh đậm hơn khi di chuột qua */
        }

        .footer {
            margin-top: 20px;
            font-size: 0.8em;
            color: #777;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Chào mừng bạn đến với Alibebe!</h1>
        <p>Cảm ơn bạn đã đăng ký tài khoản trên website của chúng tôi.</p>
        <p>Vui lòng nhấp vào nút bên dưới để xác minh địa chỉ email của bạn và kích hoạt tài khoản:</p>
        <a href="{{ $verificationUrl }}" class="button">Xác minh Email</a>
        <p>Nếu bạn không thực hiện hành động này, tài khoản của bạn sẽ không được kích hoạt trong vòng 24 giờ.</p>
        <p>Nếu bạn không đăng ký tài khoản này, vui lòng bỏ qua email này.</p>
        <div class="footer">
            © {{ date('Y') }} Alibebe. Đã đăng ký bản quyền.
        </div>
    </div>
</body>

</html>
