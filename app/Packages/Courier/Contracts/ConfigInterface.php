<?php namespace App\Packages\Courier\Contracts;

use Carbon\Carbon;

/**
 * Interface ConfigInterface
 * @package App\Packages\Courier\Contracts
 */
interface ConfigInterface
{
	public function getKey(string $key);

	public function getService(): string;

	public function getMessage(): string;

	public function getUsers(): array;

	public function getTimestamp(): Carbon;

	public function keyExists(string $key): bool;
}