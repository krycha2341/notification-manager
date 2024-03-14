<?php

namespace App\NotificationPublisher\Infrastructure\Mappers;

use App\NotificationPublisher\Domain\Entities\Notification;
use App\NotificationPublisher\Infrastructure\Database\Entities\Notification as DoctrineNotification;

readonly class NotificationDoctrineEntityMapper
{
    public function fromNotificationDomainEntity(Notification $notification): DoctrineNotification
    {
        return new DoctrineNotification(
            userId: $notification->getUserId(),
            title: $notification->getTitle(),
            body: $notification->getBody()
        );
    }
}
