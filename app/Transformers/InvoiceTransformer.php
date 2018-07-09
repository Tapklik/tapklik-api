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
        return $invoice;
    }
}