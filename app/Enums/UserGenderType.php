<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class UserGenderType extends Enum
{
    const MALE = 0;     // Nam
    const FEMALE = 1;   // Nữ
    const OTHER = 2;    // Khác
}
