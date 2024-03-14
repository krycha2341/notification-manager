<?php

namespace App\NotificationPublisher\Infrastructure\Services\Email;

use App\NotificationPublisher\Application\Exceptions\SenderUnexpectedException;
use App\NotificationPublisher\Domain\ValueObjects\EmailVO;
use App\NotificationPublisher\Domain\ValueObjects\NotificationVO;

readonly class EmailSender
{
    public function __construct(private EmailProvidersRegistry $providersRegistry)
    {
    }

    /**
     * @throws SenderUnexpectedException
     */
    public function send(NotificationVO $notificationVO, EmailVO $emailVO): void
    {
        $providers = $this->providersRegistry->getProviders();
        foreach ($providers as $provider) {
            if ($provider->send(
                $emailVO->getEmail(),
                $notificationVO->getTitle(),
                $notificationVO->getBody()
            )) {
                return;
            }
        }

        throw new SenderUnexpectedException('email sender');
    }
}
