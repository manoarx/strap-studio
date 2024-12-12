<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Products;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderConfirmMail;

use Illuminate\Support\Facades\Notification;
use SMSGlobal\Resource\Sms;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function OrdersPrint(Request $request){
        //$orders = Order::where('status','pending')->orderBy('id','DESC')->get();

        $filter_range = $order_status = null;
        $startDate = $request->get('startDate1');
        $endDate = $request->get('endDate1');
        $query = Order::whereHas('orderitem', function ($query) {
            $query->where('product_type', '!=' ,'school');
        });

        if ($request->filter_range) {
            $filter_range = $request->filter_range;
            switch ($filter_range) {
                case 'current_month':
                    $query->whereMonth('created_at', Carbon::now()->firstOfMonth()->month);
                    break;
                case 'last_month':
                    $query->whereMonth('created_at', Carbon::now()->subMonth()->month);
                    break;
                case 'this_year':
                    $query->whereYear('created_at', Carbon::now()->year);
                    break;
                case 'custom':
                    if (!empty($startDate) && !empty($endDate)) {
                        $startDate = date("Y-m-d", strtotime($startDate));
                        $endDate = date("Y-m-d", strtotime($endDate . " +1 days"));
                        $query->whereBetween('created_at', [$startDate, $endDate]);
                    }
                    break;
                default:
                    //$filterQuery = "";
                    break;
            }
        } else {
            $filter_range ="";
        }

        if ($request->order_status) {
            $order_status = $request->order_status;

            $query->where('status',$order_status);

        } else {
            $order_status = 'pending';

            $query->where('status',$order_status);
        }

        $orders = $query->orderBy('id', 'ASC')->get();

        return view('backend.orders.ordersprint',compact('orders','filter_range','order_status'));
    }

    public function PendingOrder(Request $request)
    {
        //$orders = Order::where('status','pending')->orderBy('id','DESC')->get();

        $filter_range = null;
        $startDate = $request->get('startDate1');
        $endDate = $request->get('endDate1');

        /*$query = Order::whereHas('orderitem', function ($query) {
            $query->whereNot('product_type', 'school');
        })->where('status', 'pending');*/

        $query = Order::whereHas('orderitem', function ($query) {
            $query->whereNot('product_type', 'school');
        });

        if ($request->filter_range) {
            $filter_range = $request->filter_range;
            switch ($filter_range) {
                case 'current_month':
                    $query->whereMonth('created_at', Carbon::now()->firstOfMonth()->month);
                    break;
                case 'last_month':
                    $query->whereMonth('created_at', Carbon::now()->subMonth()->month);
                    break;
                case 'this_year':
                    $query->whereYear('created_at', Carbon::now()->year);
                    break;
                case 'custom':
                    if (!empty($startDate) && !empty($endDate)) {
                        $startDate = date("Y-m-d", strtotime($startDate));
                        $endDate = date("Y-m-d", strtotime($endDate));
                        $query->whereBetween('created_at', [$startDate, $endDate]);
                    }
                    break;
                default:
                    //$filterQuery = "";
                    break;
            }
        } else {
            $filter_range ="";
        }

        $orders = $query->orderBy('id', 'DESC')->get();

        return view('backend.orders.pending_orders', compact('orders','filter_range'));
    } // End Method 


    public function AdminOrderDetails($order_id)
    {

        $order = Order::with('user')->where('id', $order_id)->first();
        $orderItem = OrderItem::with('product')->where('order_id', $order_id)->orderBy('id', 'DESC')->get();

        return view('backend.orders.admin_order_details', compact('order', 'orderItem'));
    } // End Method 

    public function AdminSchoolOrderDetails($order_id)
    {

        $order = Order::with('user')->where('id', $order_id)->first();
        $orderItem = OrderItem::with('product')->where('order_id', $order_id)->orderBy('id', 'DESC')->get();

        return view('backend.schoolorders.admin_order_details', compact('order', 'orderItem'));
    }


    public function AdminConfirmedOrder(Request $request)
    {
        
        //$orders = Order::where('status','confirm')->orderBy('id','DESC')->get();

        $filter_range = null;
        $startDate = $request->get('startDate1');
        $endDate = $request->get('endDate1');

        $query = Order::whereHas('orderitem', function ($query) {
            $query->whereNot('product_type', 'school');
        })->where('status', 'confirm');

        if ($request->filter_range) {
            $filter_range = $request->filter_range;
            switch ($filter_range) {
                case 'current_month':
                    $query->whereMonth('created_at', Carbon::now()->firstOfMonth()->month);
                    break;
                case 'last_month':
                    $query->whereMonth('created_at', Carbon::now()->subMonth()->month);
                    break;
                case 'this_year':
                    $query->whereYear('created_at', Carbon::now()->year);
                    break;
                case 'custom':
                    if (!empty($startDate) && !empty($endDate)) {
                        $startDate = date("Y-m-d", strtotime($startDate));
                        $endDate = date("Y-m-d", strtotime($endDate));
                        $query->whereBetween('created_at', [$startDate, $endDate]);
                    }
                    break;
                default:
                    //$filterQuery = "";
                    break;
            }
        } else {
            $filter_range ="";
        }

        $orders = $query->orderBy('id', 'DESC')->get();

        return view('backend.orders.confirmed_orders', compact('orders','filter_range'));
    } // End Method 


    public function AdminProcessingOrder(Request $request)
    {
        //$orders = Order::where('status','processing')->orderBy('id','DESC')->get();

        $filter_range = null;
        $startDate = $request->get('startDate1');
        $endDate = $request->get('endDate1');

        $query = Order::whereHas('orderitem', function ($query) {
            $query->whereNot('product_type', 'school');
        })->where('status', 'processing');

        if ($request->filter_range) {
            $filter_range = $request->filter_range;
            switch ($filter_range) {
                case 'current_month':
                    $query->whereMonth('created_at', Carbon::now()->firstOfMonth()->month);
                    break;
                case 'last_month':
                    $query->whereMonth('created_at', Carbon::now()->subMonth()->month);
                    break;
                case 'this_year':
                    $query->whereYear('created_at', Carbon::now()->year);
                    break;
                case 'custom':
                    if (!empty($startDate) && !empty($endDate)) {
                        $startDate = date("Y-m-d", strtotime($startDate));
                        $endDate = date("Y-m-d", strtotime($endDate));
                        $query->whereBetween('created_at', [$startDate, $endDate]);
                    }
                    break;
                default:
                    //$filterQuery = "";
                    break;
            }
        } else {
            $filter_range ="";
        }

        $orders = $query->orderBy('id', 'DESC')->get();

        return view('backend.orders.processing_orders', compact('orders','filter_range'));
    } // End Method 


    public function AdminDeliveredOrder(Request $request)
    {
        //$orders = Order::where('status','deliverd')->orderBy('id','DESC')->get();

        $filter_range = null;
        $startDate = $request->get('startDate1');
        $endDate = $request->get('endDate1');

        $query = Order::whereHas('orderitem', function ($query) {
            $query->whereNot('product_type', 'school');
        })->where('status', 'deliverd');

        if ($request->filter_range) {
            $filter_range = $request->filter_range;
            switch ($filter_range) {
                case 'current_month':
                    $query->whereMonth('created_at', Carbon::now()->firstOfMonth()->month);
                    break;
                case 'last_month':
                    $query->whereMonth('created_at', Carbon::now()->subMonth()->month);
                    break;
                case 'this_year':
                    $query->whereYear('created_at', Carbon::now()->year);
                    break;
                case 'custom':
                    if (!empty($startDate) && !empty($endDate)) {
                        $startDate = date("Y-m-d", strtotime($startDate));
                        $endDate = date("Y-m-d", strtotime($endDate));
                        $query->whereBetween('created_at', [$startDate, $endDate]);
                    }
                    break;
                default:
                    //$filterQuery = "";
                    break;
            }
        } else {
            $filter_range ="";
        }

        $orders = $query->orderBy('id', 'DESC')->get();

        return view('backend.orders.delivered_orders', compact('orders','filter_range'));
    } // End Method 


    public function PendingToConfirm($order_id)
    {
        Order::findOrFail($order_id)->update(['status' => 'confirm']);
        $orderitem = OrderItem::where('order_id', $order_id)->first();
        $product_type = $orderitem->product_type;
        $notification = array(
            'message' => 'Order Confirm Successfully',
            'alert-type' => 'success'
        );

        $order = Order::findOrFail($order_id);

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
            'vatAmount' => $order->vat_amount,
            'user_name' => $order->user->name,
            'billing_address' => $order->user->address,

        ];

        $admin_email = 'info@strapstudios.com';

        //Mail::to($order->email)->bcc([$admin_email, 'go2vinu@gmail.com'])->send(new OrderConfirmMail($data));


        if ($product_type == 'school') {
            //SMS Start
            if($order->phone != '')
            {
                try {
                    $sms = app('smsglobal');
                    $user_phone_number = "971".$order->phone;
                    $destinationNumber = $this->normalizePhoneNumber($user_phone_number);  
                    $message = 'Your Order #'.$order_id.' has been delivered. Thank you for choosing Strap Studios.';
                    
                    
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
            return redirect()->route('admin.pending.schoolorder')->with($notification);
        } else {
            return redirect()->route('admin.pending.order')->with($notification);
        }
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

    public function ConfirmToProcess($order_id)
    {
        Order::findOrFail($order_id)->update(['status' => 'processing']);
        $orderitem = OrderItem::where('order_id', $order_id)->first();
        $product_type = $orderitem->product_type;
        $notification = array(
            'message' => 'Order Processing Successfully',
            'alert-type' => 'success'
        );

        if ($product_type == 'school') {
            return redirect()->route('admin.processing.schoolorder')->with($notification);
        } else {
            return redirect()->route('admin.processing.order')->with($notification);
        }
    }


    public function ProcessToDelivered($order_id)
    {

        $product = OrderItem::where('order_id', $order_id)->get();
        foreach ($product as $item) {
            Products::where('id', $item->product_id)
                ->update(['product_qty' => DB::raw('product_qty-' . $item->qty)]);
        }

        Order::findOrFail($order_id)->update(['status' => 'deliverd']);
        $orderitem = OrderItem::where('order_id', $order_id)->first();
        $product_type = $orderitem->product_type;
        $notification = array(
            'message' => 'Order Deliverd Successfully',
            'alert-type' => 'success'
        );

        if ($product_type == 'school') {
            return redirect()->route('admin.pending.schoolorder')->with($notification);
        } else {
            return redirect()->route('admin.pending.order')->with($notification);
        }
    }

    public function OrderCancel($order_id)
    {

        $product = OrderItem::where('order_id', $order_id)->get();
        foreach ($product as $item) {
            Products::where('id', $item->product_id)
                ->update(['product_qty' => DB::raw('product_qty-' . $item->qty)]);
        }

        Order::findOrFail($order_id)->update(['status' => 'cancel']);
        $orderitem = OrderItem::where('order_id', $order_id)->first();
        $product_type = $orderitem->product_type;
        $notification = array(
            'message' => 'Order Cancelled Successfully',
            'alert-type' => 'success'
        );

        if ($product_type == 'school') {
            return redirect()->route('admin.delivered.schoolorder')->with($notification);
        } else {
            return redirect()->route('admin.delivered.order')->with($notification);
        }
    }


    public function AdminInvoiceDownload($order_id)
    {

        $order = Order::with('user')->where('id', $order_id)->first();
        $orderItem = OrderItem::with('product')->where('order_id', $order_id)->orderBy('id', 'DESC')->get();

        //$this->createInvoice;

        $pdf = Pdf::loadView('backend.orders.admin_order_invoice', compact('order', 'orderItem'))->setPaper('a4')->setOption([
            'tempDir' => public_path(),
            'chroot' => public_path(),
        ]);
        return $pdf->download('invoice.pdf');
    }
}
