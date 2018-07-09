<?php namespace App\Http\Controllers;

use App\Invoice;
use App\Transformers\InvoiceTransformer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class InvoicesController extends Controller
{
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
                'offer_id' => request('offer_id'),
                'offer_amount' => request('offer_amount'),
                'banker_transaction_id' => request('banker')
            ];
            $invoice = Invoice::create($payload);
        } catch (\Exception $e) {
            return $this->error(Response::HTTP_BAD_REQUEST, $e->getMessage());
        }
        
    }

    public function update(Request $request, $id, $offer_id) {
        $invoice = Invoice::findById($offer_id)[0];
        $invoice->update($request->input());
        $invoice->save();
    }

    public function delete($id, $offer_id) {
        $invoice = Invoice::findById($offer_id)[0];
        $invoice->delete();
    }
}