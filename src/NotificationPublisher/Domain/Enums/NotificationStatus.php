<?php

namespace App\NotificationPublisher\Domain\Enums;

enum NotificationStatus: string
{
    case READY = 'ready';
    case QUEUED = 'queued';
    case SENT = 'sent';
    case FAILED = 'failed';
}
