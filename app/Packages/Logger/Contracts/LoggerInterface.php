<?php namespace Tapklik\Logger\Contracts;

interface LoggerInterface
{
    public function logAction(int $accountId, string $actionTaken);

    public function retrieve(int $accountId);
}
