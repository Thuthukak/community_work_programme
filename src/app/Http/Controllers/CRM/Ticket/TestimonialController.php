<?php

namespace App\Http\Controllers\CRM\Ticket;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use App\Models\CRM\Testimonial\Testimonial;
use App\Models\CRM\GeneralSettings\GeneralSetting;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;


class TestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $setting = GeneralSetting::first();
        $testimonials = Testimonial::paginate(10);

        return response()->json([
            'setting' => $setting,
            'testimonials' => $testimonials,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Testimonial $testimonial)
    {

        $request->validate([
            'name' => 'required|max:255',
            'designation' => 'max:255',
            'comment' => 'required',
            'image' => 'required|image|mimes:jpeg,jpg,png',
        ]);
        $data = $request->all();


        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $data['image'] = storeImage($image, 'uploads/testimonials',352, 352);
        }

        $saved = $testimonial->create($data);

        if ($saved) {
            $notify = updateNotify('Information');
        }else{
            $notify = errorNotify('Information save');
        }

        return back()->with($notify);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Testimonial $testimonial) {

        $request->validate([
            'name' => 'required|max:255',
            'designation' => 'max:255',
            'comment' => 'required',
            'image' => 'image|mimes:jpeg,jpg,png',
        ]);

        $data = $request->all();
        Log::info($request);

        if ($request->hasFile('image')) {
            if (!$testimonial->image == 'images/testimonials/testimonial.png'){
                if ($testimonial->image) {
                    unlink( symImagePath().$testimonial->image);
                }
            }

            $image = $request->image;
            $data['image'] = storeImage($image, 'uploads/testimonials',352, 352);
        }

        $saved = $testimonial->update($data);

        if ($saved) {
            $notify = updateNotify('Information');
        }else{
            $notify = errorNotify('Information update');
        }

        return back()->with($notify);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function testimonialUpdate(Request $request) {
        $request->validate([
            'testimonial_title' => 'required|max:255',
        ]);

        $id = $request->get('id');
        $setting = GeneralSetting::find($id);
        
        $data = $request->all();
        $saved = $setting->update($data);

        if ($saved) {
            $notify = updateNotify('Information');
        }else{
            $notify = errorNotify('Information update');
        }

        return back()->with($notify);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Testimonial $testimonial) {

        if ($testimonial->image) {
            Storage::delete($testimonial->image);
        }
        $done = Testimonial::destroy($testimonial->id);

        if ($done) {
            $notify = deleteNotify('Information');
        }else{
            $notify = errorNotify('Information delete');
        }

        return back()->with($notify);
    }
}
