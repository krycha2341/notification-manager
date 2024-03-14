<?php

namespace App\NotificationPublisher\Application\MessageHandlers;

use App\NotificationPublisher\Application\Services\NotificationSender;
use App\NotificationPublisher\Domain\ValueObjects\NotificationVO;
use JetBrains\PhpStorm\NoReturn;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class SendNotificationHandler
{
    public function __construct(private NotificationSender $notificationSender)
    {
    }

    #[NoReturn]
    public function __invoke(NotificationVO $notificationVO): void
    {
        if (!$this->notificationSender->canSendNotification($notificationVO)) {
            return;
        }

        $this->notificationSender->sendNotification($notificationVO);
    }
}
