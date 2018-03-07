<?php namespace App\Packages\Courier\Contracts;


interface ServiceInterface
{
	public function publish(): int;
}