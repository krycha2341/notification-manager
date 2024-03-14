<?php

namespace App\NotificationPublisher\Infrastructure\Services\Push;

use App\NotificationPublisher\Application\Exceptions\SenderUnexpectedException;
use App\NotificationPublisher\Domain\ValueObjects\NotificationVO;
use App\NotificationPublisher\Domain\ValueObjects\PushVO;

readonly class PushSender
{
    public function __construct(private PushProvidersRegistry $providersRegistry)
    {
    }

    /**
     * @throws SenderUnexpectedException
     */
    public function send(NotificationVO $notificationVO, PushVO $pushVO): void
    {
        $providers = $this->providersRegistry->getProviders();
        foreach ($providers as $provider) {
            if ($provider->send(
                $pushVO->getToken(),
                $notificationVO->getTitle(),
                $notificationVO->getBody()
            )) {
                return;
            }
        }

        throw new SenderUnexpectedException('push sender');
    }
}
