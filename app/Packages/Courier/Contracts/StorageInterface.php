<?php namespace App\Packages\Courier\Contracts;


interface StorageInterface
{
	public function save() : bool;
}