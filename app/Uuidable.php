<?php

namespace App;

interface Uuidable
{
    public static function findByUuId(string $uuid);
}
