<?php

namespace App\NotificationPublisher\Application\DataTransferObjects;

readonly class SMSDispatchDTO
{
    public function __construct(
        private string $phoneNumber,
        private string $title,
        private string $body
    ) {
    }

    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
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
