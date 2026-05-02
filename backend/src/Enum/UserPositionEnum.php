<?php

namespace App\Enum;

enum UserPositionEnum: string
{
    case DIRECTOR = 'director';
    case EMPLOYEE = 'employee';
    case SECRETARY = 'secretary';

    public function getLabel(): string
    {
        return match ($this) {
            self::DIRECTOR => 'Руководитель',
            self::EMPLOYEE => 'Сотрудник',
            self::SECRETARY => 'Секретарь',
        };
    }
}
