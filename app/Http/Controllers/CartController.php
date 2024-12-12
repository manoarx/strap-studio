<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ServicePackages;
use App\Models\ServicePackageAddons;
use App\Models\ServicePackageOptions;
use App\Models\StudioRentals;
use App\Models\Workshops;
use App\Models\Products;
use App\Models\Coupons;
use App\Models\OrderItem;
use App\Models\User;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Auth;
use DateTime;
use DB;
use URL;
use Google_Client;
use Google_Service_Calendar;
use Google_Service_Calendar_Event;


class CartController extends Controller
{
    public function getBookedSlots(Request $request){

        $selectedDate = $request->input('selectedDate');
        $bookedSlots = OrderItem::where('booked_date', $selectedDate)->get();

        $formattedBookedSlots = [];
        foreach ($bookedSlots as $bookedSlot) {
            $startTime = \Carbon\Carbon::parse($bookedSlot->booked_stime)->format('H:i');
            $endTime = \Carbon\Carbon::parse($bookedSlot->booked_etime)->format('H:i');
            $formattedBookedSlots[] = [
                'booked_date' => $bookedSlot->booked_date,
                'booked_stime' => $startTime,
                'booked_etime' => $endTime,
            ];
        }

        $carts = Cart::content();

        foreach($carts as $cart){
            if($cart->options->pkg_type == 'service') {
                $selected_date = $cart->options->booked_date;
                $selectedStartTime = $cart->options->booked_stime;
                $duration = $cart->options->booked_duration;
                $selectedEndTime = date('H:i', strtotime($selectedStartTime . ' +' . $duration . ' minutes'));
                
                $formattedBookedSlots[] = [
                    'booked_date' => $selected_date,
                    'booked_stime' => $selectedStartTime,
                    'booked_etime' => $selectedEndTime,
                ];
                
            }
        }


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

        $calendarId = 'vg13elo7m6o55vn4e085ubsb1k@group.calendar.google.com';
        //$calendarId = 'c2d04e524443f464bc8113b1d4627fa9691ff92e60bc03d8b02f8edceab83bb0@group.calendar.google.com';

        $userSelectedDate = $selectedDate;
        $userSelectedStartTime = '00:00:00';
        $userSelectedEndTime = '23:59:00';

        // Combine the date and time into a single string
        $userSelectedStartDateTime = $userSelectedDate . 'T' . $userSelectedStartTime . '+00:00';

        $userSelectedEndDateTime = $userSelectedDate . 'T' . $userSelectedEndTime . '+00:00';

        // Format the combined date and time to RFC3339 format
        $formattedStartDate = (new DateTime($userSelectedStartDateTime))->format(DATE_RFC3339);

        $formattedEndDate = (new DateTime($userSelectedEndDateTime))->format(DATE_RFC3339);

        // Fetch events within the specified timeframe
        $optParams = array(
            'timeMin' => $formattedStartDate,
            'timeMax' => $formattedEndDate,
            'showDeleted' => false,
            'singleEvents' => true,
            'orderBy' => 'startTime',
            'alwaysIncludeEmail' => true,
        );
        $events = $service->events->listEvents($calendarId, $optParams)->getItems();

        foreach ($events as $event) {
            $eventStart = $event->start->dateTime;
            $eventEnd = $event->end->dateTime;
            
            $startDateTime = new DateTime($eventStart);
            $startdate = $startDateTime->format('Y-m-d');
            $starttime = $startDateTime->format('H:i');

            $endDateTime = new DateTime($eventEnd);
            $enddate = $endDateTime->format('Y-m-d');
            $endtime = $endDateTime->format('H:i');

            $formattedBookedSlots[] = [
                'booked_date' => $startdate,
                'booked_stime' => $starttime,
                'booked_etime' => $endtime,
                'email' => $event->creator->email,
            ];
            // Compare the event's start and end date/time with the user-selected date/time
            //if ($startDate >= $eventStart && $startDate < $eventEnd) {
                // The user-selected date/time conflicts with the event
                // Take appropriate action, such as rejecting the user's selection
                // You can display an error message or redirect them to choose a different date/time
                //echo "Selected date and time conflict with an existing event.";
                //break;
            //}
        }

        //Google Calendar



        $bookedSlotsJson = json_encode($formattedBookedSlots);
            
        return response()->json($formattedBookedSlots);

    }

