<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use Illuminate\Http\Request;
use App\Models\Workshops;
use Illuminate\Support\Str;

class WorkshopsController extends Controller
{
    use MediaUploadingTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $workshops = Workshops::get();

        return view('backend.workshops.index', compact('workshops'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.workshops.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $workshops = Workshops::create(array_merge($request->all(), ['slug' => Str::slug($request->title)]));

        foreach ($request->input('photos', []) as $file) {
            $workshops->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('photos');
        }

        $workshops->save();

        return redirect()->route('admin.workshops.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Workshops  $workshops
     * @return \Illuminate\Http\Response
     */
    public function show(Workshops $workshop)
    {
        return view('backend.workshops.show', compact('workshop'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Workshops  $workshops
     * @return \Illuminate\Http\Response
     */
    public function edit(Workshops $workshop)
    {
        return view('backend.workshops.edit', compact('workshop'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Workshops  $workshop
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Workshops $workshop)
    {
        $workshop->update(array_merge($request->all(), ['slug' => Str::slug($request->title)]));

        if (count($workshop->photos) > 0) {
            foreach ($workshop->photos as $media) {
                if (!in_array($media->file_name, $request->input('photos', []))) {
                    $media->delete();
                }
            }
        }

        $media = $workshop->photos->pluck('file_name')->toArray();

        foreach ($request->input('photos', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $workshop->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('photos');
            }
        }

        $workshop->save();

        return redirect()->route('admin.workshops.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Workshops  $workshop
     * @return \Illuminate\Http\Response
     */
    public function destroy(Workshops $workshop)
    {
        $workshop->delete();

        return back();
    }

    public function massDestroy(Request $request)
    {
        Workshops::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    


}
