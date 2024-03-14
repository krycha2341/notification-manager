<?php

namespace App\NotificationPublisher\Infrastructure\Mappers;

use App\NotificationPublisher\Domain\Entities\SMS;
use App\NotificationPublisher\Infrastructure\Database\Entities\SMS as DoctrineSMS;

readonly class SMSDoctrineEntityMapper
{
    public function fromSMSDomainEntity(SMS $sms): DoctrineSMS
    {
        return new DoctrineSMS(
            phoneNumber: $sms->getPhoneNumber(),
            status: $sms->getStatus()->value
        );
    }
}
