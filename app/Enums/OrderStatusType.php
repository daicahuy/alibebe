<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class OrderStatusType extends Enum
{
    const PENDING = 0;          // Chờ xử lý
    const PROCESSING = 1;       // Đang xử lý
    const SHIPPING = 2;         // Đang giao hàng
    const DELIVERED = 3;        // Đã giao hàng
    const FAILED_DELIVERY = 4;  // Giao hàng thất bại
    const COMPLETED = 5;        // Hoàn thành
    const CANCEL = 6;           // Đã hủy
}
