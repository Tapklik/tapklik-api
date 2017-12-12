<?php namespace App\Observers;

use Tapklik\Identicus\Generator;

/**
 * Class BaseObserver
 *
 * @package \App\Observers
 */
class BaseObserver
{
    protected function checkIdDoesNotExist(string $id, $model)
    {
        $item = $model::findByUuId($id);

        return ($item->count() > 0) ? true : false;
    }

    protected static function generateId(int $length = 13)
    {
        $generator = new Generator();

        return $generator->generateUniqueId($length);
    }
}
