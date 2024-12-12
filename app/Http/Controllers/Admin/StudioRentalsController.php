<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\StudioRentals;

class StudioRentalsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $studiorentals = StudioRentals::latest()->get();

        return view('backend.studiorentals.index', compact('studiorentals'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        StudioRentals::insert([
            'title' => $request->title,
            'price' => $request->price,
            'slug' => Str::slug($request->title),
        ]);

       $notification = array(
            'message' => 'Package added Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('admin.studiorentals.index')->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(StudioRentals $studiorentals)
    {
        return view('backend.studiorentals.show', compact('studiorentals'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(StudioRentals $studiorental)
    {
        return view('backend.studiorentals.edit', compact('studiorental'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        StudioRentals::findOrFail($id)->update([
        'title' => $request->title,
        'price' => $request->price,
        'slug' => Str::slug($request->title),
        ]);

        $notification = array(
            'message' => 'Studio Rentals Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('admin.studiorentals.index')->with($notification); 
    }

    public function delete($id)
    {

        StudioRentals::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Studio Rentals Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function mostliked(Request $request)
    {
        $likedPackageId = $request->input('package_id');
        StudioRentals::where('id', $likedPackageId)->update(['most_liked' => true]);
        StudioRentals::where('id', '<>', $likedPackageId)->update(['most_liked' => false]);
        return response()->json(['success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
