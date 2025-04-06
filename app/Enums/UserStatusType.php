<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class UserStatusType extends Enum
{
    const LOCK = 0;     // 0. Bị khóa
    const ACTIVE = 1;   // 1. Hoạt động
}
