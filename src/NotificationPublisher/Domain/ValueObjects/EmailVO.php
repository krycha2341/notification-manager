<?php

namespace App\NotificationPublisher\Domain\ValueObjects;

use App\NotificationPublisher\Domain\Enums\NotificationStatus;
use DateTime;

readonly class EmailVO
{
    public function __construct(
        private int $id,
        private int $notificationId,
        private string $email,
        private NotificationStatus $status,
        private DateTime $createdAt,
        private DateTime $updatedAt
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getNotificationId(): int
    {
        return $this->notificationId;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getStatus(): NotificationStatus
    {
        return $this->status;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }
}