    public function AddToCartServicePackage(Request $request, $id){

        $selected_date = $request->selected_date;
        $selectedStartTime = $request->selected_time;
        $response = [];
        $carts = Cart::content();

        foreach ($carts as $item) {
            // Access the date and time values for each item in the cart
            $itemDate = $item->options->booked_date; // Assuming the date is stored as a property in the item object
            $itemTime = $item->options->booked_stime; // Assuming the time is stored as a property in the item object
            
            // Compare the selected date and time with the item's date and time
            if ($selected_date === $itemDate && $selectedStartTime === $itemTime) {
                // Date and time already exist in the cart
                $response['message'] = "Selected date and time already exist in the cart.";
                $response['found'] = true;
                break; // Exit the loop since we found a match
            }
        }

        if (isset($response['message'])) {

            return response()->json(array(
                'exists' => true,
                'error' => 'Selected date and time already in cart'
            ));
            
        }

        $start_time = Carbon::createFromFormat('H:i', $selectedStartTime);

        $start_time->addMinutes($request->duration);

        $selectedEndTime = $start_time->format('H:i');

        $isSlotAvailable = DB::table('order_items')
        ->where('booked_date', '=', $selected_date)
        ->where(function ($query) use ($selectedStartTime, $selectedEndTime) {
            $query->where(function ($query) use ($selectedStartTime, $selectedEndTime) {
                $query->where('booked_stime', '<=', $selectedStartTime)
                    ->where('booked_etime', '>', $selectedStartTime);
            })->orWhere(function ($query) use ($selectedStartTime, $selectedEndTime) {
                $query->where('booked_stime', '<', $selectedEndTime)
                    ->where('booked_etime', '>=', $selectedEndTime);
            });
        })
        ->exists();

        if ($isSlotAvailable) {

            return response()->json(array(
                'exists' => true,
                'error' => 'Selected date and time already booked'
            ));
            
        }else{

            if (Session::has('coupon')) {
               Session::forget('coupon');
            }

            $product = ServicePackages::findOrFail($id);

            $selected_date = $request->selected_date;
            $selected_time = $request->selected_time;

            $existingItem = Cart::search(function ($cartItem) use ($id, $selected_date, $selected_time) {
                return $cartItem->id === $id && $cartItem->options->booked_date === $selected_date && $cartItem->options->booked_stime === $selected_time;
            });

            if ($existingItem->isNotEmpty()) {
                return response()->json(array(
                    'exists' => true,
                    'error' => 'Item already exists in the cart'
                ));
            } else {
                Cart::add([

                    'id' => $id,
                    'name' => $product->package_name,
                    'qty' => 1,
                    'price' => $request->totprice,
                    'weight' => 1,
                    'options' => [
                        'pkg_type' => $request->pkg_type,
                        'option_id' => $request->option_id,
                        'addon_id' => $request->addon_id,
                        'addon_qty' => 1,
                        'booked_stime' => $request->selected_time,
                        'booked_duration' => $request->duration,
                        'booked_date' => $request->selected_date,
                    ],
                ]);

                // Set tax rate for the cart
                //Cart::setGlobalTax(0.05); // 5% tax rate

                $carts = Cart::content();
                $cartQty = Cart::count();
                $cartTotal = Cart::total();

                //return response()->json(['success' => 'Successfully Added on Your Cart' ]);

                return response()->json(array(
                    'exists' => false,
                    'carts' => $carts,
                    'cartQty' => $cartQty,  
                    'cartTotal' => $cartTotal,
                    'success' => 'Successfully Added on Your Cart'
                ));
            }
        }

    }

