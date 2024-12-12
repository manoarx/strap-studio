<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Session;
use Auth;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Products;
use App\Models\OfferBanners;
use App\Models\Country;
use Illuminate\Support\Facades\Hash;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Route;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function schoolHome()
    {
        $id = Auth::user()->id;
        $userData = User::find($id);
        $offerbanners = OfferBanners::latest()->get();
        return view('frontend.school.home',compact('userData','offerbanners'));
    }

    public function schoolProfile()
    {
        $id = Auth::user()->id;
        $userData = User::find($id);
        $currentPath = Route::currentRouteName();
        $countries = Country::get();
        return view('frontend.school.profile',compact('userData','currentPath','countries'));
    }

    public function schoolProfileCart()
    {
        $id = Auth::user()->id;
        $userData = User::find($id);
        $currentPath = Route::currentRouteName();
        $countries = Country::get();
        return view('frontend.school.profile',compact('userData','currentPath','countries'));
    }

    public function schoolProfileStore(Request $request){
        $currentPath = $request->currentPath;
        $username = substr($request->email, 0, strpos($request->email, '@'));
        while (User::where('username', $username)->exists()) {
            // If the username exists, append a random number to the end
            $username = $username . rand(1, 9999);
        }

        $id = Auth::user()->id;
        $data = User::find($id);
        $data->name = $request->name;
        //$data->username = $username;
        //$data->email = $request->email;
        $data->cn_code = $request->cn_code;
        $data->phone = $request->phone;
        $data->address = $request->address; 


        if ($request->file('photo')) {
            $file = $request->file('photo');
            @unlink(public_path('upload/user_images/'.$data->photo));
            $filename = date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('upload/user_images'),$filename);
            $data['photo'] = $filename;
        }

        $data->save();

        $notification = array(
            'message' => 'User Profile Updated Successfully',
            'alert-type' => 'success'
        );

        if($currentPath == 'school.profilecart') {
            return redirect()->route('school.cart');
        } else {
            return redirect()->back()->with($notification);
        }

    }
  
    /**
     * Show the application profile.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function customerProfile()
    {
        $id = Auth::user()->id;
        $userData = User::find($id);
        $currentPath = Route::currentRouteName();
        $countries = Country::get();
        return view('frontend.customer.profile',compact('userData','currentPath','countries'));
    }

    public function customerProfileCart()
    {
        $id = Auth::user()->id;
        $userData = User::find($id);
        $currentPath = Route::currentRouteName();
        $countries = Country::get();
        return view('frontend.customer.profile',compact('userData','currentPath','countries'));
    }

    public function customerProfileStore(Request $request){
        $currentPath = $request->currentPath;
        $username = substr($request->email, 0, strpos($request->email, '@'));
        while (User::where('username', $username)->exists()) {
            // If the username exists, append a random number to the end
            $username = $username . rand(1, 9999);
        }

        $id = Auth::user()->id;
        $data = User::find($id);
        $data->name = $request->name;
        //$data->username = $username;
        //$data->email = $request->email;
        $data->cn_code = $request->cn_code;
        $data->phone = $request->phone;
        $data->address = $request->address; 


        if ($request->file('photo')) {
            $file = $request->file('photo');
            @unlink(public_path('upload/user_images/'.$data->photo));
            $filename = date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('upload/user_images'),$filename);
            $data['photo'] = $filename;
        }

        $data->save();

        $notification = array(
            'message' => 'User Profile Updated Successfully',
            'alert-type' => 'success'
        );
        if($currentPath == 'customer.profilecart') {
            return redirect()->route('customer.cart');
        } else {
            return redirect()->back()->with($notification);
        }
        

    }

    public function customerUpdatePassword(Request $request){
        // Validation 
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed', 
        ]);

        // Match The Old Password
        if (!Hash::check($request->old_password, auth::user()->password)) {
            return back()->with("error", "Old Password Doesn't Match!!");
        }

        // Update The new password 
        User::whereId(auth()->user()->id)->update([
            'password' => Hash::make($request->new_password)

        ]);
        //return back()->with("status", " Password Changed Successfully");
        return response()->json(['success' => 'Your password has been updated.']);
    }

    /*public function customerWishlist()
    {
        return view('frontend.customer.wishlist');
    }*/

    public function schoolOrder()
    {
        $id = Auth::user()->id;
        $orders = Order::where('user_id',$id)->orderBy('id','DESC')->get();
        return view('frontend.school.order',compact('orders'));
    }

    public function customerOrder()
    {
        $id = Auth::user()->id;
        $orders = Order::where('user_id',$id)->orderBy('id','DESC')->get();
        return view('frontend.customer.order',compact('orders'));
    }

    public function UserOrderDetails($order_id){

        $order = Order::with('user')->where('id',$order_id)->where('user_id',Auth::id())->first();
        $orderItem = OrderItem::with('product')->where('order_id',$order_id)->orderBy('id','DESC')->get();

        return view('frontend.order_details',compact('order','orderItem'));

    }

    public function UserOrderInvoice($order_id){

        $order = Order::with('user')->where('id',$order_id)->where('user_id',Auth::id())->first();
        $orderItem = OrderItem::with('product')->where('order_id',$order_id)->orderBy('id','DESC')->get();

        $pdf = Pdf::loadView('frontend.order_invoice', compact('order','orderItem'))->setPaper('a4')->setOption([
                'tempDir' => public_path(),
                'chroot' => public_path(),
        ]);
        return $pdf->download('invoice.pdf');

    }
}
