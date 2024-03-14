<?php

namespace App\NotificationPublisher\Infrastructure\Services\SMS;

use App\NotificationPublisher\Application\Exceptions\SenderUnexpectedException;
use App\NotificationPublisher\Domain\ValueObjects\NotificationVO;
use App\NotificationPublisher\Domain\ValueObjects\SMSVO;

readonly class SMSSender
{
    public function __construct(private SMSProvidersRegistry $providersRegistry)
    {
    }

    /**
     * @throws SenderUnexpectedException
     */
    public function send(NotificationVO $notificationVO, SMSVO $smsVO): void
    {
        $providers = $this->providersRegistry->getProviders();
        foreach ($providers as $provider) {
            if ($provider->send(
                $smsVO->getPhoneNumber(),
                $notificationVO->getTitle(),
                $notificationVO->getBody()
            )) {
                return;
            }
        }

        throw new SenderUnexpectedException('sms sender');
    }
}
