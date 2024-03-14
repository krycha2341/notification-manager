<?php

namespace App\NotificationPublisher\Infrastructure\Mappers;

use App\NotificationPublisher\Domain\Entities\Push;
use App\NotificationPublisher\Infrastructure\Database\Entities\Push as DoctrinePush;

readonly class PushDoctrineEntityMapper
{
    public function fromPushDomainEntity(Push $push): DoctrinePush
    {
        return new DoctrinePush(
            token: $push->getToken(),
            status: $push->getStatus()->value
        );
    }
}