    public function AddToCartStudioRental(Request $request, $id){

        $selected_date = $request->selected_date;
        $selectedStartTime = $request->selected_time;
        $response = [];
        $carts = Cart::content();

        foreach ($carts as $item) {
            // Access the date and time values for each item in the cart
            $itemDate = $item->options->booked_date; // Assuming the date is stored as a property in the item object
            $itemTime = $item->options->booked_stime; // Assuming the time is stored as a property in the item object
            
            // Compare the selected date and time with the item's date and time
            if ($selected_date === $itemDate && $selectedStartTime === $itemTime) {
                // Date and time already exist in the cart
                $response['message'] = "Selected date and time already exist in the cart.";
                $response['found'] = true;
                break; // Exit the loop since we found a match
            }
        }

        if (isset($response['message'])) {

            return response()->json(array(
                'exists' => true,
                'error' => 'Selected date and time already in cart'
            ));
            
        }
        
        $start_time = Carbon::createFromFormat('H:i', $selectedStartTime);

        $start_time->addMinutes($request->duration);

        $selectedEndTime = $start_time->format('H:i');

        $isSlotAvailable = DB::table('order_items')
        ->where('booked_date', '=', $selected_date)
        ->where(function ($query) use ($selectedStartTime, $selectedEndTime) {
            $query->where(function ($query) use ($selectedStartTime, $selectedEndTime) {
                $query->where('booked_stime', '<=', $selectedStartTime)
                    ->where('booked_etime', '>', $selectedStartTime);
            })->orWhere(function ($query) use ($selectedStartTime, $selectedEndTime) {
                $query->where('booked_stime', '<', $selectedEndTime)
                    ->where('booked_etime', '>=', $selectedEndTime);
            });
        })
        ->exists();

        if ($isSlotAvailable) {

            return response()->json(array(
                'exists' => true,
                'error' => 'Selected date and time already booked'
            ));
            
        }else{

            if (Session::has('coupon')) {
               Session::forget('coupon');
            }

            $product = StudioRentals::findOrFail($id);

            $selected_date = $request->selected_date;
            $selected_time = $request->selected_time;

            $existingItem = Cart::search(function ($cartItem) use ($id, $selected_date, $selected_time) {
                return $cartItem->id === $id && $cartItem->options->booked_date === $selected_date && $cartItem->options->booked_stime === $selected_time;
            });

            if ($existingItem->isNotEmpty()) {
                return response()->json(array(
                    'exists' => true,
                    'error' => 'Item already exists in the cart'
                ));
            } else {
                Cart::add([

                    'id' => $id,
                    'name' => $product->title,
                    'qty' => 1,
                    'price' => $request->totprice,
                    'weight' => 1,
                    'options' => [
                        'pkg_type' => $request->pkg_type,
                        'booked_stime' => $request->selected_time,
                        'booked_duration' => $request->duration,
                        'booked_date' => $request->selected_date,
                    ],
                ]);

                // Set tax rate for the cart
                //Cart::setGlobalTax(0.05); // 5% tax rate

                $carts = Cart::content();
                $cartQty = Cart::count();
                $cartTotal = Cart::total();

                //return response()->json(['success' => 'Successfully Added on Your Cart' ]);

                return response()->json(array(
                    'exists' => false,
                    'carts' => $carts,
                    'cartQty' => $cartQty,  
                    'cartTotal' => $cartTotal,
                    'success' => 'Successfully Added on Your Cart'
                ));
            }
        }

    }


