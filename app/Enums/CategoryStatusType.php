<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class CategoryStatusType extends Enum
{
    const INACTIVE = 0;     // 0. Không hoạt động
    const ACTIVE = 1;       // 1. Hoạt động

}
