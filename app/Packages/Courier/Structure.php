<?php namespace App\Packages\Courier;


class Structure
{
	/**
	 * Required JSON structure
	 */
	const SKELETON = [
		'service'   => [
			'type'     => 'array',
			'required' => true
		],
		'message'   => [
			'type'     => 'string',
			'required' => true
		],
		'created_at' => [
			'type'     => 'string',
			'required' => true
		],
		'users'     => [
			'type'     => 'array',
			'required' => true
		]
	];
}