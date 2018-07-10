<?php namespace App\Observers;

use App\Invoice;

/**
 * Class InvoiceObserver
 *
 * @package \App\Observers
 */
class InvoiceObserver extends BaseObserver
{

    /**
     * @param \App\Invoice $invoice
     */
    public function created(Invoice $invoice)
    {
        // Set defaults
        $uuid          = 'tk-' . self::generateId(10);
        $invoice->offer_id = $uuid;
        $invoice->save();
    }
}
