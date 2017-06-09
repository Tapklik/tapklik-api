<?php namespace App;

class Creative extends ModelSetup
{
    // Methods

    public static function findByUuId(string $uuid) {

        return self::where(['uuid' => $uuid]);
    }

    public function folder() {

        return $this->belongsTo(Folder::class);
    }
}
