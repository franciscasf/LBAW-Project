<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function showAbout(){
        $title = "About Us";
        return view('pages.static.about') -> with('title', $title);
    }
}
