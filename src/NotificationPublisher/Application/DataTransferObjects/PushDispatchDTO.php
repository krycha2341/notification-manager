<?php

namespace App\NotificationPublisher\Application\DataTransferObjects;

readonly class PushDispatchDTO
{
    public function __construct(
        private string $deviceToken,
        private string $title,
        private string $body
        // more if needed e.g. sound, force, wake up etc
    ) {
    }

    public function getDeviceToken(): string
    {
        return $this->deviceToken;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getBody(): string
    {
        return $this->body;
    }
}
