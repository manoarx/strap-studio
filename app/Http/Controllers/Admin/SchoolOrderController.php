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

class SchoolOrderController extends Controller
{
    public function OrdersPrint(Request $request){
        //$orders = Order::where('status','pending')->orderBy('id','DESC')->get();

        $filter_range = $order_status = null;
        $startDate = $request->get('startDate1');
        $endDate = $request->get('endDate1');
        $query = Order::whereHas('orderitem', function ($query) {
            $query->where('product_type', 'school');
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

        return view('backend.schoolorders.ordersprint',compact('orders','filter_range','order_status'));
    }

    public function PendingOrder(Request $request){
        //$orders = Order::where('status','pending')->orderBy('id','DESC')->get();

        $filter_range = null;
        $startDate = $request->get('startDate1');
        $endDate = $request->get('endDate1');
        /*$query = Order::whereHas('orderitem', function ($query) {
            $query->where('product_type', 'school');
        })->where('status','pending');*/

        $query = Order::whereHas('orderitem', function ($query) {
            $query->where('product_type', 'school');
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

        $orders = $query->orderBy('id', 'DESC')->get();

        return view('backend.schoolorders.pending_orders',compact('orders','filter_range'));
    } // End Method 


    public function AdminConfirmedOrder(Request $request){
        //$orders = Order::where('status','confirm')->orderBy('id','DESC')->get();

        $filter_range = null;
        $startDate = $request->get('startDate1');
        $endDate = $request->get('endDate1');
        $query = Order::whereHas('orderitem', function ($query) {
            $query->where('product_type', 'school');
        })->where('status','confirm');

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

        $orders = $query->orderBy('id', 'DESC')->get();

        return view('backend.schoolorders.confirmed_orders',compact('orders','filter_range'));
    } // End Method 


    public function AdminProcessingOrder(Request $request){
        //$orders = Order::where('status','processing')->orderBy('id','DESC')->get();

        $filter_range = null;
        $startDate = $request->get('startDate1');
        $endDate = $request->get('endDate1');
        $query = Order::whereHas('orderitem', function ($query) {
            $query->where('product_type', 'school');
        })->where('status','processing');

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

        $orders = $query->orderBy('id', 'DESC')->get();

        return view('backend.schoolorders.processing_orders',compact('orders','filter_range'));
    } // End Method 


    public function AdminDeliveredOrder(Request $request){
        //$orders = Order::where('status','deliverd')->orderBy('id','DESC')->get();
        $filter_range = null;
        $startDate = $request->get('startDate1');
        $endDate = $request->get('endDate1');

        $query = Order::whereHas('orderitem', function ($query) {
            $query->where('product_type', 'school');
        })->where('status','deliverd');

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

        $orders = $query->orderBy('id', 'DESC')->get();

        return view('backend.schoolorders.delivered_orders',compact('orders','filter_range'));
    } // End Method 

    
    /*public function AdminOrderDetails($order_id){

        $order = Order::with('user')->where('id',$order_id)->first();
        $orderItem = OrderItem::with('product')->where('order_id',$order_id)->orderBy('id','DESC')->get();

        return view('backend.schoolorders.admin_order_details',compact('order','orderItem'));

    }

    public function PendingToConfirm($order_id){
        Order::findOrFail($order_id)->update(['status' => 'confirm']);
        $orderitem = OrderItem::where('order_id',$order_id)->first();
        $product_type = $orderitem->product_type;
        $notification = array(
            'message' => 'Order Confirm Successfully',
            'alert-type' => 'success'
        );

        if($product_type == 'school') {
            return redirect()->route('admin.confirmed.schoolorder')->with($notification); 
        } else {
            return redirect()->route('admin.confirmed.order')->with($notification); 
        }
        


    }

    public function ConfirmToProcess($order_id){
        Order::findOrFail($order_id)->update(['status' => 'processing']);
        $orderitem = OrderItem::where('order_id',$order_id)->first();
        $product_type = $orderitem->product_type;
        $notification = array(
            'message' => 'Order Processing Successfully',
            'alert-type' => 'success'
        );

        if($product_type == 'school') {
            return redirect()->route('admin.processing.schoolorder')->with($notification); 
        } else {
            return redirect()->route('admin.processing.order')->with($notification); 
        }



    }


    public function ProcessToDelivered($order_id){

        $product = OrderItem::where('order_id',$order_id)->get();
        foreach($product as $item){
            Products::where('id',$item->product_id)
                    ->update(['product_qty' => DB::raw('product_qty-'.$item->qty) ]);
        } 

        Order::findOrFail($order_id)->update(['status' => 'deliverd']);
        $orderitem = OrderItem::where('order_id',$order_id)->first();
        $product_type = $orderitem->product_type;
        $notification = array(
            'message' => 'Order Deliverd Successfully',
            'alert-type' => 'success'
        );

        if($product_type == 'school') {
            return redirect()->route('admin.delivered.schoolorder')->with($notification); 
        } else {
            return redirect()->route('admin.delivered.order')->with($notification); 
        }

    }


    public function AdminInvoiceDownload($order_id){

        $order = Order::with('user')->where('id',$order_id)->first();
        $orderItem = OrderItem::with('product')->where('order_id',$order_id)->orderBy('id','DESC')->get();

        $pdf = Pdf::loadView('backend.schoolorders.admin_order_invoice', compact('order','orderItem'))->setPaper('a4')->setOption([
                'tempDir' => public_path(),
                'chroot' => public_path(),
        ]);
        return $pdf->download('invoice.pdf');

    }*/ 


 
}
 