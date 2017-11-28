<?php namespace App;

class Log extends ModelSetup
{

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public static function findByAccountId($id)
    {
        return self::where(['account_id' => $id])->get();
    }
}
