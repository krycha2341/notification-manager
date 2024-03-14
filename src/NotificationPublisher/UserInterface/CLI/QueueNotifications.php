<?php

namespace App\NotificationPublisher\UserInterface\CLI;

use App\NotificationPublisher\Application\Services\NotificationsService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsCommand(
    name: 'notifications:queue',
    description: 'Send all notification or specify ID',
    aliases: ['notifications:queue']
)]
class QueueNotifications extends Command
{
    // todo crontab
    public function __construct(
        readonly private NotificationsService $notificationsService,
        readonly private MessageBusInterface $messageBus
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument(
            'id',
            InputArgument::OPTIONAL,
            'ID of notification to send'
        );
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $notificationsToQueue = $this->notificationsService->getNotificationsToQueue(
            $input->getArgument('id')
        );

        foreach ($notificationsToQueue as $notification) {
            $this->messageBus->dispatch($notification);
        }

        return  Command::SUCCESS;
    }
}
