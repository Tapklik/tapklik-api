<?php namespace Tests\Unit;

use App\Packages\Courier\ConfigValidator;
use Tapklik\Courier\Exceptions\CourierConfigurationException;
use Tests\TestCase;

class CourierPackageTest extends TestCase
{
	/** @test */
	public function validator_can_validate_config_file_structure()
	{
		$config = [
			'service'   => ['onead'],
			'message'   => 'test message',
			'users'     => [],
			'timestamp' => time()
		];

		$validator = ConfigValidator::validate($config);

		$this->assertTrue($validator);
	}

	/**
	 * @test
	 * @expectedException Tapklik\Courier\Exceptions\CourierConfigurationException
	 * @expectedExceptionMessage Key timestamp must be present
	 */
	public function validator_should_throw_an_exception_on_missing_keys()
	{
		// Omit timestamp
		$config = [
			'service' => ['onead'],
			'message' => 'test message',
			'users'   => [],
		];

		ConfigValidator::validate($config);
	}

	/**
	 * @test
	 * @expectedException Tapklik\Courier\Exceptions\CourierConfigurationException
	 * @expectedExceptionMessage Key service must be of type array
	 */
	public function validator_should_throw_an_exception_on_invalid_type()
	{
		// Service key should be of type array
		$config = [
			'service' => 'onead',
			'message' => 'test message',
			'users'   => [],
			'timestamp' => 123456
		];

		ConfigValidator::validate($config);
	}
}
