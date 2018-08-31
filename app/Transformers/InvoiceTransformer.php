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
                'offer_amount' => $invoice->offer_amount,
                'description' => $invoice->description,
                'vat' => $invoice->vat,
                'currency' => $invoice->currency,
                'transaction_id' => $invoice->transaction_id
            ];
        }
        else if($invoice->paid == 1) {
            $result = [
                'invoice_id'=>$invoice->invoice_id,
                'offer_id'=>$invoice->offer_id,
                'invoice_date' => $invoice->invoice_date,
                'invoice_due' => $invoice->invoice_due,
                'paid' => $invoice->paid,
                'banker_transaction_id' => $invoice->banker_transaction_id,
                'payment_date' => $invoice->payment_date,
                'payment_method' => $invoice->payment_method,
                'amount' => $invoice->offer_amount,
                'vat' => $invoice->vat,
                'currency' => $invoice->currency,
                'description' => $invoice->description,
                'transaction_id' => $invoice->transaction_id
            ];
        }
        else {
            $result = [
                'invoice_id'=>$invoice->invoice_id,
                'offer_id'=>$invoice->offer_id,
                'invoice_date' => $invoice->invoice_date,
                'invoice_due' => $invoice->invoice_due,
                'paid' => $invoice->paid,
                'banker_transaction_id' => $invoice->banker_transaction_id,
                'amount' => $invoice->offer_amount,
                'vat' => $invoice->vat,
                'currency' => $invoice->currency,
                'description' => $invoice->description,
                'transaction_id' => $invoice->transaction_id
            ];
        }
        return $result;
    }
}