<?php namespace Tapklik\Logger\Contracts;

interface LoggerInterface
{
    public function logAction(int $userId, string $actionTaken);
}
