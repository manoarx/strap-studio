<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Testimonials;
use Image;

class TestimonialsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $testimonials = Testimonials::latest()->get();

        return view('backend.testimonials.index', compact('testimonials'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //return view('backend.testimonials.create');
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
            Image::make($image)->resize(50,50)->save('upload/testimonials/'.$name_gen);
            $save_url = 'upload/testimonials/'.$name_gen;
        }

        Testimonials::insert([
            'name' => $request->name,
            'desc' => $request->desc,
            'slug' => Str::slug($request->name),
            'image' => $save_url, 
        ]);

       $notification = array(
            'message' => 'Testimonial Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('admin.testimonials.index')->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\testimonials  $testimonial
     * @return \Illuminate\Http\Response
     */
    public function show(Testimonials $testimonial)
    {
        return view('backend.testimonials.show', compact('testimonial'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\testimonials  $testimonials
     * @return \Illuminate\Http\Response
     */
    public function edit(Testimonials $testimonial)
    {

        return view('backend.testimonials.edit', compact('testimonial'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\testimonials  $testimonial
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = $request->id;
        $old_img = $request->old_image;

        if ($request->file('image')) {

            $image = $request->file('image');
            $name_gen = time().rand(1,50).'.'.$image->getClientOriginalExtension();
            Image::make($image)->resize(50,50)->save('upload/testimonials/'.$name_gen);
            $save_url = 'upload/testimonials/'.$name_gen;

            if (file_exists($old_img)) {
               unlink($old_img);
            }

            Testimonials::findOrFail($id)->update([
                'name' => $request->name,
                'desc' => $request->desc,
                'slug' => Str::slug($request->name),
                'image' => $save_url, 
            ]);

           $notification = array(
                'message' => 'Testimonial Updated with image Successfully',
                'alert-type' => 'success'
            );

            return redirect()->route('admin.testimonials.index')->with($notification); 

        } else {

             Testimonials::findOrFail($id)->update([
            'name' => $request->name,
            'desc' => $request->desc,
            'slug' => Str::slug($request->name),
            ]);

            $notification = array(
                'message' => 'Testimonial Updated without image Successfully',
                'alert-type' => 'success'
            );

            return redirect()->route('admin.testimonials.index')->with($notification); 

        } 

    }

    public function delete($id)
    {

        $del = Testimonials::findOrFail($id);
        $img = $del->image;
        if($img) {
           unlink($img );  
        }
        

        Testimonials::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Testimonial Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }


}
