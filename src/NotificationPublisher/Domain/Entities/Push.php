<?php

namespace App\NotificationPublisher\Domain\Entities;

use App\NotificationPublisher\Domain\Enums\NotificationStatus;

readonly class Push
{
    public function __construct(
        private string $token,
        private NotificationStatus $status
    ) {
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function getStatus(): NotificationStatus
    {
        return $this->status;
    }
}
