<?php

namespace App\Http\Controllers\Core;

use App\Models\CRM\HowWork\HowWork;
use Illuminate\Http\Request;
use App\Models\CRM\Testimonial\Testimonial;
use App\Models\CRM\Service\Service;
use App\Models\CRM\Departments\Department;
use App\Http\Controllers\Controller;
use App\Models\CRM\GeneralSettings\GeneralSetting;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $testimonials = Testimonial::all();
        $services = Service::all();
        $departments = Department::inRandomOrder()->limit(6)->get();
        $works = HowWork::latest()->limit(3)->get();
        $gs = GeneralSetting::first();

// dd($gs);git 
        return view('welcome', compact('testimonials','services','departments','works' ,'gs'));
    }

    public function aboutusPage()
    {

        $gs = GeneralSetting::first();

        return view('tickets.aboutus' , compact('gs'));
    }

    public function frontend()
    {

        return view('tickets.frontendsettings');
    }
}
