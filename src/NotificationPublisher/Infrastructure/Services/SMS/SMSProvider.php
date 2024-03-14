<?php

namespace App\NotificationPublisher\Infrastructure\Services\SMS;

use App\NotificationPublisher\Domain\ValueObjects\NotificationVO;

interface SMSProvider
{
    public function send(string $phoneNumber, string $title, string $message): bool;
}