<?php

namespace App\NotificationPublisher\Infrastructure\Services\SMS\Providers;

use App\NotificationPublisher\Infrastructure\Services\SMS\SMSProvider;

class ProviderTwo implements SMSProvider
{
    public function send(string $phoneNumber, string $title, string $message): bool
    {
        return false;
    }
}
