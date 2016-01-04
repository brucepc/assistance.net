<?php

namespace Models;

class Bill extends \Eloquent
{
    protected $primaryKey = 'user_id';
    public $timestamps = false;
    
    public function task()
    {
        return $this->belongsTo('Task');
    }
    
    public function makePayment($method, $payment)
    {
        if ($method == 'PayPal') {
            return $this->executePayPal($payment);
        }
    }
    
    public function executePayPal($payment)
    {
        $PayPal             = new Assistance\Payment\PayPal;
        $PayPalMode         = Config::get('billing.paypalmode'); // sandbox or live
        $PayPalApiUsername  = Config::get('billing.paypalapiusername'); //PayPal API Username
        $PayPalApiPassword  = Config::get('billing.paypalapipassword'); //Paypal API password
        $PayPalApiSignature = Config::get('billing.paypalapisignature'); //Paypal API Signature
        $PayPalCurrencyCode = Config::get('billing.paypalcurrencycode'); //Paypal Currency Code
        $PayPalReturnURL    = Config::get('billing.paypalreturnurl'); //Point to process.php page
        $PayPalCancelURL    = Config::get('billing.paypalcancelurl'); //Cancel URL if user clicks cancel
        $orderinfo          = $this->task();
        //Parameters for SetExpressCheckout, which will be sent to PayPal
        $padata             = '&METHOD=SetExpressCheckout' . '&RETURNURL=' . urlencode($PayPalReturnURL) . '&CANCELURL=' . urlencode($PayPalCancelURL) . '&PAYMENTREQUEST_0_PAYMENTACTION=' . urlencode("SALE") . '&PAYMENTREQUEST_0_CUSTOM=' . urlencode($registrationid) . '&LANDINGPAGE=Billing' . '&SOLUTIONTYPE=Sole';
        $i                  = 0;
        $GrandTotal         = 0;
        $totalitemstring    = '';
        foreach ($orderinfo['usd'] as $item) {
            if ($item['quantity'] > 0) {
                $ItemName   = $item['fee']->name;
                $ItemNumber = $item['fee']->id;
                $ItemDesc   = $item['fee']->description;
                $ItemPrice  = $item['fee']->usdvalue;
                $ItemQty    = $item['quantity'];
                $Total      = $ItemQty * $ItemPrice;
                $GrandTotal = $GrandTotal + $Total;
                $itemstring = '&L_PAYMENTREQUEST_0_NAME' . $i . '=' . urlencode($ItemName) . '&L_PAYMENTREQUEST_0_NUMBER' . $i . '=' . urlencode($ItemNumber) . '&L_PAYMENTREQUEST_0_DESC' . $i . '=' . urlencode($ItemDesc) . '&L_PAYMENTREQUEST_0_AMT' . $i . '=' . urlencode($ItemPrice) . '&L_PAYMENTREQUEST_0_QTY' . $i . '=' . urlencode($ItemQty);
                $padata .= $itemstring;
                $totalitemstring .= $itemstring;
                $i++;
            }
        }
        Session::put('totalitemstring', $totalitemstring);
        Session::put('grandtotal', $GrandTotal);
        $padata .= '&NOSHIPPING=1';
        $padata .= '&PAYMENTREQUEST_0_ITEMAMT=' . urlencode($GrandTotal) . '&PAYMENTREQUEST_0_AMT=' . urlencode($GrandTotal) . '&LOCALECODE=GB' . //PayPal pages to match the language on your website.
            '&CARTBORDERCOLOR=FFFFFF' . //border color of cart
            '&ALLOWNOTE=1';
        $paypal               = new PayPal();
        $httpParsedResponseAr = $paypal->PPHttpPost('SetExpressCheckout', $padata, $PayPalApiUsername, $PayPalApiPassword, $PayPalApiSignature, $PayPalMode);
        //Respond according to message we receive from Paypal
        if ("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])) {
            
            //Redirect user to PayPal store with Token received.
            $paypalurl = 'https://www.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=' . $httpParsedResponseAr["TOKEN"] . '';
            return Redirect::to($paypalurl);
            
        } else {
            //Show error message
            echo '<div style="color:red"><b>Error : </b>' . urldecode($httpParsedResponseAr["L_LONGMESSAGE0"]) . '</div>';
            echo '<pre>';
            print_r($httpParsedResponseAr);
            echo '</pre>';
        }
    }
    
