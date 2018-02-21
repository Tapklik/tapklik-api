<?php namespace Tapklik\Banker;

use App\Contracts\Bankerable;

/**
 * Class InvoiceIdGenerator
 *
 * @package \\${NAMESPACE}
 */
class InvoiceIdGenerator
{
    public function generate(Bankerable $banker, $relationShip)
    {
        $lastBanker = $banker->{$relationShip}()->get();
dd($lastBanker);
        dd($this->_generateInvoice($lastBanker));
    }

    private function _generateInvoice($banker = null)
    {
    	dd($banker);

    	    if($banker == null) return 'TK-' . date('Ymd', time()) . '-001';

    	    $lastBanker = str_replace('TK-', '', $banker->invoice_id);

    	    return $lastBanker;
    }
}
