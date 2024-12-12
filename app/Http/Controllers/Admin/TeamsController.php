<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Teams;
use Image;

class TeamsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $teams = Teams::latest()->get();

        return view('backend.teams.index', compact('teams'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //return view('backend.teams.create');
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
            Image::make($image)->save('upload/teams/'.$name_gen);
            $save_url = 'upload/teams/'.$name_gen;
        }

        Teams::insert([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'desc' => $request->desc,
            'linkedin' => $request->linkedin,
            'instagram' => $request->instagram,
            'image' => $save_url, 
        ]);

       $notification = array(
            'message' => 'Team Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('admin.teams.index')->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Teams  $team
     * @return \Illuminate\Http\Response
     */
    public function show(Teams $team)
    {
        return view('backend.teams.show', compact('team'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Teams  $teams
     * @return \Illuminate\Http\Response
     */
    public function edit(Teams $team)
    {

        return view('backend.teams.edit', compact('team'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Teams  $team
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = $request->id;
        $old_img = $request->old_image;

        if ($request->file('image')) {

            $image = $request->file('image');
            $name_gen = time().rand(1,50).'.'.$image->getClientOriginalExtension();
            Image::make($image)->save('upload/teams/'.$name_gen);
            $save_url = 'upload/teams/'.$name_gen;

            if (file_exists($old_img)) {
               unlink($old_img);
            }

            Teams::findOrFail($id)->update([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'desc' => $request->desc,
                'linkedin' => $request->linkedin,
                'instagram' => $request->instagram,
                'image' => $save_url, 
            ]);

           $notification = array(
                'message' => 'Team Updated with image Successfully',
                'alert-type' => 'success'
            );

            return redirect()->route('admin.teams.index')->with($notification); 

        } else {

            Teams::findOrFail($id)->update([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'desc' => $request->desc,
                'linkedin' => $request->linkedin,
                'instagram' => $request->instagram,
            ]);

            $notification = array(
                'message' => 'Team Updated without image Successfully',
                'alert-type' => 'success'
            );

            return redirect()->route('admin.teams.index')->with($notification); 

        } 

    }

    public function delete($id)
    {

        $del = Teams::findOrFail($id);
        $img = $del->image;
        if($img) {
           unlink($img );  
        }
        

        Teams::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Team Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }


}
