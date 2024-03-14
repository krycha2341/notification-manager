<?php

namespace App\NotificationPublisher\Application\DataTransferObjects;

readonly class EmailDispatchDTO
{
    public function __construct(
        private string $email,
        private string $title,
        private string $body,
        private ?array $attachments = null,
        private ?array $cc = null,
        private ?array $bcc = null
    ) {
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function getAttachments(): ?array
    {
        return $this->attachments;
    }

    public function getCc(): ?array
    {
        return $this->cc;
    }

    public function getBcc(): ?array
    {
        return $this->bcc;
    }
}
