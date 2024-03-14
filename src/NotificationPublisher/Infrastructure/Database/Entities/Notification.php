<?php

namespace App\NotificationPublisher\Infrastructure\Database\Entities;

use App\NotificationPublisher\Infrastructure\Database\Repositories\NotificationsRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NotificationsRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Notification
{
    public function __construct(
        #[ORM\Column]
        private int $userId,
        #[ORM\Column(type: 'string', length: 255)]
        private string $title,
        #[ORM\Column(type: 'text')]
        private string $body,
        #[ORM\Id]
        #[ORM\GeneratedValue]
        #[ORM\Column]
        private ?int $id = null,
        #[ORM\OneToMany(mappedBy: 'notification', targetEntity: Email::class, cascade: ['persist', 'remove'])]
        private ?Collection $emails = null,
        #[ORM\OneToMany(mappedBy: 'notification', targetEntity: SMS::class, cascade: ['persist', 'remove'])]
        private ?Collection $sms = null,
        #[ORM\OneToMany(mappedBy: 'notification', targetEntity: Push::class, cascade: ['persist', 'remove'])]
        private ?Collection $pushes = null,
        #[ORM\Column(type: 'datetime')]
        private ?DateTime $createdAt = null,
        #[ORM\Column(type: 'datetime')]
        private ?DateTime $updatedAt = null
    ) {
        $this->emails = new ArrayCollection();
        $this->pushes = new ArrayCollection();
        $this->sms = new ArrayCollection();
    }

    public function setUserId(int $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    public function getUserId(): int
    {
        return $this->userId;
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

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function setBody(string $body): self
    {
        $this->body = $body;

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

    public function getEmails(): Collection
    {
        return $this->emails;
    }

    public function setEmails(Collection $emails): self
    {
        $this->emails = $emails;

        return $this;
    }

    public function addEmail(Email $email): self
    {
        if (!$this->emails->contains($email)) {
            $this->emails->add($email);
            $email->setNotification($this);
        }

        return $this;
    }

    public function getSms(): Collection
    {
        return $this->sms;
    }

    public function setSms(Collection $sms): self
    {
        $this->sms = $sms;

        return $this;
    }

    public function addSms(SMS $sms): self
    {
        if (!$this->sms->contains($sms)) {
            $this->sms->add($sms);
            $sms->setNotification($this);
        }

        return $this;
    }

    public function getPushes(): Collection
    {
        return $this->pushes;
    }

    public function setPushes(Collection $pushes): self
    {
        $this->pushes = $pushes;

        return $this;
    }

    public function addPush(Push $push): self
    {
        if (!$this->pushes->contains($push)) {
            $this->pushes->add($push);
            $push->setNotification($this);
        }

        return $this;
    }
}
