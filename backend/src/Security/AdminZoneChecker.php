<?php

namespace App\Security;

use App\Entity\User;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class AdminZoneChecker implements UserCheckerInterface
{
    public function checkPreAuth(UserInterface $user): void
    {
        // Здесь можно проверить, например, не забанен ли пользователь
    }

    public function checkPostAuth(UserInterface $user): void
    {
        if (!$user instanceof User) {
            return;
        }

        if (!in_array('ROLE_ADMIN', $user->getRoles()) || !in_array('ROLE_MODERATOR', $user->getRoles())) {
            throw new CustomUserMessageAuthenticationException(
                'У вас нет доступа к административной панели.'
            );
        }
    }
}
