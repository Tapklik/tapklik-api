<?php namespace App\Packages\Courier\Contracts;


abstract class AbstractCourier
{
	protected $config = [];

	public function __construct(array $config)
	{
		Validate::config($config);

		$this->config = new Config($config);
	}
}