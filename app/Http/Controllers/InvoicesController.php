<?php namespace App\Http\Controllers;

use App\Invoice;
use App\Transformers\InvoiceTransformer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class InvoicesController extends Controller
{
    private function _getLastInvoiceNumber($id) {
        $invoices = Invoice::findByAccountId($id);
        $highest = 0;
        for($i = 0; $i < count($invoices); $i++){
            if($highest < intval(substr($invoices[$i]->invoice_id, -3))) {
                $highest = intval(substr($invoices[$i]->invoice_id, -3));
            }
        }
        return $highest;
    }

    public function index($id) {
        try {
            $invoices = Invoice::findByAccountId($id);
            return $this->collection($invoices, new InvoiceTransformer);
        } catch (ModelNotFoundException $e) {
            return $this->error(Response::HTTP_NOT_FOUND, $e->getMessage());
        }
    }

    public function show() {

    }

    public function store(Request $request) {
        try {
            $payload = [
                'account_id'  => request('account_id'),
                'offer_amount' => request('offer_amount'),
                'banker_transaction_id' => request('banker')
            ];
            $invoice = Invoice::create($payload);
        } catch (\Exception $e) {
            return $this->error(Response::HTTP_BAD_REQUEST, $e->getMessage());
        }        
    }

    public function update(Request $request, $id, $offer_id) {
        try {
            $invoice = Invoice::findById($offer_id)[0];
            if($request->input()['invoice'] == 1) {
                $highest = self::_getLastInvoiceNumber($id) + 1;
                if($highest / 10 < 1) $ending_id = '00' . $highest;
                if($highest / 10 >= 1) $ending_id = '0' . $highest;
                if($highest / 100 >= 1) $ending_id = $highest;
                $invoice->invoice_id = 'T' . date("Y") . $ending_id;
            }
            else {
                $invoice->update($request->input());
            }
            $invoice->save();
        } catch (\Exception $e) {
            return $this->error(Response::HTTP_BAD_REQUEST, $e->getMessage());
        }
    }

    public function delete($id, $offer_id) {
        try {
            $invoice = Invoice::findById($offer_id)[0];
            $invoice->delete();
        } catch (\Exception $e) {
            return $this->error(Response::HTTP_BAD_REQUEST, $e->getMessage());
        }
    }
}