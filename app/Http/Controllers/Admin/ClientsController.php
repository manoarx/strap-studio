<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Clients;
use Image;

class ClientsController extends Controller
{
    use MediaUploadingTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = Clients::latest()->get();

        return view('backend.clients.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //return view('backend.clients.create');
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
            Image::make($image)->save('upload/clients/'.$name_gen);
            $save_url = 'upload/clients/'.$name_gen;
        }

        Clients::insert([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'image' => $save_url, 
        ]);

       $notification = array(
            'message' => 'Client Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('admin.clients.index')->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Clients  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Clients $client)
    {
        return view('backend.clients.show', compact('client'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Clients  $clients
     * @return \Illuminate\Http\Response
     */
    public function edit(Clients $client)
    {

        return view('backend.clients.edit', compact('client'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Clients  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = $request->id;
        $old_img = $request->old_image;

        if ($request->file('image')) {

            $image = $request->file('image');
            $name_gen = time().rand(1,50).'.'.$image->getClientOriginalExtension();
            Image::make($image)->save('upload/clients/'.$name_gen);
            $save_url = 'upload/clients/'.$name_gen;

            if (file_exists($old_img)) {
               unlink($old_img);
            }

            Clients::findOrFail($id)->update([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'image' => $save_url, 
            ]);

           $notification = array(
                'message' => 'Client Updated with image Successfully',
                'alert-type' => 'success'
            );

            return redirect()->route('admin.clients.index')->with($notification); 

        } else {

             Clients::findOrFail($id)->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            ]);

            $notification = array(
                'message' => 'Client Updated without image Successfully',
                'alert-type' => 'success'
            );

            return redirect()->route('admin.clients.index')->with($notification); 

        } 

    }

    public function delete($id)
    {

        $del = Clients::findOrFail($id);
        $img = $del->image;
        if($img) {
           unlink($img );  
        }
        

        Clients::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Client Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }


}
