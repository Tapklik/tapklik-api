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
        $result = [];
        if($invoice->invoice_id == null) {
            $result = [
                'offer_id'=> $invoice->offer_id,
                'offer_date' => $invoice->offer_date,
                'offer_amount' => $invoice->offer_amount
            ];
        }
        else if($invoice->paid == 1) {
            $result = [
                'invoice_id'=>$invoice->invoice_id,
                'invoice_date' => $invoice->invoice_date,
                'invoice_due' => $invoice->invoice_due,
                'paid' => $invoice->paid,
                'banker_transaction_id' => $invoice->banker_transaction_id,
                'payment_date' => $invoice->payment_date,
                'payment_method' => $invoice->payment_method
            ];
        }
        else {
            $result = [
                'invoice_id'=>$invoice->invoice_id,
                'invoice_date' => $invoice->invoice_date,
                'invoice_due' => $invoice->invoice_due,
                'paid' => $invoice->paid,
                'banker_transaction_id' => $invoice->banker_transaction_id
            ];
        }
        return $result;
    }
}