<?php namespace App\Packages\Courier;

use Tapklik\Courier\Exceptions\CourierConfigurationException;


/**
 * Class Validate
 * @package App\Packages\Courier
 */
class Validate
{

	/**
	 * @param array $config
	 * @return bool
	 */
	public static function config(array $config)
	{
		collect($config)->each(function ($item, $index) use ($config) {
			(new self)
				->_checkRequiredKeysArePresent($config)
				->_checkForInvalidKeys($index)
				->_checkVarTypeMatches($index, $item);
		});

		return true;
	}

	/**
	 * @param array $config
	 * @return $this
	 */
	private function _checkRequiredKeysArePresent(array $config)
	{
		collect(Structure::SKELETON)->each( function ($item, $index) use ($config) {
			if(!array_key_exists($index, $config))
				throw new CourierConfigurationException(sprintf('Key %s must be present', $index));
		});

		return $this;
	}

	/**
	 * @param string $key
	 * @return $this
	 * @throws CourierConfigurationException
	 */
	private function _checkForInvalidKeys(string $key)
	{
		if (!array_key_exists($key, Structure::SKELETON))
			throw new CourierConfigurationException(sprintf('Key %s is invalid', $key));

		return $this;
	}

	/**
	 * @param string $index
	 * @param $item
	 * @return $this
	 * @throws CourierConfigurationException
	 */
	private function _checkVarTypeMatches(string $index, $item)
	{
		if (gettype($item) != Structure::SKELETON[$index]['type'])
			throw new CourierConfigurationException(sprintf('Key %s must be of type %s', $index, Structure::SKELETON[$index]['type']));

		return $this;
	}
}