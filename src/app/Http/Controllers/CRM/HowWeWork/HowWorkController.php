<?php

namespace App\Http\Controllers\CRM\HowWeWork;

use App\Http\Controllers\Controller;
use App\Models\CRM\GeneralSettings\GeneralSetting;
use App\Models\CRM\HowWork\HowWork;
use Illuminate\Http\Request;

class HowWorkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $setting = GeneralSetting::first();
        $works = HowWork::paginate(10);

        return response()->json([
            'setting' => $setting,
            'works' => $works

        ]);
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
        return back();
        /*$request->validate([
            'title' => 'required',
            'icon' => 'required',
            'details' => 'required|max:150',
        ]);

        $data = $request->all();
        $saved = HowWork::create($data);

        if ($saved) {
            $notify = storeNotify('Information');
        }else{
            $notify = errorNotify('Information save');
        }

        return back()->with($notify);*/
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param HowWork $work
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();

        $work = HowWork::findOrFail($id);

        $saved = $work->update($data);

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
    public function destroy($id)
    {
        $done = HowWork::destroy($id);

        if ($done) {
            $notify = deleteNotify('Information');
        }else{
            $notify = errorNotify('Information delete');
        }

        return back()->with($notify);
    }

    public function howWorkUpdate(Request $request) {
        $request->validate([
            'how_work_title' => 'required',
            'how_work_details' => 'required',
        ]);

        $setting = GeneralSetting::first();
        $data = $request->all();
        $saved = $setting->update($data);

        if ($saved) {
            $notify = updateNotify('Information');
        }else{
            $notify = errorNotify('Information update');
        }

        return back()->with($notify);
    }
}
