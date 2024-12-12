<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\OfferBanners;
use Image;

class OfferBannersController extends Controller
{
    use MediaUploadingTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $offerbanners = OfferBanners::latest()->get();

        return view('backend.offerbanners.index', compact('offerbanners'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //return view('backend.offerbanners.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $save_url = null;
        $image = $request->file('image');
        if ($request->file('image')) {
            $name_gen = time().rand(1,50).'.'.$image->getClientOriginalExtension();
            Image::make($image)->save('upload/offerbanners/'.$name_gen);
            $save_url = 'upload/offerbanners/'.$name_gen;
        }

        OfferBanners::insert([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'image' => $save_url, 
        ]);

       $notification = array(
            'message' => 'Offer Banners Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('admin.offerbanners.index')->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\OfferBanners  $offerbanner
     * @return \Illuminate\Http\Response
     */
    public function show(OfferBanners $offerbanner)
    {
        return view('backend.offerbanners.show', compact('offerbanner'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\OfferBanners  $offerbanners
     * @return \Illuminate\Http\Response
     */
    public function edit(OfferBanners $offerbanner)
    {

        return view('backend.offerbanners.edit', compact('offerbanner'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\OfferBanners  $offerbanner
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = $request->id;
        $old_img = $request->old_image;

        if ($request->file('image')) {

            $image = $request->file('image');
            $name_gen = time().rand(1,50).'.'.$image->getClientOriginalExtension();
            Image::make($image)->save('upload/offerbanners/'.$name_gen);
            $save_url = 'upload/offerbanners/'.$name_gen;

            if (file_exists($old_img)) {
               unlink($old_img);
            }

            OfferBanners::findOrFail($id)->update([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'image' => $save_url, 
            ]);

           $notification = array(
                'message' => 'Offer Banners Updated with image Successfully',
                'alert-type' => 'success'
            );

            return redirect()->route('admin.offerbanners.index')->with($notification); 

        } else {

             OfferBanners::findOrFail($id)->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            ]);

            $notification = array(
                'message' => 'OfferBanners Updated without image Successfully',
                'alert-type' => 'success'
            );

            return redirect()->route('admin.offerbanners.index')->with($notification); 

        } 

    }

    public function delete($id)
    {

        $del = OfferBanners::findOrFail($id);
        $img = $del->image;
        if($img) {
           unlink($img );  
        }
        

        OfferBanners::findOrFail($id)->delete();

        $notification = array(
            'message' => 'OfferBanners Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }


}
