<?php

namespace App\NotificationPublisher\Infrastructure\Mappers;

use App\NotificationPublisher\Domain\ValueObjects\PushVO;
use App\NotificationPublisher\Infrastructure\Database\Entities\Push;

readonly class PushVOMapper
{
    public function fromDoctrineEntity(Push $push): PushVO
    {
        return new PushVO(
            $push->getId(),
            $push->getNotification()->getId(),
            $push->getToken(),
            $push->getStatus(),
            $push->getCreatedAt(),
            $push->getUpdatedAt()
        );
    }
}
