<?php

namespace App\NotificationPublisher\Domain\Entities;

use App\NotificationPublisher\Domain\Enums\NotificationStatus;

readonly class Email
{
    public function __construct(
        private string $email,
        private NotificationStatus $status
    ) {
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getStatus(): NotificationStatus
    {
        return $this->status;
    }
}
