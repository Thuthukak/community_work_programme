<?php

namespace App\Http\Controllers\CRM\ContactUs;

use Illuminate\Http\Request;
use App\Models\CRM\Social\Social;
use App\Models\CRM\ContactUs\Contact;
use App\Http\Controllers\Controller;
use App\Models\CRM\GeneralSettings\GeneralSetting;



class ContactController extends Controller
{
    public function index()
    {
    	$socials = Social::all();
        $gs = GeneralSetting::first();
        
    	return view('crm.contactus.contact', compact('socials','gs'));
    }

    public function store(Request $request)
    {
    	$this->validate($request,[
    		'name' => 'required',
    		'phone' => 'required',
    		'email' => 'required|email',
    		'message' => 'required'
    	]);

    	$contact = Contact::create($request->all());

        if ($contact) {
            $notify = storeNotify('Your message submitted');
        }else{
            $notify = errorNotify('Your contact message submit fail!');
        }

    	return redirect()->back()->with($notify);
    }
}
