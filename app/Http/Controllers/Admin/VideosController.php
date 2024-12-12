<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use Illuminate\Http\Request;
use App\Models\PortfolioVideos;
use Illuminate\Support\Str;
use App\Models\Media;

class VideosController extends Controller
{
    use MediaUploadingTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $videos = PortfolioVideos::get();
        return view('backend.videos.index', compact('videos'));
        
        //$portfolios = Portfolios::where('type','video')->get();

        //return view('backend.videos.index', compact('portfolios'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.videos.create');
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
        $request->validate([
            'title' => 'required|string',
            'video' => 'required|mimes:mp4,mov,avi',
        ]);

        $video_url = null;
        $video = $request->file('video');
        if ($video) {
            $name_gen = time().rand(1,50).'.'.$video->getClientOriginalExtension();
            $video->move('upload/videos/', $name_gen);
            $video_url = 'upload/videos/'.$name_gen;
            $mime_type = $video->getClientmimeType();
        }

        $portfolios = new PortfolioVideos();
        $portfolios->title = $request->title;
        $portfolios->video = $video_url;
        $portfolios->mime_type = $mime_type;
        $portfolios->save();

        return redirect()->route('admin.videos.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Portfolios  $portfolios
     * @return \Illuminate\Http\Response
     */
    public function show(Portfolios $video)
    {
        return view('backend.videos.show', compact('video'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Portfolios  $portfolios
     * @return \Illuminate\Http\Response
     */
    public function edit(PortfolioVideos $video)
    {
        return view('backend.videos.edit', compact('video'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Portfolios  $portfolio
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PortfolioVideos $portfolio)
    {
        $request->validate([
            'title' => 'required|string',
        ]);
        //$portfolio->update(array_merge($request->all(), ['slug' => Str::slug($request->name)]));

        $portfolio = PortfolioVideos::find($request->id);
        $portfolio->title = $request->title;
        
        if ($request->hasFile('video')) {
            $request->validate([
                'videos.*' => 'required|mimes:mp4,mov,avi',
            ]);
            $video = $request->file('video');
            if ($video) {
                $name_gen = time().rand(1,50).'.'.$video->getClientOriginalExtension();
                $video->move('upload/videos/', $name_gen);
                $video_url = 'upload/videos/'.$name_gen;
                $mime_type = $video->getClientmimeType();
                $portfolio->video = $video_url;
                $portfolio->mime_type = $mime_type;
            }
            
        }


        $portfolio->save();


        return redirect()->route('admin.videos.index');
    }




    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Portfolios  $portfolio
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, PortfolioVideos $video)
    {
        $video->delete();

        return back();
    }

    public function massDestroy(Request $request)
    {
        PortfolioVideos::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    
    public function ajaxDelete(Request $request, $id)
    {
        $video = Media::findOrFail($id);
        $video->delete();

        return response()->json(['message' => 'Video deleted successfully']);
    }

}
