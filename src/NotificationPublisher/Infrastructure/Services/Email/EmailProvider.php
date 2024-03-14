<?php

namespace App\NotificationPublisher\Infrastructure\Services\Email;

interface EmailProvider
{
    public function send(string $email, string $title, string $body): bool;
}
