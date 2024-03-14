<?php

namespace App\NotificationPublisher\UserInterface\Rest;

use App\NotificationPublisher\Application\Services\NotificationsService;
use App\NotificationPublisher\Domain\Entities\Email;
use App\NotificationPublisher\Domain\Entities\Notification;
use App\NotificationPublisher\Domain\Entities\Push;
use App\NotificationPublisher\Domain\Entities\SMS;
use App\NotificationPublisher\Domain\Enums\NotificationStatus;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CreateNotification extends AbstractController
{
    public function __construct(private readonly NotificationsService $notificationsService)
    {
    }

    #[Route('/notifications/create', name: 'create_notification', methods: ['POST'])]
    public function createNotification(Request $request): JsonResponse
    {
        // todo validate input
        $body = new ArrayCollection(json_decode($request->getContent(), true));
        $emails = new ArrayCollection();
        foreach ($body->get('emails') as $emailData) {
            $emailChannel = new Email(
                $emailData,
                NotificationStatus::READY
            );
            $emails->add($emailChannel);
        }
        $sms = new ArrayCollection();
        foreach ($body->get('sms') as $smsData) {
            $smsChannel = new SMS(
                $smsData,
                NotificationStatus::READY
            );
            $sms->add($smsChannel);
        }
        $pushes = new ArrayCollection();
        foreach ($body->get('pushes') as $pushData) {
            $pushChannel = new Push(
                $pushData,
                NotificationStatus::READY
            );
            $pushes->add($pushChannel);
        }

        $notification = new Notification(
            $body->get('user_id'),
            $body->get('title'),
            $body->get('body'),
            $emails,
            $sms,
            $pushes
        );

        $notificationVo = $this->notificationsService->createNotification($notification);

        // todo transformer
        return new JsonResponse([
            'id' => $notificationVo->getId(),
        ]);
    }
}
