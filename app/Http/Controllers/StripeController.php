<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem; 
use App\Models\TimeSlot; 
use App\Models\Settings;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderMail;
use Stripe\Stripe;
use Stripe\Charge;
use Stripe\PaymentIntent;
use DateTime;
use DB;
use URL;
use Google_Client;
use Google_Service_Calendar;
use Google_Service_Calendar_Event;
use Facades\App\Http\Services\InvoiceService;
use Illuminate\Support\Facades\Notification;
use SMSGlobal\Resource\Sms;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class StripeController extends Controller
{
    public function createPaymentIntent()
    {
        // \Stripe\Stripe::setApiKey('sk_test_51FEZJCB76s03tTv8SFpZF6qEIIhi9aADE5LQgFu8cHa3L3Kr79uuX54DQabLqp9GNQa0wUTu0gXyWiGJCTatH7ZN00zRGAHJgG');   // Test

        \Stripe\Stripe::setApiKey('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');  // Live

        //Stripe::setApiKey(config('services.stripe.secret'));

        if (Session::has('coupon')) {
            $cartTotal = Session::get('coupon')['total_amount'];
            $coupon_name = Session::get('coupon')['coupon_name'];
            $coupon_discount = Session::get('coupon')['coupon_discount'];
            $discount_amount = Session::get('coupon')['discount_amount'];
        }else{
            $cartTotal = Cart::total();
            $coupon_name = null;
            $coupon_discount = null;
            $discount_amount = null;
        }
        if (is_numeric($cartTotal)) {
            $amount = $cartTotal;
        } else {
            $amount = str_replace(",", "", $cartTotal);
        }
        //$amount = round(Cart::total());
        
        $vatPercentage = 5;

        $vatAmount = $amount * ($vatPercentage / 100);

        $total_amount = round(($amount + $vatAmount),2);
            
        $paymentIntent = \Stripe\PaymentIntent::create([
            'amount' => $total_amount*100, // Amount in cents
            'currency' => 'aed',
            'payment_method_types' => ['card', 'apple_pay'],
        ]);

        return response()->json(['clientSecret' => $paymentIntent->client_secret]);
    }

    public function session(Request $request)
    {
        \Stripe\Stripe::setApiKey(config('stripe.sk'));

        if (Session::has('coupon')) {
            $cartTotal = Session::get('coupon')['total_amount'];
            $coupon_name = Session::get('coupon')['coupon_name'];
            $coupon_discount = Session::get('coupon')['coupon_discount'];
            $discount_amount = Session::get('coupon')['discount_amount'];
        }else{
            $cartTotal = Cart::total();
            $coupon_name = null;
            $coupon_discount = null;
            $discount_amount = null;
        }
        if (is_numeric($cartTotal)) {
            $amount = $cartTotal;
        } else {
            $amount = str_replace(",", "", $cartTotal);
        }
        //$amount = round(Cart::total());
        
        $vatPercentage = 5;

        $vatAmount = $amount * ($vatPercentage / 100);

        $total_amount = round(($amount + $vatAmount),2);
 
        $productname = $request->get('productname');
        $totalprice = $request->get('total');
        $two0 = "00";
        $total = "$totalprice$two0";
 
        $session = \Stripe\Checkout\Session::create([
            'line_items'  => [
                [
                    'price_data' => [
                        'currency'     => 'aed',
                        'product_data' => [
                            "name" => $productname,
                        ],
                        'unit_amount'  => $total,
                    ],
                    'quantity'   => 1,
                ],
                 
            ],
            'mode'        => 'payment',
            'success_url' => route('success'),
            'cancel_url'  => route('checkout'),
            'payment_method_types' => [
                'card',
                'apple_pay',
            ],
            'automatic_payment_methods' => [
                'enabled' => 'true',
            ],
            'payment_intent_data'      => [
                'setup_future_usage' => 'off_session',
            ],
        ]);
 
        return redirect()->away($session->url);
    }

    public function StripeOrder(Request $request){

        $carts = Cart::content();

        foreach($carts as $cart){
            if($cart->options->pkg_type == 'service') {
                $selected_date = $cart->options->booked_date;
                $selectedStartTime = $cart->options->booked_stime;
                $duration = $cart->options->booked_duration;
                $selectedEndTime = date('H:i', strtotime($selectedStartTime . ' +' . $duration . ' minutes'));
                

                $isBooked = DB::table('order_items')
                ->where('booked_date', '=', $selected_date)
                ->where(function ($query) use ($selectedStartTime, $selectedEndTime) {
                    $query->where(function ($query) use ($selectedStartTime, $selectedEndTime) {
                        $query->where('booked_stime', '<=', $selectedStartTime)
                            ->where('booked_etime', '>', $selectedStartTime);
                    })->orWhere(function ($query) use ($selectedStartTime, $selectedEndTime) {
                        $query->where('booked_stime', '<', $selectedEndTime)
                            ->where('booked_etime', '>=', $selectedEndTime);
                    });
                })->exists();

                if ($isBooked) {
                    $notification = 'Selected date and time already booked, Please remove from cart and select another date.';
                    return redirect()->route('customer.cart')->with($notification);
                    
                }
            }
        }

        if(Auth::user()->phone == '' || Auth::user()->address == '')
        {
            if(Auth::user()->type == 'customer') {
                return redirect()->route('customer.profilecart');
            } else {
                return redirect()->route('school.profilecart');
            }
            
        } else {

            if (Session::has('coupon')) {
                $cartTotal = Session::get('coupon')['total_amount'];
                $coupon_name = Session::get('coupon')['coupon_name'];
                $coupon_discount = Session::get('coupon')['coupon_discount'];
                $discount_amount = Session::get('coupon')['discount_amount'];
            }else{
                $cartTotal = Cart::total();
                $coupon_name = null;
                $coupon_discount = null;
                $discount_amount = null;
            }
            if (is_numeric($cartTotal)) {
                $amount = $cartTotal;
            } else {
                $amount = str_replace(",", "", $cartTotal);
            }
            //$amount = round(Cart::total());
            
            $vatPercentage = 5;

            $vatAmount = $amount * ($vatPercentage / 100);

            $total_amount = round(($amount + $vatAmount),2);

            //$total_amount = round(Cart::total());

            // \Stripe\Stripe::setApiKey(env('STRIPE_API_KEY')); 

            // \Stripe\Stripe::setApiKey('sk_test_51FEZJCB76s03tTv8SFpZF6qEIIhi9aADE5LQgFu8cHa3L3Kr79uuX54DQabLqp9GNQa0wUTu0gXyWiGJCTatH7ZN00zRGAHJgG');   // Test

            \Stripe\Stripe::setApiKey(config('stripe.sk'));

            //$token = $_POST['stripeToken'];

            

            //dd($charge);

            $order_id = Order::insertGetId([
                'user_id' => Auth::id(),
                'division_id' => $request->division_id,
                'district_id' => $request->district_id,
                'state_id' => $request->state_id,
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'adress' => $request->address,
                'post_code' => $request->post_code,
                'notes' => $request->notes,
                'invoice_no' => 'STS'.mt_rand(10000000,99999999),
                'amount' => $total_amount,
                'vat_amount' => $vatAmount,
                'coupon_name' => $coupon_name,
                'coupon_discount' => $coupon_discount,
                'discount_amount' => $discount_amount,
                'order_date' => Carbon::now()->format('d F Y'),
                'order_month' => Carbon::now()->format('F'),
                'order_year' => Carbon::now()->format('Y'), 
                'status' => 'pending',
                'created_at' => Carbon::now() 


            ]);



            // $charge = \Stripe\Charge::create([
            //   'amount' => $total_amount*100,
            //   'currency' => 'aed',
            //   'description' => 'STRAP STUDIOS - Order '.$order_id,
            //   'source' => $token,
            //   'metadata' => ['order_id' => uniqid()],
            // ]);

            

            //return redirect()->route('orderconfirm')->with($notification);

            if(Auth::user()->type == 'customer') {
                $redirect_checkout = route('customer.profilecart');
            } else {
                $redirect_checkout = route('school.profilecart');
            }

            $session = \Stripe\Checkout\Session::create([
                'line_items'  => [
                    [
                        'price_data' => [
                            'currency'     => 'aed',
                            'product_data' => [
                                "name" => 'STRAP STUDIOS - Order '.$order_id,
                            ],
                            'unit_amount'  => $total_amount*100,
                        ],
                        'quantity'   => 1,
                    ],
                     
                ],
                'mode'        => 'payment',
                'success_url' => route('stripe.success'). '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url'  => route('index'),
                'metadata' => [
                    'order_id' => $order_id, 
                ],
            ]);

            return redirect()->away($session->url);
        }
    }

    public function orderconfirm(Request $request)
    {
        // Set your Stripe API secret key here
        \Stripe\Stripe::setApiKey(config('stripe.sk'));

        // Retrieve the session ID from the query parameters
        $sessionId = $request->query('session_id');

        try {
            // Retrieve the session details from Stripe
            $session = \Stripe\Checkout\Session::retrieve($sessionId);

            // Retrieve the payment intent associated with the session
            $paymentIntentId = $session->payment_intent;

            // Retrieve the payment intent details
            $paymentIntent = PaymentIntent::retrieve($paymentIntentId);

            // Access the balance transaction ID
            $balanceTransactionId = $paymentIntent->charges->data[0]->balance_transaction;

            $order_id = $session->metadata->order_id;


            Order::whereId($order_id)->update([
                'invoice_no' => 'ST'.$order_id,
                'payment_type' => $session->payment_method_types[0],
                'payment_method' => 'Stripe',
                'transaction_id' => $balanceTransactionId,
                'currency' => strtoupper($session->currency),
                'order_number' => $session->metadata->order_id
            ]);

            //Google Calendar

            $credentialsPath = storage_path('credentials.json');
            $client = new Google_Client();
            $client->setApplicationName('Strapstudios');
            $client->setScopes(array(Google_Service_Calendar::CALENDAR));
            $client->setAuthConfig($credentialsPath);
            $client->setAccessType('offline');
            $client->getAccessToken();
            $client->getRefreshToken(); 

            $service = new Google_Service_Calendar($client);

            $smstype = "";

            //Google Calendar
            $carts = Cart::content();
            foreach($carts as $cart){
                $booked_etime = 0;
                if($cart->options->booked_duration > 0 && $cart->options->booked_stime != "") {

                    $time = $cart->options->booked_stime;
                    $duration = $cart->options->booked_duration;
                    $booked_etime = date('H:i', strtotime($time . ' +' . $duration . ' minutes'));

                    $insertedItemId = OrderItem::insertGetId([
                        'order_id' => $order_id,
                        'product_id' => $cart->id,
                        'product_type' => $cart->options->pkg_type,
                        'booked_date' => $cart->options->booked_date,
                        'booked_stime' => $cart->options->booked_stime,
                        'booked_etime' => $booked_etime,
                        'option_id' => $cart->options->option_id,
                        'addon_id' => $cart->options->addon_id,
                        'addon_qty' => $cart->options->addon_qty,
                        'digital_price' => $cart->options->digital_price,
                        'qty' => $cart->qty,
                        'price' => $cart->price,
                        'created_at' =>Carbon::now(),

                    ]);

                    $settings = Settings::pluck('value', 'key');
                    $item = OrderItem::with('product')->where('id', $insertedItemId)->first();

                    //Google Calendar
                    
                    // Convert start date and time to the desired time zone
                    $eventStartDateTime = Carbon::createFromFormat('Y-m-d H:i', $cart->options->booked_date . ' ' . $item->booked_stime, 'Asia/Dubai');
                    $eventStartDateTime->setTimezone('Asia/Dubai');
                    $formattedStartDateTime = $eventStartDateTime->format('Y-m-d\TH:i:sP');

                    
                    // Convert end date and time to the desired time zone
                    $eventEndDateTime = Carbon::createFromFormat('Y-m-d H:i', $cart->options->booked_date . ' ' . $booked_etime, 'Asia/Dubai');
                    $eventEndDateTime->setTimezone('Asia/Dubai');
                    $formattedEndDateTime = $eventEndDateTime->format('Y-m-d\TH:i:sP');
                    

                    $eventEndDateTime = $cart->options->booked_date.' '.$booked_etime;

                    if (DateTime::createFromFormat('Y-m-d H:i', $eventEndDateTime) === false) {
                        echo "Invalid date and time format: " . $eventEndDateTime;
                        die;
                    } else {
                        $eventEndDateTime = Carbon::createFromFormat('Y-m-d H:i', $cart->options->booked_date . ' ' . $booked_etime, 'Asia/Dubai');
                        $eventEndDateTime->setTimezone('Asia/Dubai');
                        $formattedEndDateTime = $eventEndDateTime->format('Y-m-d\TH:i:sP');
                    }

                    
                    if($item->product_type == 'workshop') {
                      $itemtype = $item->workshop;
                    } elseif($item->product_type == 'service') {
                      $itemtype = $item->servicepackage->service;
                    } elseif($item->product_type == 'studiorental') {
                      $itemtype = $item->studiorental;
                    } else {
                      $itemtype = $item->product;
                    }

                    $event   = new Google_Service_Calendar_Event(array(
                        'summary' => ucwords($item->product_type).'-'.$itemtype->title.'('.$item->booked_stime.'-'.$item->booked_etime.')',
                        'location' => '',
                        'description' => 'Order No : '.$order_id,
                        'start' => array(
                        'dateTime' => $formattedStartDateTime,
                        'timeZone' => 'Asia/Dubai',
                        ),
                        'end' => array(
                        'dateTime' => $formattedEndDateTime,
                        'timeZone' => 'Asia/Dubai',
                        ),
                        'attendees' => array(),  
                        'reminders' => array(
                        'useDefault' => FALSE,
                        'overrides' => array(
                            array('method' => 'email', 'minutes' => 24 * 60),
                            array('method' => 'popup', 'minutes' => 10),
                        ),
                        ),
                    ));
                    
                    $calendarId = 'vg13elo7m6o55vn4e085ubsb1k@group.calendar.google.com';
                    $event      = $service->events->insert($calendarId, $event);

                    //Google Calendar
          
                    $smstype = "studio";

                } else {
                    /*$insertedItemId = OrderItem::insertGetId([
                        'order_id' => $order_id,
                        'product_id' => $cart->id,
                        'product_type' => $cart->options->pkg_type,
                        'booked_date' => $cart->options->booked_date,
                        'booked_stime' => $cart->options->booked_stime,
                        'booked_etime' => $booked_etime,
                        'option_id' => $cart->options->option_id,
                        'addon_id' => $cart->options->addon_id,
                        'addon_qty' => $cart->options->addon_qty,
                        'digital_price' => $cart->options->digital_price,
                        'qty' => $cart->qty,
                        'price' => $cart->price,
                        'created_at' =>Carbon::now(),

                    ]);*/

                    $chkorderItem = OrderItem::firstOrCreate([
                        'order_id' => $order_id,
                        'product_id' => $cart->id,
                        'product_type' => $cart->options->pkg_type,
                        'booked_date' => $cart->options->booked_date,
                        'booked_stime' => $cart->options->booked_stime,
                        'booked_etime' => $booked_etime,
                        'option_id' => $cart->options->option_id,
                        'addon_id' => $cart->options->addon_id,
                        'addon_qty' => $cart->options->addon_qty,
                        'digital_price' => $cart->options->digital_price,
                        'qty' => $cart->qty,
                        'price' => $cart->price,
                    ], [
                        'created_at' => Carbon::now(),
                    ]);

                    $insertedItemId = $chkorderItem->id;

                    $smstype = "school";
                }
                

                //SMS Start
                if(Auth::user()->phone != '')
                {
                    try {
                        $sms = app('smsglobal');
                        $user_phone_number = Auth::user()->cn_code."".Auth::user()->phone;
                        $destinationNumber = $this->normalizePhoneNumber($user_phone_number);  
                        if($smstype == "studio") {
                            $message = 'we have received your Order #'.$order_id.', your booking is confirmed for the '.$cart->options->booked_date.' at '.$cart->options->booked_stime.'. Thank you for choosing Strap Studios.';
                        } else {
                            $message = 'We have received your Order #'.$order_id.' and is under process. You will be notified once the order is ready for delivery.';
                        }
                        
                        $response = $sms->sendToOne($destinationNumber, $message, 'STRAPSTUDIO');
                        //print_r($response['messages']);
                        Log::info('SMS Global API Response', [
                            'response' => [
                                'Messages' => $response['messages'],
                            ],
                        ]);
                    } catch (\Exception $e) {
                        //echo "Error: " . $e->getMessage() . "\n";
                        //echo "Code: " . $e->getCode() . "\n";
                        //
                        Log::info('SMS Global API Response', [
                            'response' => [
                                'Error' => $e->getMessage(),
                                'Code' => $e->getCode(),
                            ],
                        ]);
                    }
                }
                // SMS End

            }
            
            // Start Send Email

            $order = Order::findOrFail($order_id);
            
            //$orderItem = OrderItem::with('product')->where('order_id',$order_id)->orderBy('id','DESC')->get();

            //$vatPercentage = 5;
            //$vatAmount = round($order->amount * ($vatPercentage / 100),2);
            $vatAmount = round($order->vat_amount,2);
            if($vatAmount == null) {
                $vatPercentage = 5;
                $vatAmount = round($order->amount * ($vatPercentage / 100),2);
            }

            $data = [

                'order_no' => $order->id,
                'date' => date("F j, Y"),
                'invoice_no' => $order->invoice_no,
                'amount' => $order->amount,
                'coupon_name' => $order->coupon_name,
                'coupon_discount' => $order->coupon_discount,
                'discount_amount' => $order->discount_amount,
                'name' => $order->name,
                'email' => $order->email,
                'products' => $order->orderitem,
                'vatAmount' => $vatAmount,
                'user_name' => $order->user->name,
                'billing_address' => $order->user->address,

            ];

            $admin_email = 'info@strapstudios.com';

            if($order->mail_send == null)  {
                Mail::to($order->email)->bcc([$admin_email, 'go2vinu@gmail.com'])->send(new OrderMail($data));
            }
            

            // End Send Email
            
            Order::whereId($order_id)->update([
                'mail_send' => 'Yes'
            ]);
            


            //Quickbook invoice
            InvoiceService::adminInvoiceDownload($order_id);


            if (Session::has('coupon')) {
                Session::forget('coupon');
            }

            Cart::destroy();


            $notification = array(
                'message' => 'Your Order Place Successfully',
                'alert-type' => 'success'
            );

            return view('frontend.orderconfirm', [
                'session' => $session,
            ]);
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            // Handle the exception if the session ID is invalid
            return redirect()->route('payment.error');
        }
    }


    public function paymentError()
    {
        return view('frontend.paymenterror');
    }


    public function normalizePhoneNumber($phoneNumber) {
        // Remove any non-numeric characters
        $phoneNumber = preg_replace('/[^0-9]/', '', $phoneNumber);

        // If the number starts with '0', remove it
        if (substr($phoneNumber, 0, 1) === '0') {
            $phoneNumber = substr($phoneNumber, 1);
        }

        // If the number doesn't start with the country code, add '971'
        // if (substr($phoneNumber, 0, 3) !== '971') {
        //     $phoneNumber = '971' . $phoneNumber;
        // }

        return $phoneNumber;
    }

    public function testordermail()
    {
        $order_id = 2100;
        //$total_amount = 315.00;
        $order = Order::findOrFail($order_id);
        //$orderItem = OrderItem::with('product')->where('order_id',$order_id)->orderBy('id','DESC')->get();

        
        $vatAmount = round($order->vat_amount,2);
        if($vatAmount == null) {
            $vatPercentage = 5;
            $vatAmount = round($order->amount * ($vatPercentage / 100),2);
        }

            $data = [

                'order_no' => $order->id,
                'date' => date("F j, Y"),
                'invoice_no' => $order->invoice_no,
                'amount' => $order->amount,
                'coupon_name' => $order->coupon_name,
                'coupon_discount' => $order->coupon_discount,
                'discount_amount' => $order->discount_amount,
                'name' => $order->name,
                'email' => $order->email,
                'products' => $order->orderitem,
                'vatAmount' => $vatAmount,
                'user_name' => $order->user->name,
                'billing_address' => $order->user->address,

            ];

        //$admin_email = 'go2vinu@gmail.com';
        $admin_email = 'info@strapstudios.com';

        //Mail::to($admin_email)->send(new OrderMail($data));
        Mail::to($order->email)->bcc([$admin_email, 'go2vinu@gmail.com'])->send(new OrderMail($data));

        // End Send Email
    }
}
