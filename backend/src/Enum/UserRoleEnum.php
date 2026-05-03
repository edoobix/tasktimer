<?php

namespace App\Enum;

enum UserRoleEnum: string
{
    case SUPER_ADMIN = 'ROLE_SUPER_ADMIN';
    case ADMIN = 'ROLE_ADMIN';
    case USER = 'ROLE_USER';
    case MODERATOR = 'ROLE_MODERATOR';

    public function getLabel(): string
    {
        return match ($this) {
            self::SUPER_ADMIN => 'Супер администратор',
            self::ADMIN => 'Администратор',
            self::USER => 'Пользователь',
            self::MODERATOR => 'Модератор',
        };
    }

    public function getBadgeClass(): string
    {
        return match($this) {
            self::SUPER_ADMIN => 'bg-danger',
            self::ADMIN => 'bg-success',
            self::MODERATOR => 'bg-warning text-dark',
            default => 'bg-secondary',
        };
    }
}
