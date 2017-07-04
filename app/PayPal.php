<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Api\PaymentExecution;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use App\Product;
use App\Invoice;
use Carbon\Carbon;

class PayPal extends Model
{
    private $apiContext;
    private $identify;
    private $product;

    public function __construct(Product $product)
    {
        $this->apiContext = new ApiContext(
            new OAuthTokenCredential(config('paypal.client_id'), config('paypal.secret_id'))
        );
        $this->apiContext->setConfig(config('paypal.settings'));
        $this->identify = bcrypt(uniqid(date('YmdHis')));
        $this->product = $product;
    }

    public function generate()
    {
        $currentTime = Carbon::now();
        
        $payment = new Payment();
        $payment->setIntent("order")
            ->setPayer($this->payer())
            ->setRedirectUrls($this->redirectsUrl())
            ->setTransactions([$this->transaction()]);
        try {
            $payment->create($this->apiContext);
            $paymentId = $payment->getId();
            Invoice::create([
                'price'         => $this->product->price,
                'date'          => $currentTime,
                'status'        => '',
                'product_id'    => $this->product->id,
                'payment_type'  => 'PayPal',
                'payment'       => $paymentId
            ]);
        } catch (Exception $ex) {
            exit(1);
        }
        $approvalUrl = $payment->getApprovalLink();
        return $approvalUrl;
    }

    public function payer()
    {
        $payer = new Payer();
        $payer->setPaymentMethod("paypal");
        return $payer;
    }

    // public function details()
    // {
    //     $details = new Details();
    //     $details->setSubtotal($this->product->price);
        
    //     //STEUERN

    //     // $details->setShipping(1.2)
    //     //     ->setTax(1.3)
    //     //     ->setSubtotal(17.50);
         
    //     return $details;
    // }

    public function amount()
    {
        $amount = new Amount();
        $amount->setCurrency("EUR")->setTotal($this->product->price);
        return $amount;
    }

    public function transaction()
    {
        $transaction = new Transaction();
        $transaction->setAmount($this->amount())
            ->setDescription("Bahnes Shop kauf")
            ->setInvoiceNumber($this->identify);
        return $transaction;
    }

    public function redirectsUrl()
    {
        $baseRoute = route('return.paypal');
        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl("{$baseRoute}?success=true")
            ->setCancelUrl("{$baseRoute}?success=false");
        return $redirectUrls;
    }
    
    public function execute($paymentId, $token, $payerID)
    {
        $payment = Payment::get($paymentId, $this->apiContext);
        if( $payment->getState() != 'approved' ) {
            $execution = new PaymentExecution();
            $execution->setPayerId($payerID);
            $result = $payment->execute($execution, $this->apiContext);
            return $result->getState();
        }
        return $payment->getState();
    }
}