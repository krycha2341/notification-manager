<?php

namespace App\NotificationPublisher\UserInterface;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class TestHandler
{
    #[Route('/test', name: 'test')]
    public function index(): JsonResponse
    {
        return new JsonResponse(['test']);
    }
}
