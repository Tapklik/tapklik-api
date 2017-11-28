<?php namespace Tapklik\Logger\Providers;

use App\Log;
use Tapklik\Logger\Contracts\LoggerInterface;
use Tapklik\Logger\Exceptions\LoggerException;

class MySqlLoggerProvider implements LoggerInterface
{

    public function logAction(int $userId, string $actionTaken)
    {
        try {
            Log::create([
                'user_id' => $userId,
                'action'  => $actionTaken
            ]);
        } catch (\Exception $e) {
            throw new LoggerException($e->getMessage(), $e->getCode());
        }
    }
}
