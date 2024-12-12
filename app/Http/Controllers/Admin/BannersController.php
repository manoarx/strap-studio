<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banners;
use Illuminate\Support\Str;
use Image;

class BannersController extends Controller
{

    public function index()
    {
        $banners = Banners::latest()->orderBy('page','ASC')->get();

        return view('backend.banners.index', compact('banners'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //return view('backend.banners.create');
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
        $offerimage_name = null;
        $image = $request->file('image');
        if ($request->file('image')) {
            $name_gen = time().rand(1,50).'.'.$image->getClientOriginalExtension();
            $thumb_name_gen = 'thumb_'.time().rand(1,50).'.'.$image->getClientOriginalExtension();
            Image::make($image)->save('upload/banners/'.$name_gen);
            Image::make($image)->resize(110,75)->save('upload/banners/'.$thumb_name_gen);
            $save_url = 'upload/banners/'.$name_gen;
            $thumb_image_url = 'upload/banners/'.$thumb_name_gen;
        }


        if ($request->file('offerimage')) {
            $offerimage = $request->file('offerimage');
            $offerimage_name = time().rand(1,50).'.'.$offerimage->getClientOriginalExtension();
            //$thumb_name_gen = 'thumb_'.time().rand(1,50).'.'.$offerimage->getClientOriginalExtension();
            //Image::make($offerimage)->save('upload/banners/'.$offerimage_name);
            Image::make($offerimage)->resize(110,75)->save('upload/banners/thumb/'.$offerimage_name);
            $offerimage->move('upload/banners/', $offerimage_name);
        }

        Banners::insert([
            'title' => $request->title,
            'short_title' => $request->short_title,
            'page' => $request->page,
            'image' => $save_url, 
            'thumb_image' => $save_url, 
            'offerimage' => $offerimage_name, 
            'left_pos' => $request->left_pos,
            'top_pos' => $request->top_pos,
            'offer_width' => $request->offer_width,
        ]);

       $notification = array(
            'message' => 'Banner Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('admin.banners.index')->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Banners  $banners
     * @return \Illuminate\Http\Response
     */
    /*public function show(Banners $banner)
    {
        return view('backend.banners.show', compact('banner'));
    }*/

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Banners  $banners
     * @return \Illuminate\Http\Response
     */
    public function edit(Banners $banner)
    {
        return view('backend.banners.edit', compact('banner'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Banners  $banners
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = $request->id;
        $old_img = $request->old_image;
        $old_offer_img = $request->old_offer_image;

        if ($request->file('offerimage')) {
            $offerimage = $request->file('offerimage');
            $offerimage_name = time().rand(1,50).'.'.$offerimage->getClientOriginalExtension();
            //Image::make($offerimage)->save('upload/banners/'.$offerimage_name);
            Image::make($offerimage)->resize(110,75)->save('upload/banners/thumb/'.$offerimage_name);
            $offerimage->move('upload/banners/', $offerimage_name);
            
        } else {
            $offerimage_name = $old_offer_img;
        }

        if ($request->file('image')) {

            $image = $request->file('image');
            $name_gen = time().rand(1,50).'.'.$image->getClientOriginalExtension();
            $thumb_name_gen = 'thumb_'.time().rand(1,50).'.'.$image->getClientOriginalExtension();
            Image::make($image)->save('upload/banners/'.$name_gen);
            Image::make($image)->resize(110,75)->save('upload/banners/'.$thumb_name_gen);
            $save_url = 'upload/banners/'.$name_gen;
            $thumb_image_url = 'upload/banners/'.$thumb_name_gen;

            if (file_exists($old_img)) {
               unlink($old_img);
            }

            Banners::findOrFail($id)->update([
                'title' => $request->title,
                'short_title' => $request->short_title,
                'page' => $request->page,
                'image' => $save_url, 
                'thumb_image' => $save_url, 
                'offerimage' => $offerimage_name,
                'left_pos' => $request->left_pos,
                'top_pos' => $request->top_pos,
                'offer_width' => $request->offer_width,
            ]);

           $notification = array(
                'message' => 'Banner Updated Successfully',
                'alert-type' => 'success'
            );

            return redirect()->route('admin.banners.index')->with($notification); 

        } else {

             Banners::findOrFail($id)->update([
                'title' => $request->title,
                'short_title' => $request->short_title,
                'page' => $request->page,
                'offerimage' => $offerimage_name,
                'left_pos' => $request->left_pos,
                'top_pos' => $request->top_pos,
                'offer_width' => $request->offer_width,
            ]);

            $notification = array(
                'message' => 'Banner Updated Successfully',
                'alert-type' => 'success'
            );

            return redirect()->route('admin.banners.index')->with($notification); 

        } 

    }

    public function delete($id)
    {
        $del = Banners::findOrFail($id);
        $img = $del->image;
        if($img) {
           unlink($img );  
        }
        

        Banners::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Banner Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function removeOfferImage($id)
    {
        \Log::info('Removing offer image for banner ID: ' . $id);

        $banner = Banners::find($id);

        if ($banner) {
            // Remove the image file from storage (you may need to adjust the path)
            //Storage::delete('/upload/banners/thumb/' . $banner->offerimage);
            //unlink('/upload/banners/thumb/' . $banner->offerimage); 
            // Update the database record
            $banner->update(['offerimage' => null,'left_pos' => null,'top_pos' => null,'offer_width' => null]);

            return response()->json(['message' => 'Image removed successfully']);
        }

        return response()->json(['error' => 'Banner not found'], 404);
    }
}


