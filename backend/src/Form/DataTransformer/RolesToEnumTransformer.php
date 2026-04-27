<?php

namespace App\Form\DataTransformer;

use App\Enum\UserRoleEnum;
use Symfony\Component\Form\DataTransformerInterface;

class RolesToEnumTransformer implements DataTransformerInterface
{
    public function transform($value): array
    {
        if (!$value) return [];

        return array_map(
            fn($role) => UserRoleEnum::tryFrom($role),
            (array) $value
        );
    }

    public function reverseTransform($value): array
    {
        if (!$value) return [];

        return array_map(
            fn($enum) => $enum instanceof UserRoleEnum ? $enum->value : $enum,
            (array) $value
        );
    }
}
