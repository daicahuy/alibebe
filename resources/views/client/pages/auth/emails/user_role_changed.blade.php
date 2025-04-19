<!DOCTYPE html>
<html>
<head>
    <title>Thông báo thay đổi quyền tài khoản</title>
</head>
<body>
    <p>Xin chào {{ $user->fullname }},</p>
    <p>Quyền tài khoản của bạn đã được thay đổi.</p>
    <p>Quyền mới: <strong>{{ $newRole }}</strong></p>
    <p>Nếu bạn có bất kỳ thắc mắc nào, vui lòng liên hệ với chúng tôi.</p>
    <p>Trân trọng,</p>
    <p>Đội ngũ hỗ trợ</p>
</body>
</html>