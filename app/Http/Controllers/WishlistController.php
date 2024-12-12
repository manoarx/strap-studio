<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ServicePackages;
use App\Models\ServicePackageAddons;
use App\Models\ServicePackageOptions;
use Illuminate\Support\Facades\Session;
use App\Models\Wishlist;
use App\Models\Workshops;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class WishlistController extends Controller
{
    public function AddToWishList(Request $request, $product_id){

        if (Auth::check()) {
      $exists = Wishlist::where('user_id',Auth::id())->where('product_id',$product_id)->where('pkg_type',$request->pkg_type)->first();

            if (!$exists) {
               Wishlist::insert([
                'user_id' => Auth::id(),
                'product_id' => $product_id,
                'pkg_type' => $request->pkg_type,
                'created_at' => Carbon::now(),

               ]);
               return response()->json(['success' => 'Successfully Added On Your Wishlist' ]);
            } else{
                return response()->json(['error' => 'This Product Has Already on Your Wishlist' ]);

            } 

        }else{
            return response()->json(['error' => 'At First Login Your Account' ]);
        }

    }

    public function customerWishlist(){

        $wishlists = Wishlist::with('workshop')->where('user_id',Auth::id())->latest()->get();

        $wishQty = Wishlist::with('workshop')->where('user_id',Auth::id())->count(); 

        //return response()->json(['wishlist'=> $wishlist, 'wishQty' => $wishQty]);

        return view('frontend.customer.wishlist', compact('wishlists','wishQty'));

    }

    public function WishlistRemove($id){

        Wishlist::where('user_id',Auth::id())->where('id',$id)->delete();
        return response()->json(['success' => 'Successfully Product Remove' ]);
    }

    public function customerWishlistCount(){

        $wishQty = Wishlist::with('workshop')->where('user_id',Auth::id())->get()->count(); 

        return response()->json(['wishQty' => $wishQty]);

    }
}
