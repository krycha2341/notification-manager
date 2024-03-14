<?php

namespace App\NotificationPublisher\Infrastructure\Mappers;

use App\NotificationPublisher\Domain\ValueObjects\NotificationVO;
use App\NotificationPublisher\Infrastructure\Database\Entities\Notification;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

readonly class NotificationVOMapper
{
    public function __construct(
        private EmailVOMapper $emailVOMapper,
        private PushVOMapper $pushVOMapper,
        private SMSVOMapper $SMSVOMapper
    ) {
    }

    public function fromDoctrineEntity(Notification $notification): NotificationVO
    {
        return new NotificationVO(
            $notification->getId(),
            $notification->getUserId(),
            $notification->getTitle(),
            $notification->getBody(),
            $this->mapEmails($notification->getEmails()),
            $this->mapSMS($notification->getSms()),
            $this->mapPushes($notification->getPushes()),
            $notification->getCreatedAt(),
            $notification->getUpdatedAt()
        );
    }

    private function mapEmails(Collection $emails): ArrayCollection
    {
        $mappedEmails = new ArrayCollection();
        foreach ($emails as $email) {
            $mappedEmails->add($this->emailVOMapper->fromDoctrineEmailEntity($email));
        }

        return $mappedEmails;
    }

    private function mapSMS(Collection $sms): ArrayCollection
    {
        $mappedSMS = new ArrayCollection();
        foreach ($sms as $eachSms) {
            $mappedSMS->add($this->SMSVOMapper->fromDoctrineSMSEntity($eachSms));
        }

        return $mappedSMS;
    }

    private function mapPushes(Collection $pushes): ArrayCollection
    {
        $mappedPushes = new ArrayCollection();
        foreach ($pushes as $push) {
            $mappedPushes->add($this->pushVOMapper->fromDoctrineEntity($push));
        }

        return $mappedPushes;
    }
}
