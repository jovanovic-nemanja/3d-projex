<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
/** All Paypal Details class **/
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use Redirect;
use Session;
use URL;

class PaymentController extends Controller
{
    private $_api_context;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        /** PayPal api context **/
        $paypal_conf = \Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential(
            $paypal_conf['client_id'],
            $paypal_conf['secret'])
        );
        $this->_api_context->setConfig($paypal_conf['settings']);
    }

    public function index()
    {
        return view('paywithpaypal');
    }

    public function payWithpaypal(Request $request)
    {
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');
        $item_1 = new Item();
        $item_1->setName('Item 1') /** item name **/
            ->setCurrency('USD')
            ->setQuantity(1)
            ->setPrice($request->get('amount')); /** unit price **/
        $item_list = new ItemList();
        $item_list->setItems(array($item_1));
        $amount = new Amount();
        $amount->setCurrency('USD')
            ->setTotal($request->get('amount'));
        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($item_list)
            ->setDescription('Your transaction description');
        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl(URL::to('paymentstatus')) /** Specify return URL **/
            ->setCancelUrl(URL::to('paymentstatus'));
        $payment = new Payment();
        $payment->setIntent('Sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirect_urls)
            ->setTransactions(array($transaction));
        /** dd($payment->create($this->_api_context));exit; **/
        try {
            $payment->create($this->_api_context);
        } catch (\PayPal\Exception\PPConnectionException $ex) {
            if (\Config::get('app.debug')) {
                \Session::put('error', 'Connection timeout');
                return Redirect::to('/');
            } else {
                \Session::put('error', 'Some error occur, sorry for inconvenient');
                return Redirect::to('/');
            }
        }
        foreach ($payment->getLinks() as $link) {
            if ($link->getRel() == 'approval_url') {
                $redirect_url = $link->getHref();
                break;
            }
        }
        /** add payment ID to session **/
        Session::put('paypal_payment_id', $payment->getId());
        if (isset($redirect_url)) {
            /** redirect to paypal **/
            return Redirect::away($redirect_url);
        }
        \Session::put('error', 'Unknown error occurred');
        return Redirect::to('/');
    }
    
    public function getPaymentStatus()
    {
        /** Get the payment ID before session clear **/
        $payment_id = Session::get('paypal_payment_id');
        /** clear the session payment ID **/
        Session::forget('paypal_payment_id');
        if (empty(Input::get('PayerID')) || empty(Input::get('token'))) {
            \Session::put('error', 'Payment failed');
            return Redirect::to('/');
        }
        $payment = Payment::get($payment_id, $this->_api_context);
        $execution = new PaymentExecution();
        $execution->setPayerId(Input::get('PayerID'));
        /**Execute the payment **/
        $result = $payment->execute($execution, $this->_api_context);
        if ($result->getState() == 'approved') {

            /* Save order in database */
            \Session::put('success', 'Payment success');
            return Redirect::to('/');
        }
        \Session::put('error', 'Payment failed');
        return Redirect::to('/');
    }

    public function paymentngeniusrequest(Request $request)
    {
        $apikey = "YmI3ZTM1YTctNzdiMy00OTUzLTk3OWUtYzkyMTQ5NTg0OGVmOjU5NjE0MGI1LTYxN2ItNGQ4Ny1hNzI0LThiZDRkYzIxZTdmMg==";     // enter your API key here
        $ch = curl_init(); 
        // curl_setopt($ch, CURLOPT_URL, "https://api-gateway.sandbox.ngenius-payments.com/identity/auth/access-token");         
        curl_setopt($ch, CURLOPT_URL, "https://identity.ngenius-payments.com/auth/realms/NetworkInternational/protocol/openid-connect/token"); 
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "accept: application/vnd.ni-identity.v1+json",
            "authorization: Basic ".$apikey,
            "content-type: application/vnd.ni-identity.v1+json"
          )); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);   
        curl_setopt($ch, CURLOPT_POST, 1); 
        curl_setopt($ch, CURLOPT_POSTFIELDS,  "{\"realmName\":\"ni\"}"); 
        dd(curl_exec($ch));
        $output = json_decode(curl_exec($ch)); 

        $access_token = $output->access_token;
        curl_close ($ch);

        $postData = new \StdClass(); 
        $postData->action = "SALE"; 
        $postData->amount = new \StdClass();
        $postData->amount->currencyCode = "AED"; 
        $postData->amount->value = $request->ngenius_amount*100; 

        $outlet = "eb5693c2-829c-4774-89fb-2a46acca49f5";
        $token = $access_token;
         
        $json = json_encode($postData);

        $ch1 = curl_init(); 
         
        curl_setopt($ch1, CURLOPT_URL, "https://api-gateway.ngenius-payments.com/transactions/outlets/".$outlet."/orders"); 
        curl_setopt($ch1, CURLOPT_HTTPHEADER, array(
            "Authorization: Bearer ".$token, 
            "Content-Type: application/vnd.ni-payment.v2+json", 
            "Accept: application/vnd.ni-payment.v2+json")); 
        curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);   
        curl_setopt($ch1, CURLOPT_POST, 1); 
        curl_setopt($ch1, CURLOPT_POSTFIELDS, $json); 
         
        $output = json_decode(curl_exec($ch1)); 
        $order_reference = $output->reference; 
        $order_paypage_url = $output->_links->payment->href; 
        header("Location: ".$order_paypage_url);
        curl_close ($ch1);

        exit;
    }
}