<?php

namespace App\NotificationPublisher\Infrastructure\Services\Push\Providers;

use App\NotificationPublisher\Infrastructure\Services\Push\PushProvider;

class ProviderOne implements PushProvider
{
    public function send(string $token, string $title, string $message): bool
    {
        return false;
    }
}
