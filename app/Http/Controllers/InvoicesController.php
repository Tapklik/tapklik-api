<?php namespace App\Http\Controllers;

use App\Invoice;
use App\Transformers\InvoiceTransformer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class InvoicesController extends Controller
{
    public function index($id) {
        $invoices = Invoice::findByAccountId($id);
        return $this->collection($invoices, new InvoiceTransformer);

    }

    public function show() {

    }

    public function store(Request $request) {
        
    }

    public function update() {

    }

    public function delete() {

    }
}