    public static function ipn_response($response)
    {
        $transactionid = $response['txn_id'];
        $status        = $response['payment_status'];
        $bill          = Bill::where('checkout_id', '=', $transactionid)->first();
        if (!$bill == NULL) {
            $bill->status = urldecode($status);
            $bill->save();
        } else {
            $bill                  = new Bill;
            $totalamount           = urldecode($response['mc_gross']);
            $registrationid        = $response['custom'];
            $order                 = new Bill;
            $order->registrationid = $registrationid;
            $order->method         = "PayPal";
            $order->currency       = 'USD';
            $order->description    = 'PayPal Order Number: ' . $transactionid;
            $order->amount         = $totalamount;
            $order->checkout_id    = $transactionid;
            $order->status         = ucwords($status);
            $order->save();
        }
        return true;
    }
    
    public static function checkout_response($registrationid, $PayerID, $token)
    {
        
        //we will be using these two variables to execute the "DoExpressCheckoutPayment"
        //Note: we haven't received any payment yet.
        
        $token              = $_GET["token"];
        $payer_id           = $_GET["PayerID"];
        $PayPalMode         = Config::get('billing.paypalmode'); // sandbox or live
        $PayPalApiUsername  = Config::get('billing.paypalapiusername'); //PayPal API Username
        $PayPalApiPassword  = Config::get('billing.paypalapipassword'); //Paypal API password
        $PayPalApiSignature = Config::get('billing.paypalapisignature'); //Paypal API Signature
        $totalitemstring    = Session::get('totalitemstring');
        $GrandTotal         = Session::get('grandtotal');
        if ($totalitemstring == NULL || $GrandTotal == NULL) {
            return Redirect::to('/billing')->with('message', 'Your session has timed out, your card has not been charged, please try again.');
        }
        $padata               = '&TOKEN=' . urlencode($token) . '&PAYERID=' . urlencode($payer_id) . '&PAYMENTREQUEST_0_PAYMENTACTION=' . urlencode("SALE") . $totalitemstring . '&PAYMENTREQUEST_0_AMT=' . urlencode($GrandTotal) . '&PAYMENTREQUEST_0_CUSTOM=' . urlencode($registrationid);
        //We need to execute the "DoExpressCheckoutPayment" at this point to Receive payment from user.
        $paypal               = new PayPal();
        $httpParsedResponseAr = $paypal->PPHttpPost('DoExpressCheckoutPayment', $padata, $PayPalApiUsername, $PayPalApiPassword, $PayPalApiSignature, $PayPalMode);
        // we can retrive transection details using either GetTransactionDetails or GetExpressCheckoutDetails
        // GetTransactionDetails requires a Transaction ID, and GetExpressCheckoutDetails requires Token returned by SetExpressCheckOut
        $paypal               = new PayPal();
        if ("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])) {
            $orderid = urldecode($httpParsedResponseAr['PAYMENTINFO_0_TRANSACTIONID']);
            $status  = urldecode($httpParsedResponseAr['PAYMENTINFO_0_PAYMENTSTATUS']);
        } else {
            $orderid = 'N/A';
        }
        $padata                = '&TOKEN=' . urlencode($token);
        $httpParsedResponseAr  = $paypal->PPHttpPost('GetExpressCheckoutDetails', $padata, $PayPalApiUsername, $PayPalApiPassword, $PayPalApiSignature, $PayPalMode);
        $totalamount           = urldecode($httpParsedResponseAr['AMT']);
        $registrationid        = Auth::user()->registration->registrationid;
        $status                = str_replace('PaymentAction', '', urldecode($httpParsedResponseAr['CHECKOUTSTATUS']));
        $order                 = new Bill;
        $order->registrationid = $registrationid;
        $order->method         = "PayPal";
        $order->currency       = 'USD';
        $order->description    = 'PayPal Order Number: ' . $orderid;
        $order->amount         = $totalamount;
        $order->checkout_id    = $orderid;
        $order->status         = ucwords($status);
        $order->save();
    }
    
}
