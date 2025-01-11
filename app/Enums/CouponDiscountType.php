<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class CouponDiscountType extends Enum
{
    const FIX_AMOUNT = 0;   // 0. Giảm giá theo số tiền cố định
    const PERCENT = 1;      // 1. Giảm giá theo phần trăm
}
