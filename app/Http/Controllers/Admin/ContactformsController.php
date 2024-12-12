<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use Illuminate\Http\Request;
use App\Models\ContactForm;
use Illuminate\Support\Str;

class ContactformsController extends Controller
{
    use MediaUploadingTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contactforms = ContactForm::get();

        return view('backend.contactforms.index', compact('contactforms'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.contactforms.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $contactforms = ContactForm::create(array_merge($request->all(), ['slug' => Str::slug($request->name)]));

        $contactforms->save();

        return redirect()->route('admin.contactforms.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ContactForm  $contactforms
     * @return \Illuminate\Http\Response
     */
    public function show(ContactForm $contactform)
    {
        return view('backend.contactforms.show', compact('contactform'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ContactForm  $contactforms
     * @return \Illuminate\Http\Response
     */
    public function edit(ContactForm $contactform)
    {
        return view('backend.contactforms.edit', compact('contactform'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ContactForm  $contactforms
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ContactForm $contactform)
    {
        $contactform->update(array_merge($request->all(), ['slug' => Str::slug($request->name)]));

        /*if (count($contactform->photos) > 0) {
            foreach ($contactform->photos as $media) {
                if (!in_array($media->file_name, $request->input('photos', []))) {
                    $media->delete();
                }
            }
        }

        $media = $contactform->photos->pluck('file_name')->toArray();

        foreach ($request->input('photos', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $contactform->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('photos');
            }
        }*/

        $contactform->save();

        return redirect()->route('admin.contactforms.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ContactForm  $contactforms
     * @return \Illuminate\Http\Response
     */
    public function destroy(ContactForm $contactform)
    {
        $contactform->delete();

        return back();
    }

    public function massDestroy(Request $request)
    {
        ContactForm::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    


}
