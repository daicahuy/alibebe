<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class StockMovementType extends Enum
{
    const IMPORT = 0;       // 0. Nhập kho
    const EXPORT = 1;       // 1. Xuất kho
    const ADJUSTMENT = 2;   // 2. Kiểm kho
}