    public function AddToCartWorkshop(Request $request, $id){

        $selected_date = $request->selected_date;
        $selectedStartTime = $request->selected_time;

        $response = [];
        $carts = Cart::content();

        foreach ($carts as $item) {
            // Access the date and time values for each item in the cart
            $itemDate = $item->options->booked_date; // Assuming the date is stored as a property in the item object
            $itemTime = $item->options->booked_stime; // Assuming the time is stored as a property in the item object
            
            // Compare the selected date and time with the item's date and time
            if ($selected_date === $itemDate && $selectedStartTime === $itemTime) {
                // Date and time already exist in the cart
                $response['message'] = "Selected date and time already exist in the cart.";
                $response['found'] = true;
                break; // Exit the loop since we found a match
            }
        }

        if (isset($response['message'])) {

            return response()->json(array(
                'exists' => true,
                'error' => 'Selected date and time already in cart'
            ));
            
        }

        $start_time = Carbon::createFromFormat('H:i', $selectedStartTime);

        $start_time->addMinutes($request->duration);

        $selectedEndTime = $start_time->format('H:i');

        $isSlotAvailable = DB::table('order_items')
        ->where('booked_date', '=', $selected_date)
        ->where(function ($query) use ($selectedStartTime, $selectedEndTime) {
            $query->where(function ($query) use ($selectedStartTime, $selectedEndTime) {
                $query->where('booked_stime', '<=', $selectedStartTime)
                    ->where('booked_etime', '>', $selectedStartTime);
            })->orWhere(function ($query) use ($selectedStartTime, $selectedEndTime) {
                $query->where('booked_stime', '<', $selectedEndTime)
                    ->where('booked_etime', '>=', $selectedEndTime);
            });
        })
        ->exists();

        if ($isSlotAvailable) {

            return response()->json(array(
                'exists' => true,
                'error' => 'Selected date and time already booked'
            ));
            
        }else{

            if (Session::has('coupon')) {
               Session::forget('coupon');
            }

            $product = Workshops::findOrFail($id);

            $selected_date = $request->selected_date;
            $selected_time = $request->selected_time;

            $existingItem = Cart::search(function ($cartItem) use ($id, $selected_date, $selected_time) {
                return $cartItem->id === $id && $cartItem->options->booked_date === $selected_date && $cartItem->options->booked_stime === $selected_time;
            });

            if ($existingItem->isNotEmpty()) {
                return response()->json(array(
                    'exists' => true,
                    'error' => 'Item already exists in the cart'
                ));
            } else {
                Cart::add([

                    'id' => $id,
                    'name' => $product->title,
                    'qty' => 1,
                    'price' => $request->totprice,
                    'weight' => 1,
                    'options' => [
                        'pkg_type' => $request->pkg_type,
                        'booked_stime' => $request->selected_time,
                        'booked_duration' => $request->duration,
                        'booked_date' => $request->selected_date,
                    ],
                ]);

                // Set tax rate for the cart
                //Cart::setGlobalTax(0.05); // 5% tax rate

                $carts = Cart::content();
                $cartQty = Cart::count();
                $cartTotal = Cart::total();

                //return response()->json(['success' => 'Successfully Added on Your Cart' ]);

                return response()->json(array(
                    'exists' => false,
                    'carts' => $carts,
                    'cartQty' => $cartQty,  
                    'cartTotal' => $cartTotal,
                    'success' => 'Successfully Added on Your Cart'
                ));
            }
        }

    }


    public function AddToCartSchool(Request $request, $id){
        
        if (Session::has('coupon')) {
           Session::forget('coupon');
        }

        $product = Products::findOrFail($id);
        if($request->digitalPrice > 0) {
            $total_price = ($product->hard_copy_amount+$product->digital_amount);
        } else {
            $total_price = $product->hard_copy_amount;
        }
        
        // $cartItem = Cart::search(function ($cartItem) use ($id) {
        //     return $cartItem->id === $productId;
        // })->first();

        // $cartItem = Cart::search(function ($cartItem, $rowId) use ($id) {
        //     return $cartItem->id === $id;
        // })->first();

        // if ($cartItem) {
        //     Cart::update($cartItem->rowId, $cartItem->qty + 1);
        // } else {
            Cart::add([

                'id' => $id,
                'name' => $product->title,
                'qty' => 1,
                'price' => $total_price,
                'weight' => 1,
                'options' => [
                    'pkg_type' => $request->pkg_type,
                    'option_id' => $request->option_id,
                    'addon_id' => $request->addon_id,
                    'addon_qty' => 1,
                    'digital_price' => $request->digitalPrice,
                ],
            ]);
        //}

        // Set tax rate for the cart
        //Cart::setGlobalTax(0.05); // 5% tax rate


        $carts = Cart::content();
        $cartQty = Cart::count();
        $cartTotal = Cart::total();

        // Add tax rate for the cart
        //$cart->setGlobalTax(0.05); // 5% tax rate

        //return response()->json(['success' => 'Successfully Added on Your Cart' ]);

        return response()->json(array(
            'carts' => $carts,
            'cartQty' => $cartQty,  
            'cartTotal' => $cartTotal,
            'success' => 'Successfully Added on Your Cart'
        ));

    }

    public function customerCart()
    {
        if (Session::has('coupon')) {
            $cartTotal = Session::get('coupon')['total_amount'];
        }else{
            $cartTotal = Cart::total();
        }

        $carts = Cart::content();
        $cartQty = Cart::count();
        //$cartTotal = Cart::total();

        // return response()->json(array(
        //     'carts' => $carts,
        //     'cartQty' => $cartQty,  
        //     'cartTotal' => $cartTotal

        // ));

        return view('frontend.customer.cart', compact('carts','cartQty','cartTotal'));
    }


