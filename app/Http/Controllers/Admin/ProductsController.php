<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Models\Products;
use App\Models\Students;
use Illuminate\Support\Str;

class ProductsController extends Controller
{
    use MediaUploadingTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Products::orderBy('id','desc');
        if ($request->studentid) {
            $studentid = $request->studentid;
            $query->where('student_id', '=', $studentid); 
        }
        $products = $query->get();

        $years = Students::select('year')->distinct()->orderBy('year','asc')->get();

        return view('backend.products.index', compact('products','years'));
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
        //return $request;
        $schoolId = $request->school_id;

        if($request->student_id == 0) {

            if($request->year > 0) {
                $students = Students::where('school_id',$schoolId)->where('year',$request->year)->get();
            } else {
                $students = Students::where('school_id',$schoolId)->get();
            }

            

            foreach($students as $student) {
                $products = Products::create(array_merge($request->all(), ['student_id' => $student->id,'school_id' => $schoolId,'slug' => Str::slug($request->title)]));

                $products->save();  
            }

        } else {

            $products = Products::create(array_merge($request->all(), ['slug' => Str::slug($request->title)]));

            foreach ($request->input('photos', []) as $file) {
                $products->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('photos');
            }

            $products->save();

        }

        //return redirect()->route('admin.students.index');

        //return redirect()->route('admin.students.index', ['schoolid' => $schoolId]);

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Products $product)
    {
        return view('backend.products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Products $product)
    {
        $studentId = $request->student_id;
        
        $product->update(array_merge($request->all(), ['slug' => Str::slug($request->title)]));

        if (count($product->photos) > 0) {
            foreach ($product->photos as $media) {
                if (!in_array($media->file_name, $request->input('photos', []))) {
                    $media->delete();
                }
            }
        }

        $media = $product->photos->pluck('file_name')->toArray();

        foreach ($request->input('photos', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $product->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('photos');
            }
        }

        $product->save();

        //return redirect()->back();
        return redirect()->route('admin.products.index', ['studentid' => $studentId]);
        //return redirect()->route('admin.products.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Products $product)
    {
        $product->delete();

        return back();
    }

    public function massdelete(Request $request)
    {
        $ids = $request->input('ids');
        Products::whereIn('id', $ids)->delete();
        return response()->json(['success' => true]);
    }

    public function delete(Products $product)
    {
        $product->delete();

        return back();
    }
}
