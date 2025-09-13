<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
        return view('pages.index');
    }

    public function aboutus()
    {
        return view('pages.aboutus');
    }

    public function contactus()
    {
        return view('pages.contactus');
    }

    // public function blogs()
    // {
    //     return view('pages.blogs');
    // }

    public function projects()
    {
        return view('pages.projects');
    }

    public function services()
    {
        return view('pages.services');
    }

    public function clients()
    {
        return view('pages.clients');
    }

    public function team()
    {
        return view('pages.team');
    }

    public function testimonials()
    {
        return view('pages.testimonials');
    }
}
