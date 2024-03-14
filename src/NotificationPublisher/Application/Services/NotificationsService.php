<?php

namespace App\NotificationPublisher\Application\Services;

use App\NotificationPublisher\Domain\Entities\Notification;
use App\NotificationPublisher\Domain\Repositories\NotificationsRepository;
use App\NotificationPublisher\Domain\ValueObjects\NotificationVO;
use Doctrine\Common\Collections\ArrayCollection;

readonly class NotificationsService
{
    public function __construct(private NotificationsRepository $notificationsRepository)
    {
    }

    public function createNotification(Notification $notification): NotificationVO
    {
        return $this->notificationsRepository->createNotification($notification);

    }

    public function getNotificationsToQueue(?int $notificationId): ArrayCollection
    {
        if ($notificationId === null) {
            return $this->notificationsRepository->getNotificationsToSend();
        }

        $notification = $this->notificationsRepository->getById($notificationId);
        // todo verify if notification has any channel available to use
        $notifications = new ArrayCollection();
        $notifications->add($notification);

        return $notifications;
    }
}
