<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
        return view('pages.index');
    }

    public function about()
    {
        return view('pages.about');
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function blog()
    {
        return view('pages.blog');
    }

    public function project()
    {
        return view('pages.project');
    }

    public function service()
    {
        return view('pages.service');
    }

    public function client()
    {
        return view('pages.client');
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
