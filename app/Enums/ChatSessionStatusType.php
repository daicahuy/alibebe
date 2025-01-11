<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class ChatSessionStatusType extends Enum
{
    const CLOSED = 0;   // Phiên đã đóng
    const OPEN = 1;     // Phiên đang mở
}