    public function schoolCart()
    {
        if (Session::has('coupon')) {
            $cartTotal = Session::get('coupon')['total_amount'];
        }else{
            $cartTotal = Cart::total();
        }

        $carts = Cart::content();
        $cartQty = Cart::count();
        //$cartTotal = Cart::total();

        // return response()->json(array(
        //     'carts' => $carts,
        //     'cartQty' => $cartQty,  
        //     'cartTotal' => $cartTotal

        // ));

        $id = Auth::user()->id;
        $userData = User::find($id);

        return view('frontend.school.cart', compact('carts','cartQty','cartTotal','userData'));
    }

    public function GetCartProduct(){

        if (Session::has('coupon')) {
            $cartTotal = Session::get('coupon')['total_amount'];
        }else{
            $cartTotal = round(Cart::total());
        }

        $carts = Cart::content();
        $cartQty = Cart::count();
        //$cartTotal = Cart::total();

        return response()->json(array(
            'carts' => $carts,
            'cartQty' => $cartQty,  
            'cartTotal' => round($cartTotal,2)

        ));

    }

    public function CartRemove($rowId){
        Cart::remove($rowId);

        if (Session::has('coupon')) {
           Session::forget('coupon');
        }

        $carts = Cart::content();
        $cartQty = Cart::count();
        $cartTotal = Cart::total();

        return response()->json(array(
            'carts' => $carts,
            'cartQty' => $cartQty,  
            'cartTotal' => $cartTotal,
            'success' => 'Successfully Remove From Cart'

        ));
        //return response()->json(['success' => 'Successfully Remove From Cart']);

    }

    public function GetCartDetails(){

        $carts = Cart::content();
        $cartQty = Cart::count();
        $cartTotal = Cart::total();

        return response()->json(array(
            'carts' => $carts,
            'cartQty' => $cartQty,  
            'cartTotal' => $cartTotal

        ));
    }

    public function CheckoutCreate(){

        if (Auth::check()) {

            if (Cart::total() > 0) { 

        $carts = Cart::content();
        $cartQty = Cart::count();
        $cartTotal = Cart::total();

        return view('frontend.checkout.checkout_view',compact('carts','cartQty','cartTotal'));


            }else{

            $notification = array(
            'message' => 'Shopping At list One Product',
            'alert-type' => 'error'
        );

        return redirect()->to('/')->with($notification); 
            }



        }else{

             $notification = array(
            'message' => 'You Need to Login First',
            'alert-type' => 'error'
        );

        return redirect()->route('login')->with($notification); 
        }




    }

    public function CartDecrement($rowId){

        $row = Cart::get($rowId);
        Cart::update($rowId, $row->qty -1);

        if (Session::has('coupon')) {

            $coupon_name = Session::get('coupon')['coupon_name'];
            $coupon = Coupon::where('coupon_name',$coupon_name)->first();

           Session::put('coupon',[
                'coupon_name' => $coupon->coupon_name,
                'coupon_discount' => $coupon->coupon_discount,
                'discount_amount' => round(Cart::total() * $coupon->coupon_discount/100), 
                'total_amount' => round(Cart::total() - Cart::total() * $coupon->coupon_discount/100)  
            ]);
        }

        return response()->json('Decrement');

    }

    public function CartIncrement($rowId){

        $row = Cart::get($rowId);
        Cart::update($rowId, $row->qty +1);

        if (Session::has('coupon')) {

            $coupon_name = Session::get('coupon')['coupon_name'];
            $coupon = Coupon::where('coupon_name',$coupon_name)->first();

           Session::put('coupon',[
                'coupon_name' => $coupon->coupon_name,
                'coupon_discount' => $coupon->coupon_discount,
                'discount_amount' => round(Cart::total() * $coupon->coupon_discount/100), 
                'total_amount' => round(Cart::total() - Cart::total() * $coupon->coupon_discount/100)  
            ]);
        }

        return response()->json('Increment');

    }

