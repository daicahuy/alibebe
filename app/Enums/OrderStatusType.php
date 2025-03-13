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
    const PENDING = 1;          // Chờ xử lý
    const PROCESSING = 2;       // Đang xử lý
    const SHIPPING = 3;         // Đang giao hàng
    const DELIVERED = 4;        // Đã giao hàng
    const FAILED_DELIVERY = 5;  // Giao hàng thất bại
    const COMPLETED = 6;        // Hoàn thành
    const CANCEL = 7;           // Đã hủy
    const RETURN = 8;           // Đã hủy

}
