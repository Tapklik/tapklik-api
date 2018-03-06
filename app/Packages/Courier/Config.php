<?php namespace App\Packages\Courier;


class Config
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
}