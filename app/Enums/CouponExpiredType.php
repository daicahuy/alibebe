<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class CouponExpiredType extends Enum
{
    const NOT_EXPIRED = 0;   // 0. Không Có Hạn
    const EXPIRED = 1;      // 1. Mã Có Hạn
}
