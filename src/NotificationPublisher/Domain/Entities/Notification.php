<?php

namespace App\NotificationPublisher\Domain\Entities;

use Doctrine\Common\Collections\ArrayCollection;

readonly class Notification
{
    /**
     * @param ArrayCollection<int, Email> $emails
     * @param ArrayCollection<int, SMS>   $sms
     * @param ArrayCollection<int, Push>  $pushes
     */
    public function __construct(
        private int $userId,
        private string $title,
        private string $body,
        private ArrayCollection $emails,
        private ArrayCollection $sms,
        private ArrayCollection $pushes
    ) {
    }

    public function getSms(): ArrayCollection
    {
        return $this->sms;
    }

    public function getPushes(): ArrayCollection
    {
        return $this->pushes;
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
}
