<?php namespace App\Http\Controllers;

use App\Invoice;
use App\Account;
use App\BankerMain;
use Carbon\Carbon;
use Ramsey\Uuid\Uuid;
use App\Transformers\InvoiceTransformer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Notification;
use App\User;
use App\Notifications\CreateInvoice;
use App\Notifications\MakePayment;
use App\Http\Requests\MailRequest;
use Aws\Ses\Exception\SesException;
use Aws\Ses\SesClient;

class InvoicesController extends Controller
{
    private function _createBankerMain(Invoice $invoice, Account $account) {
        $banker = [
        'uuid'           => Uuid::uuid1(),
        'updated_at'     => Carbon::now(),
        'debit'          => 0,
        'credit'         => $invoice->offer_amount,
        'description'    => $invoice->payment_method,
        'invoice_id'     => $invoice->invoice_id,
        'transaction_id' => '',
        'type'           => 'billing',
        'mainable_type'  => 'App\Account',
        'mainable_id'    => $account->id
        ];

        return BankerMain::create($banker);
    }

    private function _getInvoiceId($id) {
        $invoices = Invoice::all();
        $highest = 0;
        for($i = 0; $i < count($invoices); $i++){
            if($highest < intval(substr($invoices[$i]->invoice_id, -3))) {
                $highest = intval(substr($invoices[$i]->invoice_id, -3));
            }
        }
        $highest++;
        if($highest / 10 < 1) $ending_id = '00' . $highest;
        if($highest / 10 >= 1) $ending_id = '0' . $highest;
        if($highest / 100 >= 1) $ending_id = $highest;
        return 'T' . date("Y") . $ending_id;
    }

    public function index($id) {
        try {
            $invoices = Invoice::findByAccountId($id);
            return $this->collection($invoices, new InvoiceTransformer);
        } catch (ModelNotFoundException $e) {
            return $this->error(Response::HTTP_NOT_FOUND, $e->getMessage());
        }
    }

    public function show($id, $offer_id) {
        try {
            $invoice = Invoice::findById($offer_id)[0];
            return $this->item($invoice, new InvoiceTransformer);
        } catch (ModelNotFoundException $e) {
            return $this->error(Response::HTTP_NOT_FOUND, $e->getMessage());
        }
    }

    public function store(Request $request, $id) {
        try {
            $account = Account::findByUuId($id);
            $payload = [
                'account_id'  => $id,
                'offer_amount' => request('amount'),
                'offer_date' => request('date'),
                'vat' => $account->billing_vat,
                'currency' => $account->currency
            ];
            $invoice = Invoice::create($payload);
            return $this->item($invoice, new InvoiceTransformer);
        } catch (\Exception $e) {
            return $this->error(Response::HTTP_BAD_REQUEST, $e->getMessage());
        }        
    }

    public function update(Request $request, $id, $offer_id) {
        try {
            $invoice = Invoice::findById($offer_id)[0];
            $account = Account::findByUuId($id);
            $req_input = $request->input();
            $users = User::findByAccountId($account->id);
            if($request->input()['action'] == 'make_invoice') {
                $invoice_id = self::_getInvoiceId($id);
                $invoice->invoice_id = $invoice_id;
                $invoice->invoice_date = $req_input['date'];
                $invoice->invoice_due = date('Y-m-d H:i:s', strtotime($req_input['date']. ' + '.$account->billing_payment_term.' days'));
                $banker = self::_createBankerMain($invoice, $account);
                $invoice->banker_transaction_id = $banker->uuid;
                Notification::send($users, new CreateInvoice($invoice->offer_amount / 1000000));
                $this->sendCreateInvoiceMail($invoice);
            }
            else if($req_input['action'] == 'settle_payment') {
                $invoice->paid = $req_input['paid'];
                $invoice->payment_date = $req_input['date'];
                $invoice->payment_method = $req_input['method'];
                $invoice->description = $req_input['description'];
                $invoice->transaction_id = $req_input['transaction_id'];
                Notification::send($users, new MakePayment($invoice->invoice_id)); 
            }
            else {
                unset($req_input['action']);
                $invoice->update($req_input);
            }
            $invoice->save();
            return $this->item($invoice, new InvoiceTransformer);
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

    private function sendCreateInvoiceMail($invoice) {
        $ses = new SesClient([
            'version'     => env('AWS_VERSION'),
            'region'      => env('AWS_REGION_US'),
            'credentials' => [
                'key'    => env('AWS_ACCESS_KEY'),
                'secret' => env('AWS_SECRET_KEY')
            ]
        ]);

        try {
            $result = $ses->sendEmail([
                'Source' => 'robot@tapklik.com',
                'Destination' => [
                    'ToAddresses' => ['emir.s@tapklik.com']
                ],
                'Message' => [
                    'Subject' => [
                        'Data' => 'New invoice'
                    ],
                    'Body' => [
                        'Text' => [
                            'Data' => 'A new invoice of $' . $invoice->offer_amount / 1000000 . ' has been created with an ID: ' . $invoice->invoice_id . '.'
                        ]
                    ],
                ],
            ]);
            return response(['data' => [
                'id' => $result->get('MessageId')]
            ]);
        } catch (SesException $e) {
            return $this->error(Response::HTTP_BAD_REQUEST, 'Error sending an email', $e->getMessage());
            
        }
    }
}