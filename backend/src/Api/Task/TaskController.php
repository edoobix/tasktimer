<?php

namespace App\Api\Task;

use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api')]
final class TaskController extends AbstractController
{
    #[Route('/tasks', name: 'app_tasks', methods: ['GET'])]
    #[OA\Tag(name: 'Задачи')]
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
