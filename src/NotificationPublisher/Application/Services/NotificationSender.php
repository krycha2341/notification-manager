<?php

namespace App\NotificationPublisher\Application\Services;

use App\NotificationPublisher\Application\Exceptions\SenderUnexpectedException;
use App\NotificationPublisher\Domain\Enums\NotificationStatus;
use App\NotificationPublisher\Domain\Repositories\NotificationsRepository;
use App\NotificationPublisher\Domain\ValueObjects\NotificationVO;
use App\NotificationPublisher\Infrastructure\Services\Email\EmailSender;
use App\NotificationPublisher\Infrastructure\Services\Push\PushSender;
use App\NotificationPublisher\Infrastructure\Services\SMS\SMSSender;

readonly class NotificationSender
{
    public function __construct(
        private NotificationsRepository $notificationsRepository,
        private EmailSender $emailSender,
        private PushSender $pushSender,
        private SMSSender $SMSSender
    ) {
    }

    public function canSendNotification(NotificationVO $vo): bool
    {
        // todo e.g. throttling

        return true;
    }

    public function sendNotification(NotificationVO $vo): void
    {
        // todo more detailed exception handling
        $this->sendEmails($vo);
        $this->sendSMS($vo);
        $this->sendPushes($vo);
    }

    private function sendEmails(NotificationVO $vo): void
    {
        foreach ($vo->getEmails() as $email) {
            try {
                $this->emailSender->send($vo, $email);
                $this->notificationsRepository->updateEmailStatus(
                    $email->getId(),
                    NotificationStatus::SENT
                );
            } catch (SenderUnexpectedException $exception) {
                $this->notificationsRepository->updateEmailStatus(
                    $email->getId(),
                    NotificationStatus::FAILED
                );
            }
        }
    }

    private function sendSMS(NotificationVO $vo): void
    {
        foreach ($vo->getSMS() as $sms) {
            try {
                $this->SMSSender->send($vo, $sms);
                $this->notificationsRepository->updateSMSStatus(
                    $sms->getId(),
                    NotificationStatus::SENT
                );
            } catch (SenderUnexpectedException $exception) {
                $this->notificationsRepository->updateSMSStatus(
                    $sms->getId(),
                    NotificationStatus::FAILED
                );
            }
        }
    }

    private function sendPushes(NotificationVO $vo): void
    {
        foreach ($vo->getPushes() as $push) {
            try {
                $this->pushSender->send($vo, $push);
                $this->notificationsRepository->updatePushStatus(
                    $push->getId(),
                    NotificationStatus::SENT
                );
            } catch (SenderUnexpectedException $exception) {
                $this->notificationsRepository->updatePushStatus(
                    $push->getId(),
                    NotificationStatus::FAILED
                );
            }
        }
    }
}
