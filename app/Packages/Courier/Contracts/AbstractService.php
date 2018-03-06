<?php namespace App\Packages\Courier\Contracts;

use App\Packages\Courier\Validate;

abstract class AbstractService implements ServiceInterface
{

	protected $config = [];

	public function __construct(array $config = [])
	{
		try {
			Validate::config($config);

			$this->config = $config;
		} catch (CourierConfigurationException $e) {

		}
	}

	public function getConfig()
	{
		return $this->config;
	}
}