<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use Illuminate\Http\Request;
use App\Models\Services;
use App\Models\ServicePackages;
use App\Models\ServicePackageOptions;
use App\Models\ServicePackageAddons;
use Illuminate\Support\Str;
use Image;

class ServicesController extends Controller
{
    use MediaUploadingTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services = Services::get();

        return view('backend.services.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.services.create');
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
            Image::make($image)->save('upload/services/'.$name_gen);
            $save_url = 'upload/services/'.$name_gen;
        }

        $services = Services::create(array_merge($request->all(), ['slug' => Str::slug($request->title),'main_image' => $save_url]));

        foreach ($request->input('photos', []) as $file) {
            $services->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('photos');
        }

        $services->save();

        return redirect()->route('admin.services.index');
    }

    public function package(Request $request, $id)
    {
        //return $id;
        $packages=ServicePackages::where('service_id',$id)->get();
        return view('backend.services.service_package', compact('packages','id'));
    }

    public function addonsoptions(Request $request, $id)
    {
        //return $id;
        $packages=ServicePackages::where('service_id',$id)->get();
        return view('backend.services.service_package_options_addons', compact('packages','id'));
    }

    public function packageupdate(Request $request)
    {
        //return $request;
        $service_id = $request->service_id;

        if($request->has('package_name')) {
            $attr_count = count((array)array_filter($request->package_name));
            for ($i=0; $i < $attr_count; $i++) {
                if(isset($request->package_id[$i]) && $request->package_id[$i] > 0) {
                    $package_update = ServicePackages::findOrFail($request->package_id[$i]);
                
                    $package_update->service_id = $service_id;
                    $package_update->package_name = $request->package_name[$i] ?? '';
                    $package_update->about_package = $request->about_package[$i] ?? '';
                    $package_update->price = $request->price[$i] ?? '';
                    $package_update->duration = $request->duration[$i] ?? 0;
                    $package_update->most_liked = $request->most_liked[$i] ?? 0;
                    $package_update->save();

                    $package_id = $package_update->id;

                } else {
                    $package_add = new ServicePackages();
                    $package_add->service_id = $service_id;
                    $package_add->package_name = $request->package_name[$i] ?? '';
                    $package_add->about_package = $request->about_package[$i] ?? '';
                    $package_add->price = $request->price[$i] ?? '';
                    $package_add->duration = $request->duration[$i] ?? '';
                    $package_add->most_liked = $request->most_liked[$i] ?? 0;
                    $package_add->save();

                    $package_id = $package_add->id;
                }

                //if($request->has('addon_name')) {
                /*if( isset($request->addon_name[$package_id]) ) {
                    $addon_attr_count = count((array)array_filter($request->addon_name[$package_id]));
                    for ($k=0; $k < $addon_attr_count; $k++) {
                        if(isset($request->package_addons_id[$package_id][$k]) && $request->package_addons_id[$package_id][$k] > 0) {
                            $addon_update = ServicePackageAddons::findOrFail($request->package_addons_id[$package_id][$k]);
                        
                            $addon_update->service_id = $service_id;
                            $addon_update->service_package_id = $package_id ?? '';
                            $addon_update->addon_name = $request->addon_name[$package_id][$k] ?? '';
                            $addon_update->addon_price = $request->addon_price[$package_id][$k] ?? '';
                            $addon_update->save();

                        } else {
                            $addon_add = new ServicePackageAddons();
                            $addon_add->service_id = $service_id;
                            $addon_add->service_package_id = $package_id ?? '';
                            $addon_add->addon_name = $request->addon_name[$package_id][$k] ?? '';
                            $addon_add->addon_price = $request->addon_price[$package_id][$k] ?? '';
                            $addon_add->save();
                        }
                    }
                }

                if( isset($request->option_name[$package_id]) ) {
                    $option_attr_count = count((array)array_filter($request->option_name[$package_id]));
                    for ($k=0; $k < $option_attr_count; $k++) {
                        if(isset($request->package_options_id[$package_id][$k]) && $request->package_options_id[$package_id][$k] > 0) {
                            $option_update = ServicePackageOptions::findOrFail($request->package_options_id[$package_id][$k]);
                        
                            $option_update->service_id = $service_id;
                            $option_update->service_package_id = $package_id ?? '';
                            $option_update->option_name = $request->option_name[$package_id][$k] ?? '';
                            $option_update->option_price = $request->option_price[$package_id][$k] ?? '';
                            $option_update->save();

                        } else {
                            $option_add = new ServicePackageOptions();
                            $option_add->service_id = $service_id;
                            $option_add->service_package_id = $package_id ?? '';
                            $option_add->option_name = $request->option_name[$package_id][$k] ?? '';
                            $option_add->option_price = $request->option_price[$package_id][$k] ?? '';
                            $option_add->save();
                        }
                    }
                }*/
            }
        }

        return redirect()->route('admin.services.index');

    }

    public function optionsaddonupdate(Request $request)
    {
        //return $request;
        $service_id = $request->service_id;

        if($request->has('package_name')) {
            $attr_count = count((array)array_filter($request->package_name));
            for ($i=0; $i < $attr_count; $i++) {
                $package_id = $request->package_id[$i];
                //if($request->has('addon_name')) {
                if( isset($request->addon_name[$package_id]) ) {
                    $addon_attr_count = count((array)array_filter($request->addon_name[$package_id]));
                    for ($k=0; $k < $addon_attr_count; $k++) {
                        if(isset($request->package_addons_id[$package_id][$k]) && $request->package_addons_id[$package_id][$k] > 0) {
                            $addon_update = ServicePackageAddons::findOrFail($request->package_addons_id[$package_id][$k]);
                        
                            $addon_update->service_id = $service_id;
                            $addon_update->service_package_id = $package_id ?? '';
                            $addon_update->addon_name = $request->addon_name[$package_id][$k] ?? '';
                            $addon_update->addon_price = $request->addon_price[$package_id][$k] ?? '';
                            $addon_update->save();

                        } else {
                            $addon_add = new ServicePackageAddons();
                            $addon_add->service_id = $service_id;
                            $addon_add->service_package_id = $package_id ?? '';
                            $addon_add->addon_name = $request->addon_name[$package_id][$k] ?? '';
                            $addon_add->addon_price = $request->addon_price[$package_id][$k] ?? '';
                            $addon_add->save();
                        }
                    }
                }

                if( isset($request->option_name[$package_id]) ) {
                    $option_attr_count = count((array)array_filter($request->option_name[$package_id]));
                    for ($k=0; $k < $option_attr_count; $k++) {
                        if(isset($request->package_options_id[$package_id][$k]) && $request->package_options_id[$package_id][$k] > 0) {
                            $option_update = ServicePackageOptions::findOrFail($request->package_options_id[$package_id][$k]);
                        
                            $option_update->service_id = $service_id;
                            $option_update->service_package_id = $package_id ?? '';
                            $option_update->option_name = $request->option_name[$package_id][$k] ?? '';
                            $option_update->option_price = $request->option_price[$package_id][$k] ?? '';
                            $option_update->save();

                        } else {
                            $option_add = new ServicePackageOptions();
                            $option_add->service_id = $service_id;
                            $option_add->service_package_id = $package_id ?? '';
                            $option_add->option_name = $request->option_name[$package_id][$k] ?? '';
                            $option_add->option_price = $request->option_price[$package_id][$k] ?? '';
                            $option_add->save();
                        }
                    }
                }
            }
        }

        return redirect()->route('admin.services.index');

    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Services  $services
     * @return \Illuminate\Http\Response
     */
    public function show(Services $service)
    {
        return view('backend.services.show', compact('service'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Services  $services
     * @return \Illuminate\Http\Response
     */
    public function edit(Services $service)
    {
        return view('backend.services.edit', compact('service'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Services  $service
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Services $service)
    {
        $id = $request->id;
        $old_img = $request->old_image;

        if ($request->file('image')) {

            $image = $request->file('image');
            $name_gen = time().rand(1,50).'.'.$image->getClientOriginalExtension();
            Image::make($image)->save('upload/services/'.$name_gen);
            $save_url = 'upload/services/'.$name_gen;

            if (file_exists($old_img)) {
               unlink($old_img);
            }

            $service->update(array_merge($request->all(), ['slug' => Str::slug($request->title), 'main_image' => $save_url]));

        } else {

            $service->update(array_merge($request->all(), ['slug' => Str::slug($request->title)]));

        }

        

        if (count($service->photos) > 0) {
            foreach ($service->photos as $media) {
                if (!in_array($media->file_name, $request->input('photos', []))) {
                    $media->delete();
                }
            }
        }

        $media = $service->photos->pluck('file_name')->toArray();

        foreach ($request->input('photos', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $service->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('photos');
            }
        }

        $service->save();

        return redirect()->route('admin.services.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Services  $service
     * @return \Illuminate\Http\Response
     */
    public function destroy(Services $service)
    {
        $service->delete();

        return back();
    }

    public function massDestroy(Request $request)
    {
        Services::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    


}
