<?php

namespace App\NotificationPublisher\Infrastructure\Database\Repositories;

use App\NotificationPublisher\Domain\Entities\Notification;
use App\NotificationPublisher\Domain\Enums\NotificationStatus;
use App\NotificationPublisher\Domain\Repositories\NotificationsRepository as NotificationsRepositoryInterface;
use App\NotificationPublisher\Domain\ValueObjects\NotificationVO;
use App\NotificationPublisher\Infrastructure\Database\Entities\Email;
use App\NotificationPublisher\Infrastructure\Database\Entities\Notification as NotificationDoctrineEntity;
use App\NotificationPublisher\Infrastructure\Database\Entities\Push;
use App\NotificationPublisher\Infrastructure\Database\Entities\SMS;
use App\NotificationPublisher\Infrastructure\Mappers\EmailDoctrineEntityMapper;
use App\NotificationPublisher\Infrastructure\Mappers\NotificationDoctrineEntityMapper;
use App\NotificationPublisher\Infrastructure\Mappers\NotificationVOMapper;
use App\NotificationPublisher\Infrastructure\Mappers\PushDoctrineEntityMapper;
use App\NotificationPublisher\Infrastructure\Mappers\SMSDoctrineEntityMapper;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;

readonly class NotificationsRepository implements NotificationsRepositoryInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private NotificationDoctrineEntityMapper $notificationMapper,
        private EmailDoctrineEntityMapper $emailDoctrineEntityMapper,
        private SMSDoctrineEntityMapper $smsDoctrineEntityMapper,
        private PushDoctrineEntityMapper $pushDoctrineEntityMapper,
        private NotificationVOMapper $notificationVOMapper
    ) {
    }

    public function createNotification(Notification $notification): NotificationVO
    {
        $doctrineEntity = $this->notificationMapper->fromNotificationDomainEntity($notification);
        foreach ($notification->getEmails() as $email) {
            $doctrineEntity->addEmail($this->emailDoctrineEntityMapper->fromEmailDomainEntity($email));
        }
        foreach ($notification->getSms() as $sms) {
            $doctrineEntity->addSms($this->smsDoctrineEntityMapper->fromSMSDomainEntity($sms));
        }
        foreach ($notification->getPushes() as $push) {
            $doctrineEntity->addPush($this->pushDoctrineEntityMapper->fromPushDomainEntity($push));
        }

        $this->entityManager->persist($doctrineEntity);
        $this->entityManager->flush();
        $this->entityManager->refresh($doctrineEntity);

        return $this->notificationVOMapper->fromDoctrineEntity($doctrineEntity);
    }

    public function getNotificationsToSend(): ArrayCollection
    {
        $statuses = [NotificationStatus::READY, NotificationStatus::FAILED];
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $doctrineEntities = $queryBuilder
            ->select('n')
            ->from(NotificationDoctrineEntity::class, 'n')
            ->leftJoin('n.emails', 'e')
            ->leftJoin('n.sms', 's')
            ->leftJoin('n.pushes', 'p')
            ->where($queryBuilder->expr()->in('e.status', ':statuses'))
            ->orWhere($queryBuilder->expr()->in('s.status', ':statuses'))
            ->orWhere($queryBuilder->expr()->in('p.status', ':statuses'))
            ->setParameter('statuses', $statuses)
            ->getQuery()
            ->getResult();

        $notifications = new ArrayCollection();
        foreach ($doctrineEntities as $entity) {
            // todo remove channels that should not be send e.g. status in [sent,queued]
            $notifications->add($this->notificationVOMapper->fromDoctrineEntity($entity));
        }

        return $notifications;
    }

    public function getById(int $id): NotificationVO
    {
        $doctrineEntity = $this->entityManager->getRepository(NotificationDoctrineEntity::class)
            ->find($id);

        if ($doctrineEntity === null) {
            throw new EntityNotFoundException('Notification does not exist');
        }

        return $this->notificationVOMapper->fromDoctrineEntity($doctrineEntity);
    }

    // todo separate repositories for each entity
    public function updateEmailStatus(int $emailId, NotificationStatus $status): void
    {
        $email = $this->entityManager->getRepository(Email::class)->find($emailId);
        if ($email === null) {
            return;
        }

        $email->setStatus($status);
        $this->entityManager->persist($email);
        $this->entityManager->flush();
    }

    public function updateSMSStatus(int $smsId, NotificationStatus $status): void
    {
        $sms = $this->entityManager->getRepository(SMS::class)->find($smsId);
        if ($sms === null) {
            return;
        }

        $sms->setStatus($status);
        $this->entityManager->persist($sms);
        $this->entityManager->flush();
    }

    public function updatePushStatus(int $pushId, NotificationStatus $status): void
    {
        $push = $this->entityManager->getRepository(Push::class)->find($pushId);
        if ($push === null) {
            return;
        }

        $push->setStatus($status);
        $this->entityManager->persist($push);
        $this->entityManager->flush();
    }
}
