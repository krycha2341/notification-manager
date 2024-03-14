<?php

namespace App\NotificationPublisher\Domain\Repositories;

use App\NotificationPublisher\Domain\Entities\Notification;
use App\NotificationPublisher\Domain\ValueObjects\NotificationVO;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityNotFoundException;

interface NotificationsRepository
{
    public function createNotification(Notification $notification): NotificationVO;

    /**
     * @return ArrayCollection<NotificationVO>
     */
    public function getNotificationsToSend(): ArrayCollection;

    /**
     * @throws EntityNotFoundException
     */
    public function getById(int $id): NotificationVO;
}
