<?php

namespace App\NotificationPublisher\Domain\Enums;

enum NotificationType: string
{
    case SMS = 'sms';
    case EMAIL = 'email';
    case PUSH = 'push';
}
