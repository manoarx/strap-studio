<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Models\Products;
use App\Models\Students;
use Illuminate\Support\Str;

class BulkProductsController extends Controller
{
    use MediaUploadingTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $schoolid = $request->schoolid;

        $commonProductIds = Products::selectRaw('GROUP_CONCAT(id) as ids')
            ->groupBy('title', 'slug', 'digital_title', 'digital_amount')
            ->havingRaw('COUNT(*) > 0') // Change the condition here
            ->where('school_id', $schoolid) // Additional condition for school_id
            ->pluck('ids')
            ->toArray();

        $products = Products::whereIn('id', $commonProductIds)
            ->where('school_id', $schoolid)
            ->get();

        return view('backend.bulkproducts.index', compact('products'));
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
        $schoolId = $request->school_id;

        if($request->student_id == 0) {

            $students = Students::where('school_id',$schoolId)->get();

            foreach($students as $student) {
                $products = Products::create(array_merge($request->all(), ['student_id' => $student->id,'slug' => Str::slug($request->title)]));

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
    /*public function edit(Request $request, Products $product)
    {
        return $request;
        return view('backend.bulkproducts.edit', compact('product'));
    }*/

    public function editproduct($id)
    {
        $product = Products::where('id',$id)->first();
        return view('backend.bulkproducts.edit', compact('product'));
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
        $schoolId = $request->school_id;
        $productId = $request->product_id;

        $cproduct = Products::where('id',$productId)->first();

        $commonProductIds = Products::selectRaw('GROUP_CONCAT(id) as ids')
            ->groupBy('title', 'hard_copy_amount', 'digital_title', 'digital_amount')
            ->havingRaw('COUNT(*) > 0') // Change the condition here
            ->where('school_id', $schoolId) // Additional condition for school_id
            ->pluck('ids')
            ->toArray();

        $products = Products::where('school_id',$schoolId)->where('title',$cproduct->title)->where('slug',$cproduct->slug)->where('digital_title',$cproduct->digital_title)->where('digital_amount',$cproduct->digital_amount)->where('desc',$cproduct->desc)->get();
        
        foreach($products as $product) {
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
        }    

        //return redirect()->back();
        return redirect()->route('admin.bulkproducts.index', ['schoolid' => $schoolId]);
        //return redirect()->route('admin.products.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteproduct($productId)
    {
        $cproduct = Products::where('id',$productId)->first();

        $schoolId = $cproduct->school_id;

        $commonProductIds = Products::selectRaw('GROUP_CONCAT(id) as ids')
            ->groupBy('title', 'slug', 'digital_title', 'digital_amount', 'desc')
            ->havingRaw('COUNT(*) > 0') // Change the condition here
            ->where('school_id', $schoolId) // Additional condition for school_id
            ->pluck('ids')
            ->toArray();

        $products = Products::whereIn('id', $commonProductIds)->where('school_id',$schoolId)->where('title',$cproduct->title)->where('slug',$cproduct->slug)->where('digital_title',$cproduct->digital_title)->where('digital_amount',$cproduct->digital_amount)->where('desc',$cproduct->desc)->get();
        
        foreach($products as $product) {
            $product->delete();
        }

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

    public function bulkproductsstudents($productId)
    {
        $cproduct = Products::where('id',$productId)->first();

        $schoolId = $cproduct->school_id;

        $commonProductIds = Products::selectRaw('GROUP_CONCAT(id) as ids')
            ->groupBy('title', 'slug', 'digital_title', 'digital_amount', 'desc')
            ->havingRaw('COUNT(*) > 0') // Change the condition here
            ->where('school_id', $schoolId) // Additional condition for school_id
            ->pluck('ids')
            ->toArray();

        $products = Products::where('school_id',$schoolId)->where('title',$cproduct->title)->where('slug',$cproduct->slug)->where('digital_title',$cproduct->digital_title)->where('digital_amount',$cproduct->digital_amount)->get();
        return view('backend.bulkproducts.students', compact('products'));
    }
}
