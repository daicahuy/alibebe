<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class MessageType extends Enum
{
    const TEXT = 0;     // Tin nhắn văn bản
    const IMAGE = 1;    // Hình ảnh
    const VIDEO = 2;    // Video
    const FILE = 3;     // Tệp tin
}
