<?php namespace App\Packages\Courier;

use App\Packages\Courier\Contracts\ConfigInterface;
use Carbon\Carbon;
use Tapklik\Courier\Exceptions\CourierConfigurationException;

class Config implements ConfigInterface
{
	private $_config = false;

	public function __construct(array $config = [])
	{
		$this->_config = $config;
	}

	public function getKey(string $key)
	{
		if(!$this->keyExists($key))
			throw new CourierConfigurationException(sprintf('The key %s does not exist.', $key));

		return $this->_config[$key];
	}

	public function getService(): string
	{
		return $this->getKey('service');
	}

	public function getMessage(): string
	{
		return $this->getKey('message');
	}

	public function getUsers(): array
	{
		return $this->getKey('users');
	}

	public function getTimestamp(): Carbon
	{
		return Carbon::createFromTimestamp($this->getKey('created_at'));
	}

	public function keyExists(string $key): bool
	{
		return array_key_exists($key, $this->_config);
	}
}