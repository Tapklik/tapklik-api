<?php namespace App\Packages\Courier\Contracts;


interface RetrievableInterface
{
	public function getForUserId(int $id);

	public function getForUserUuId(string $uuid);
}