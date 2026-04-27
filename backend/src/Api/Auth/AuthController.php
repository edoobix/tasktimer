<?php

namespace App\Api\Auth;

use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

final class AuthController extends AbstractController
{
    #[Route('/api/login_check', name: 'api_login', methods: ['POST'])]
    #[OA\Tag(name: 'Авторизация')]
    #[OA\Post(
        summary: 'Получить JWT токен',
        requestBody: new OA\RequestBody(
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'login', type: 'string', example: 'admin'),
                    new OA\Property(property: 'password', type: 'string', example: 'password')
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: 'Успешная авторизация',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'token', type: 'string'),
                        new OA\Property(property: 'refresh_token', type: 'string')
                    ]
                )
            ),
            new OA\Response(response: 401, description: 'Неверные данные')
        ]
    )]
    public function login()
    {
        throw new \Exception('This method should be intercepted by the firewall.');
    }

    #[Route('/api/token/refresh', name: 'api_refresh_token', methods: ['POST'])]
    #[OA\Tag(name: 'Авторизация')]
    #[OA\Post(
        description: 'Принимает refresh_token и выдает новую пару токенов (JWT + Refresh).',
        summary: 'Обновить JWT токен',
        requestBody: new OA\RequestBody(
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(
                        property: 'refresh_token',
                        type: 'string',
                        example: '5b74684d62061...'
                    )
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: 'Токены успешно обновлены',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'token', description: 'Новый JWT токен', type: 'string'),
                        new OA\Property(property: 'refresh_token', description: 'Новый Refresh токен', type: 'string')
                    ]
                )
            ),
            new OA\Response(
                response: 401,
                description: 'Неверный или просроченный refresh_token'
            )
        ]
    )]
    public function refreshToken()
    {
        throw new \LogicException('This code is intercepted by the security layer.');
    }
}
