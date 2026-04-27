<?php

namespace App\Admin\User;

use App\Enum\UserRoleEnum;

class UserFilterDTO
{
    public function __construct(
        public ?int $id = null,
        public ?string $login = null,
        public ?UserRoleEnum $role = null,
    ) {
    }
}
