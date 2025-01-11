<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class ReviewType extends Enum
{
    const IMAGE = 0;    // 0. Loại ảnh
    const VIDEO = 1;    // 1. Loại video
}
