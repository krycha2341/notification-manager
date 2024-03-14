<?php

namespace App\NotificationPublisher\Infrastructure\Services\Email\Providers;

use App\NotificationPublisher\Infrastructure\Services\Email\EmailProvider;

class ProviderTwo implements EmailProvider
{
    public function send(string $email, string $title, string $body): bool
    {
        return true;
    }
}
