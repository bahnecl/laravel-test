<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Product;
use App\PayPal;
use App\Invoice;

use Illuminate\Http\Request;

class PaymentController extends Controller
{

    public function create(Request $request, $id)
    {
        $product = Product::find($id);
        $paypay = new PayPal($product);
        return redirect()->away($paypay->generate());
    }

    public function returnPayPal(Request $request, Invoice $invoice)
    {
        $success    = ($request->success == 'true') ? true : false;
        $paymentId  = $request->paymentId;
        $token      = $request->token;
        $payerID    = $request->PayerID;

        $product = new Product;
        $invoice = new Invoice;
        $paypal = new PayPal($product);
        $response = $paypal->execute($paymentId, $token, $payerID);

        if( $response == 'approved' ){
            $invoice->where('payment', $paymentId)->update(['status' => 'approved']);
            return redirect()->route('home');
        } else {
            dd('Fehlgeschlagen!');
        }
    }
}