    public function addonQtyUpdate(Request $request){

        $rowId = $request->cart_id;
        //$addon_id = $request->addon_id;
        $addon_price = $request->addon_price;
        $addon_qty = $request->addon_qty;

        $currentCartItem = Cart::get($rowId);

        $current_addon_qty = $currentCartItem->options->addon_qty;
        $totalprice = $currentCartItem->price;

        if($addon_qty > $current_addon_qty) {
            $new_total_price = $totalprice + ($addon_price * ($addon_qty - $current_addon_qty));
        }elseif ($addon_qty < $current_addon_qty) {
            $new_addon_qty = $current_addon_qty - $addon_qty;
            $new_addon_qty = max(0, $new_addon_qty);
            //$new_total_price = $totalprice - ($addon_price * $current_addon_qty);
            $new_total_price = $totalprice - ($addon_price * ($current_addon_qty - $addon_qty));
        }

        $totprice = $new_total_price;

        $newOptions = array_merge($currentCartItem->options->toArray(), ['addon_qty' => $addon_qty]);

        Cart::update($rowId, ['price' => $new_total_price,'options'  => $newOptions]);




        return response()->json(array(
            'validity' => true,
            'success' => 'Addon Qty Updated Successfully'
        ));
            
        

    }

    public function CouponApply(Request $request){

        if($request->coupon_name === null){
            return response()->json(['error' => 'Coupon filed is required']);
        }

        $coupon = Coupons::where(['code' => $request->coupon_name, 'status' => 1])->first();

        if($coupon === null){
            return response()->json(['error' => 'Coupon not exist!']);
        }elseif($coupon->start_date > date('Y-m-d')){
            return response()->json(['error' => 'Coupon not exist!']);
        }elseif($coupon->end_date < date('Y-m-d')){
            return response()->json(['error' => 'Coupon is expired']);
        }elseif($coupon->total_used >= $coupon->quantity){
            return response()->json(['error' => 'You can not apply this coupon']);
        }

        if($coupon->discount_type === 'amount'){

            $cartTotal = str_replace(',', '', Cart::total());

            Session::put('coupon',[
                'coupon_name' => $coupon->name,
                'coupon_code' => $coupon->code,
                'discount_type' => 'amount',
                'coupon_discount' => $coupon->discount,
                'discount_amount' => $coupon->discount, 
                'total_amount' => round($cartTotal - $coupon->discount)  
            ]);

        }elseif($coupon->discount_type === 'percent'){

            $cartTotal = str_replace(',', '', Cart::total());

            Session::put('coupon',[
                'coupon_name' => $coupon->name,
                'coupon_code' => $coupon->code,
                'discount_type' => 'percent',
                'coupon_discount' => $coupon->discount,
                'discount_amount' => round($cartTotal * $coupon->discount/100), 
                'total_amount' => round($cartTotal - $cartTotal * $coupon->discount/100)  
            ]);

        }

        return response()->json(array(
                'validity' => true,
                'success' => 'Coupon Applied Successfully'
            ));

        /*$coupon = Coupons::where('coupon_name',$request->coupon_name)->where('coupon_validity','>=',Carbon::now()->format('Y-m-d'))->first();
        if ($coupon) {
            $cartTotal = str_replace(',', '', Cart::total());

            Session::put('coupon',[
                'coupon_name' => $coupon->coupon_name,
                'coupon_discount' => $coupon->coupon_discount,
                'discount_amount' => round($cartTotal * $coupon->coupon_discount/100), 
                'total_amount' => round($cartTotal - $cartTotal * $coupon->coupon_discount/100)  
            ]);
 
            return response()->json(array(
                'validity' => true,
                'success' => 'Coupon Applied Successfully'
            ));
            
        }else{
            return response()->json(['error' => 'Invalid Coupon']);
        }*/

    }


    public function CouponCalculation(){

        if (Session::has('coupon')) {
            return response()->json(array(
                'subtotal' => Cart::total(),
                'coupon_name' => session()->get('coupon')['coupon_name'],
                'coupon_code' => session()->get('coupon')['coupon_code'],
                'coupon_discount' => session()->get('coupon')['coupon_discount'],
                'discount_amount' => session()->get('coupon')['discount_amount'],
                'total_amount' => session()->get('coupon')['total_amount'],
            ));
        }else{
            return response()->json(array(
                'total' => Cart::total(),
            ));

        }
    } // end method 


    // Remove Coupon 
    public function CouponRemove(){
        Session::forget('coupon');
        return response()->json(['success' => 'Coupon Remove Successfully']);
    }
}
