<?php

namespace App\Http\Controllers;


class HomeController extends Controller
{
    public function index()
    {
        return view('Students\home');
    }

    public function adminHome()
    {
        return view('admin.home');
    }

}

