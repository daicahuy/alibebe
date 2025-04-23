<!DOCTYPE html>
<html>
<head>
    <title>Tài khoản bị khóa</title>
</head>
<body>
    <p>Xin chào {{ $user->name }},</p>
    <p>Tài khoản của bạn đã bị khóa vì lý do sau:</p>
    <p><strong>{{ $reason }}</strong></p>
    <p>Nếu bạn có bất kỳ thắc mắc nào, vui lòng liên hệ với chúng tôi qua email hỗ trợ hoặc số điện thoại.</p>
    <p>Trân trọng,</p>
    <p>Đội ngũ hỗ trợ</p>
</body>
</html>