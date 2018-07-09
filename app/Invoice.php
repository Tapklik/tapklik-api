<?php namespace App;

/**
 * Class Invoice
 *
 * @package App
 */
/**
 * Class Invoice
 *
 * @package App
 */
class Invoice extends ModelSetup
{
	public static function findByAccountId($id) {		
		return Invoice::selectRaw('invoices.*')
		->where(['account_id' => $id])
		->get();
	}
}

