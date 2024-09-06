<?php

namespace App\Http\Controllers\Core;

use App\Models\CRM\Service\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use App\Models\CRM\Socials\Social;
use App\Models\CRM\GeneralSettings\GeneralSetting;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Artisan;

class GeneralSettingController extends Controller
{
    public function logoIcon()
    {
        return view('frontendSetting.logoIcon');
    }

    public function logoIconUpdate(Request $request) {

        $this->validate($request,[
            'logo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'favicon_icon' => 'image|mimes:jpeg,png,jpg,gif,svg|max:1048',
        ]);

        $setting = GeneralSetting::first();

        if ($request->hasFile('logo')) {
            $oldImage = $setting->logo;
            $image = $request->file('logo');
            $setting->logo = storeOriginalImage($image, 'uploads/logo');
            if ($oldImage)
                Storage::delete("/public/" . $oldImage);
        }

        if ($request->hasFile('favicon_icon')) {
            $oldImage = $setting->favicon_icon;
            $image = $request->file('favicon_icon');
            $setting->favicon_icon = storeOriginalImage($image, 'uploads/logo');
            if ($oldImage)
                Storage::delete("/public/" . $oldImage);
        }

        if ($setting->save()) {
            $notify = updateNotify('Logo');
        }else{
            $notify = errorNotify('Logo update');
        }

        return back()->with($notify);
    }

    public function social()
    {
        $socialList = Social::all();
        return view('frontendSetting.socialLink', compact('socialList'));
    }

    public function socialAdd(Request $request, Social $social) {

        $request->validate([
            'name' => 'required|unique:socials|max:150',
            'code' => 'required|unique:socials|max:150',
            'link' => 'required|max:150',
        ]);

        $data = $request->all();

        $saved = $social->create($data);

        if ($saved) {
            $notify = storeNotify('Social media');
        }else{
            $notify = errorNotify('Social media add');
        }

        return back()->with($notify);
    }

    public function socialUpdate(Request $request, Social $social) {

        $request->validate([
            'name' => ['required',
                Rule::unique('socials')->ignore($social->id), 'max:150',
            ],
            'code' => ['required',
                Rule::unique('socials')->ignore($social->id), 'max:150',
            ],
            'link' => 'required|max:150',
        ]);

        $data = $request->all();

        $saved = $social->update($data);

        if ($saved) {
            $notify = updateNotify('Social media');
        }else{
            $notify = errorNotify('Social media update');
        }

        return back()->with($notify);
    }

    public function socialDestroy($id)
    {
        $done = Social::destroy($id);

        if ($done) {
            $notify = deleteNotify('Social media');
        }else{
            $notify = errorNotify('Social media delete');
        }

        return back()->with($notify);
    }

    public function headerTextSetting()
    {
        $setting = GeneralSetting::first();

        return view('frontendSetting.headerText', compact('setting'));
    }

    public function headerTextSettingUpdate(Request $request, GeneralSetting $setting)
    {
        $data = $request->all();
        $saved = $setting->update($data);

        if ($saved) {
            $notify = updateNotify('Information');
        }else{
            $notify = errorNotify('Information update');
        }

        return back()->with($notify);
    }

    public function aboutus()
    {
        $setting = GeneralSetting::first();
        return view('frontendSetting.aboutus', compact('setting'));
    }

    public function updateAboutUs(Request $request)
    {
        $request->validate([
            'aboutus_title' => 'max:255',
            'aboutus_details' => 'required',
        ]);


        if ($request->hasFile('aboutus_image')) {
            $image = $request->aboutus_image;
            $imageObj = Image::make($image);
            $imageObj->resize(530, 400)->save(public_path('images/bg/about_details.jpg'));
        }

        $id = $request->get('id');
        $setting = GeneralSetting::find($id);
        $data = $request->only('aboutus_title','aboutus_details');
        $saved = $setting->update($data);

        if ($saved) {
            Artisan::call('cache:clear');
            $notify = updateNotify('Information');
        }else{
            $notify = errorNotify('Information update');
        }

        //cache clear
        Artisan::call('cache:clear');

        return back()->with($notify);
    }

    public function contactus() {
        $setting = GeneralSetting::first();
        return view('frontendSetting.contactus', compact('setting'));
    }

    public function updateContactus(Request $request) {

        $request->validate([
            'contact_title' => 'max:255',
            'contact_phone' => 'max:255',
            'contact_email' => 'email|string|max:255',
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

    public function footer() {
        $setting = GeneralSetting::first();
        return view('frontendSetting.footer', compact('setting'));
    }

    public function updateFooter(Request $request) {

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

    public function services() {
        $setting = GeneralSetting::first();
        $servicesList = Service::all();
        return view('frontendSetting.service', compact('setting', 'servicesList'));
    }

    public function servicesUpdate(Request $request)
    {
        $request->validate([
            'service_title' => 'required|max:255',
        ]);
        $setting = GeneralSetting::first();
        $data = $request->all();
        $saved = $setting->update($data);

        if ($saved) {
            $notify = updateNotify('Service');
        }else{
            $notify = errorNotify('Service update');
        }

        return back()->with($notify);
    }

    public function storeNewServices(Request $request, Service $service) {
        $request->validate([
            'title' => 'required',
            'icon' => 'required|max:150',
        ]);

        $data = $request->all();
        $saved = Service::create($data);
        
        if ($saved) {
            $notify = storeNotify('Service');
        }else{
            $notify = errorNotify('Service update');
        }

        return back()->with($notify);
    }

    public function updateNewServices(Request $request, Service $services) {
        $request->validate([
            'title' => 'required',
            'icon' => 'required|max:150',
        ]);

        $data = $request->all();

        $saved = $services->update($data);

        if ($saved) {
            $notify = updateNotify('Information');
        }else{
            $notify = errorNotify('Information update');
        }

        return back()->with($notify);
    }

    public function deleteServices($id) {
        $done = Service::destroy($id);

        if ($done) {
            $notify = deleteNotify('Knowledge base');
        }else{
            $notify = errorNotify('Knowledge base delete');
        }

        return back()->with($notify);
    }

    public function counter() {
        $setting = GeneralSetting::first();
        return view('frontendSetting.counter', compact('setting'));
    }

    public function updateCounter(Request $request, GeneralSetting $setting) {
        $request->validate([
            'ticket_counter' => 'required',
            'ticket_solved' => 'required',
            'kb_counter' => 'required',
            'client_counter' => 'required',
        ]);
        
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
