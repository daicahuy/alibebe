<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class UserGroupType extends Enum
{
    const ALL = 0;          // Nhóm tất cả người dùng
    const NEWBIE = 1;       // Nhóm người dùng mới
    const IRON = 2;         // Nhóm người dùng sắt
    const BRONZE = 3;       // Nhóm người dùng đồng
    const SILVER = 4;       // Nhóm người dùng bạc
    const GOLD = 5;         // Nhóm người dùng vàng
    const PLATINUM = 6;     // Nhóm người dùng bạch kim
    const DIAMOND = 7;      // Nhóm người dùng kim cương
}
