<?php

namespace App\NotificationPublisher\Domain\Entities;

use App\NotificationPublisher\Domain\Enums\NotificationStatus;

readonly class SMS
{
    public function __construct(
        private string $phoneNumber,
        private NotificationStatus $status
    ) {
    }

    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    public function getStatus(): NotificationStatus
    {
        return $this->status;
    }
}
