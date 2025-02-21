<?php

namespace Xelbot\Telegram\Command;

use Xelbot\Telegram\Entity\Message;
use Xelbot\Telegram\Exception\AccessDeniedTelegramException;

abstract class AbstractAdminCommand
{
    /**
     * @var int
     */
    private $adminId;

    /**
     * @param int $adminId
     */
    public function setAdminId(int $adminId)
    {
        $this->adminId = $adminId;
    }

    /**
     * @param Message $message
     */
    abstract protected function executeCommand(Message $message): void;

    /**
     * @param Message $message
     *
     * @throws AccessDeniedTelegramException
     */
    public function execute(Message $message): void
    {
        if ($message->getFrom() === null || $message->getFrom()->getId() != $this->adminId) {
            $userId = $message->getFrom() ? $message->getFrom()->getId() : 'null';

            throw new AccessDeniedTelegramException("Access Denied for user ID:{$userId}");
        }

        $this->executeCommand($message);
    }
}
