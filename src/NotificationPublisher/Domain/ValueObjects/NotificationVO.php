<?php

namespace App\NotificationPublisher\Domain\ValueObjects;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;

readonly class NotificationVO
{
    /**
     * @param ArrayCollection<EmailVO> $emails
     * @param ArrayCollection<SMSVO> $sms
     * @param ArrayCollection<PushVO> $pushes
     */
    public function __construct(
        private int $id,
        private int $userId,
        private string $title,
        private string $body,
        private ArrayCollection $emails,
        private ArrayCollection $sms,
        private ArrayCollection $pushes,
        private DateTime $createdAt,
        private DateTime $updatedAt
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function getEmails(): ArrayCollection
    {
        return $this->emails;
    }

    public function getSms(): ArrayCollection
    {
        return $this->sms;
    }

    public function getPushes(): ArrayCollection
    {
        return $this->pushes;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }
}
