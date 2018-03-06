<?php namespace App\Packages\Courier;

class Courier
{
	private $_config = [];

	public function __construct(array $config)
	{
		Validate::config($config);

		$this->_config = new Config($config);
	}

	public function dispatch() {

		$this->_config->getService()->each(function ($service) {
			self::factory($service, $this->_config)->publish();
		});
	}
}