<?php

namespace App\NotificationPublisher\Infrastructure\Mappers;

use App\NotificationPublisher\Domain\Entities\Email;
use App\NotificationPublisher\Infrastructure\Database\Entities\Email as DoctrineEmail;

readonly class EmailDoctrineEntityMapper
{
    public function fromEmailDomainEntity(Email $email): DoctrineEmail
    {
        return new DoctrineEmail(
            email: $email->getEmail(),
            status: $email->getStatus()->value
        );
    }
}
