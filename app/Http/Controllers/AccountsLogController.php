<?php namespace App\Http\Controllers;

use App\Transformers\LogTransformer;
use Tapklik\Logger\Exceptions\LoggerException;
use Tapklik\Logger\Providers\MySqlLoggerProvider;

class AccountsLogController extends Controller
{
    public function index()
    {

        try {
            $logger = new MySqlLoggerProvider();
            $logs = $logger->retrieve($this->getJwtUserClaim('accountId'));

            return $this->collection($logs, new LogTransformer);
        } catch (LoggerException $e) {
            return $this->error($e->getCode(), $e->getMessage());

        }
    }
}
