<?php

namespace DavideCasiraghi\ResponsiveGallery\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use DavideCasiraghi\ResponsiveGallery\Models\GalleryImage;
use DavideCasiraghi\ResponsiveGallery\Facades\ResponsiveGallery;

class ResponsiveGalleryController
{
    
    /***************************************************************************/

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $searchKeywords = $request->input('keywords');

        if ($searchKeywords) {
            $galleryImages = GalleryImage::orderBy('file_name')
                                    ->where('file_name', 'like', '%'.$request->input('keywords').'%')
                                    ->paginate(20);
        } else {
            $galleryImages = GalleryImage::orderBy('file_name')
                                    ->paginate(20);
        }

        return view('vendor.laravel-responsive-gallery.index', compact('galleryImages'))
                            ->with('i', (request()->input('page', 1) - 1) * 20)
                            ->with('searchKeywords', $searchKeywords);
    }

    /***************************************************************************/

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('laravel-responsive-gallery::create');
    }

    /***************************************************************************/

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // Validate form datas
        $validator = Validator::make($request->all(), [
                    'file_name' => 'required',
                ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $gallery_image = new GalleryImage();
        $gallery_image->file_name = $request->get('file_name');
        $gallery_image->description = $request->get('description');
        $gallery_image->alt = $request->get('alt');
        $gallery_image->video_link = $request->get('video_link');

        $gallery_image->save();

        return redirect()->route('responsive-gallery.index')
                            ->with('success', 'Image datas added succesfully');
    }

    /***************************************************************************/

    /**
     * Display the specified resource.
     *
     * @param  \App\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function show($id = null)
    {
        $galleryImage = GalleryImage::find($id);
        return view('laravel-responsive-gallery::show', compact('galleryImage'));
    }

    /***************************************************************************/

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function edit($id = null)
    {
        $galleryImage = GalleryImage::find($id);

        return view('laravel-responsive-gallery::edit', compact('galleryImage'));
    }

    /***************************************************************************/

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        /*request()->validate([
                'file_name' => 'required',
            ]);*/

        $galleryImage = GalleryImage::find($id);
        
        $galleryImage->update($request->all());

        return redirect()->route('responsive-gallery.index')
                            ->with('success', 'Image datas updated succesfully');
    }

    /***************************************************************************/

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $galleryImage = GalleryImage::find($id);
        $galleryImage->delete();

        return redirect()->route('responsive-gallery.index')
                            ->with('success', 'Image datas deleted succesfully');
    }
}
