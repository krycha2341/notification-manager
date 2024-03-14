<?php

namespace App\NotificationPublisher\Infrastructure\Mappers;

use App\NotificationPublisher\Domain\ValueObjects\SMSVO;
use App\NotificationPublisher\Infrastructure\Database\Entities\SMS;

readonly class SMSVOMapper
{
    public function fromDoctrineSMSEntity(SMS $sms): SMSVO
    {
        return new SMSVO(
            $sms->getId(),
            $sms->getNotification()->getId(),
            $sms->getPhoneNumber(),
            $sms->getStatus(),
            $sms->getCreatedAt(),
            $sms->getUpdatedAt()
        );
    }
}
