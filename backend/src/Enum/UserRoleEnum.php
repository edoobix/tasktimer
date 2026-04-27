<?php

namespace App\Enum;

enum UserRoleEnum: string
{
    case ADMIN = 'ROLE_ADMIN';
    case USER = 'ROLE_USER';
    case MODERATOR = 'ROLE_MODERATOR';

    public function getLabel(): string
    {
        return match ($this) {
            self::ADMIN => 'Администратор',
            self::USER => 'Пользователь',
            self::MODERATOR => 'Модератор',
        };
    }
}
