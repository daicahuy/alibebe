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
    const INACTIVE = 0;     // 0. Không hoạt động
    const ACTIVE = 1;       // 1. Hoạt động
    const LOCK = 2;         // 2. Bị khóa
}
