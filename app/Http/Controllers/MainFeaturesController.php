<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainFeaturesController extends Controller
{
    public function showMainFeatures(){
        $title = "Main Features";
        return view('pages.static.mainFeatures') -> with('title',$title);
    }
}
