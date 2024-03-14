<?php

namespace App\NotificationPublisher\Infrastructure\Mappers;

use App\NotificationPublisher\Domain\ValueObjects\EmailVO;
use App\NotificationPublisher\Infrastructure\Database\Entities\Email;

readonly class EmailVOMapper
{
    public function fromDoctrineEmailEntity(Email $email): EmailVO
    {
        return new EmailVO(
            $email->getId(),
            $email->getNotification()->getId(),
            $email->getEmail(),
            $email->getStatus(),
            $email->getCreatedAt(),
            $email->getUpdatedAt()
        );
    }
}
