<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class NotificationType extends Enum
{
    const Coupon = 0;
    const Order = 1;
    const System = 2;
    const Bank = 3;
    const Refund = 4;
    const Confirm = 5;
}
