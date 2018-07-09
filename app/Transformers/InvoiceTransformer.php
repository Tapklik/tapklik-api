<?php namespace App\Transformers;

use App\Invoice;
use League\Fractal\TransformerAbstract;

/**
 * Class InvoiceTransformer
 *
 * @package \app\Transformers
 */
class InvoiceTransformer extends TransformerAbstract
{
    public function transform(Invoice $invoice)
    {

        return [
            'id'         => $invoice->offer_id,
	        'offer_date' => $invoice->offer_date,
            'offer_amount' => $invoice->offer_amount
        ];
    }
}