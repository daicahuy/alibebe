<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class UserRoleType extends Enum
{
    const CUSTOMER = 0;     // 0. Khách hàng
    const EMPLOYEE = 1;     // 1. Nhân viên
    const ADMIN = 2;        // 2. Chủ cửa hàng
}
