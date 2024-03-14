<?php

namespace App\NotificationPublisher\Infrastructure\Database\Entities;

use App\NotificationPublisher\Domain\Enums\NotificationStatus;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\HasLifecycleCallbacks]
class Email
{
    public function __construct(
        #[ORM\Column(type: 'string', length: 255)]
        private string $email,
        #[ORM\Column(type: 'string', length: 35)]
        private string $status,
        #[ORM\Id]
        #[ORM\GeneratedValue]
        #[ORM\Column]
        private ?int $id = null,
        #[ORM\ManyToOne(targetEntity: Notification::class, inversedBy: 'emails')]
        #[ORM\JoinColumn(name: 'notification_id', referencedColumnName: 'id', onDelete: 'cascade')]
        private ?Notification $notification = null,
        #[ORM\Column(type: 'datetime')]
        private ?DateTime $createdAt = null,
        #[ORM\Column(type: 'datetime')]
        private ?DateTime $updatedAt = null
    ) {
    }

    public function getNotification(): Notification
    {
        return $this->notification;
    }

    public function setNotification(Notification $notification): self
    {
        $this->notification = $notification;

        return $this;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getStatus(): NotificationStatus
    {
        return NotificationStatus::tryFrom($this->status);
    }

    public function setStatus(NotificationStatus $status): self
    {
        $this->status = $status->value;

        return $this;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    #[ORM\PrePersist]
    public function setCreatedAt(): self
    {
        $this->createdAt = new DateTime();

        return $this;
    }

    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function setUpdatedAt(): self
    {
        $this->updatedAt = new DateTime();

        return $this;
    }
}
