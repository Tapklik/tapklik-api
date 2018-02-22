<?php namespace Tapklik\Banker;

use App\Contracts\Bankerable;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * Class InvoiceIdGenerator
 *
 * @package \\${NAMESPACE}
 */
class InvoiceIdGenerator
{
    public function generate(Bankerable $banker, $relationShip)
    {

        $lastBanker = $banker->first();

        return $this->_generateInvoice($lastBanker->{$relationShip});
    }

    private function _generateInvoice($banker = null)
    {

		$count = $banker->count();

    	    if(!$count) return 'TK-' . date('Ymd', time()) . '-001';


    	    return  'TK-' . date('Ymd', time()) . '-00' . $count++;
    }
}
