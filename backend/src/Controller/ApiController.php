<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use OpenApi\Attributes as OA;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api')]
final class ApiController extends AbstractController
{
    #[Route('/tasks', name: 'app_tasks', methods: ['GET'])]
    #[OA\Get(
        summary: 'Получить все задачи',
        responses: [
            new OA\Response(
                response: 200,
                description: 'Задачи получены',
            ),
            new OA\Response(response: 401, description: 'Необходима авторизация')
        ]
    )]
    public function tasks(): JsonResponse
    {
        return $this->json([
            'status' => 'OK',
        ]);
    }
}
