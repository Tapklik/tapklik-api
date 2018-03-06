<?php namespace App\Packages\Courier;

use Tapklik\Courier\Exceptions\CourierConfigurationException;


/**
 * Class ConfigValidator
 * @package App\Packages\Courier
 */
class ConfigValidator
{
	/**
	 * Required JSON structure
	 */
	const STRUCTURE = [
		'service'   => [
			'type'     => 'array',
			'required' => true
		],
		'message'   => [
			'type'     => 'string',
			'required' => true
		],
		'timestamp' => [
			'type'     => 'integer',
			'required' => true
		],
		'users'     => [
			'type'     => 'array',
			'required' => true
		]
	];

	/**
	 * @param array $config
	 * @return bool
	 */
	public static function validate(array $config)
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
		collect(self::STRUCTURE)->each( function ($item, $index) use ($config) {
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
		if (!array_key_exists($key, self::STRUCTURE))
			throw new CourierConfigurationException(sprintf('Key %s is invalid', $index));

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
		if (gettype($item) != self::STRUCTURE[$index]['type'])
			throw new CourierConfigurationException(sprintf('Key %s must be of type %s', $index, self::STRUCTURE[$index]['type']));

		return $this;
	}
}