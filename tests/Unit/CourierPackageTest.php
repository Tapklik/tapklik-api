<?php namespace Tests\Unit;

use App\Packages\Courier\Validate;
use Tests\TestCase;

class CourierPackageTest extends TestCase
{
	/** @test */
	public function validator_can_validate_config_file_structure()
	{
		$config = [
			'service'    => ['onead'],
			'message'    => 'test message',
			'users'      => [],
			'created_at' => (string) time()
		];

		$validator = Validate::config($config);

		$this->assertTrue($validator);
	}

	/**
	 * @test
	 * @expectedException Tapklik\Courier\Exceptions\CourierConfigurationException
	 * @expectedExceptionMessage Key created_at must be present
	 */
	public function validator_should_throw_an_exception_on_missing_keys()
	{
		// Omit created_at
		$config = [
			'service' => ['onead'],
			'message' => 'test message',
			'users'   => [],
		];

		Validate::config($config);
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
			'service'    => 'onead',
			'message'    => 'test message',
			'users'      => [],
			'created_at' => (string) 123456
		];

		Validate::config($config);
	}
}
