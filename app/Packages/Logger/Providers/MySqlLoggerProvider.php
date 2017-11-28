<?php namespace Tapklik\Logger\Providers;

use App\Log;
use App\Transformers\LogTransformer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Tapklik\Logger\Contracts\LoggerInterface;
use Tapklik\Logger\Exceptions\LoggerException;

class MySqlLoggerProvider implements LoggerInterface
{

    public function logAction(int $accountId, string $actionTaken)
    {
        try {
            Log::create([
                'user_id' => $accountId,
                'action'  => $actionTaken
            ]);
        } catch (\Exception $e) {
            throw new LoggerException($e->getMessage(), $e->getCode());
        }
    }

    public function retrieve(int $accountId)
    {
        try {
            $logs = Log::findByAccountId($accountId);

            return $logs;
        } catch (ModelNotFoundException $e) {

            throw new LoggerException($e->getMessage(), $e->getCode());
        }
    }


}
