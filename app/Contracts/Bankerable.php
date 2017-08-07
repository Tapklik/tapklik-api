<?php namespace App\Contracts;

interface Bankerable
{
    public function main();

    public function flight();

    public function spend();
}
