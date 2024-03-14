<?php

namespace App\NotificationPublisher\Infrastructure\Services\Push;

interface PushProvider
{
    public function send(string $token, string $title, string $message): bool;
}
