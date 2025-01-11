<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class HistoryActionType extends Enum
{
    const CREATE = 0;           // Tạo mới
    const UPDATE = 1;           // Cập nhật
    const DELETE = 2;           // Xóa
    const CHANGE_STATUS = 3;    // Thay đổi trạng thái
}
