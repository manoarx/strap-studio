<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use Illuminate\Http\Request;
use App\Models\Portfolios;
use App\Models\PortfolioVideos;
use Illuminate\Support\Str;

class PortfoliosController extends Controller
{
    use MediaUploadingTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $portfolios = Portfolios::where('type','image')->get();

        return view('backend.portfolios.index', compact('portfolios'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.portfolios.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $portfolios = Portfolios::create(array_merge($request->all(), ['slug' => Str::slug($request->name)]));

        foreach ($request->input('photos', []) as $file) {
            $portfolios->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('photos');
        }

        $portfolios->save();

        return redirect()->route('admin.portfolios.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Portfolios  $portfolios
     * @return \Illuminate\Http\Response
     */
    public function show(Portfolios $portfolio)
    {
        return view('backend.portfolios.show', compact('portfolio'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Portfolios  $portfolios
     * @return \Illuminate\Http\Response
     */
    public function edit(Portfolios $portfolio)
    {
        return view('backend.portfolios.edit', compact('portfolio'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Portfolios  $portfolio
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Portfolios $portfolio)
    {
        $portfolio->update(array_merge($request->all(), ['slug' => Str::slug($request->name)]));

        //if($request->type == 'image') {
            if (count($portfolio->photos) > 0) {
                foreach ($portfolio->photos as $media) {
                    if (!in_array($media->file_name, $request->input('photos', []))) {
                        $media->delete();
                    }
                }
            }

            $media = $portfolio->photos->pluck('file_name')->toArray();

            foreach ($request->input('photos', []) as $file) {
                if (count($media) === 0 || !in_array($file, $media)) {
                    $portfolio->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('photos');
                }
            }
        /*} else {    // IF VIDEOS
            $portfolio_id = $request->portfolio_id;

            if($request->has('youtube_url')) {
                $attr_count = count((array)array_filter($request->youtube_url));
                for ($i=0; $i < $attr_count; $i++) {
                    if(isset($request->portfolio_video_id[$i]) && $request->portfolio_video_id[$i] > 0) {
                        $package_update = PortfolioVideos::findOrFail($request->portfolio_video_id[$i]);
                        $package_update->portfolio_id = $portfolio_id;
                        $package_update->youtube_url = $request->youtube_url[$i] ?? '';
                        $package_update->save();

                        $package_id = $package_update->id;

                    } else {
                        $package_add = new PortfolioVideos();
                        $package_add->portfolio_id = $portfolio_id;
                        $package_add->youtube_url = $request->youtube_url[$i] ?? '';
                        $package_add->save();

                        $package_id = $package_add->id;
                    }
                }
            }
        }*/

        $portfolio->save();

        return redirect()->route('admin.portfolios.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Portfolios  $portfolio
     * @return \Illuminate\Http\Response
     */
    public function destroy(Portfolios $portfolio)
    {
        $portfolio->delete();

        return back();
    }

    public function massDestroy(Request $request)
    {
        Portfolios::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    


}
