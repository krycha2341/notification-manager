<?php

namespace App\NotificationPublisher\Infrastructure\Services\Email\Providers;

use App\NotificationPublisher\Infrastructure\Services\Email\EmailProvider;

class ProviderOne implements EmailProvider
{
    public function send(string $email, string $title, string $body): bool
    {
        return true;
    }
}
