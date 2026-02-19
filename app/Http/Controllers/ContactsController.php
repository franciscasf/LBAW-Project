<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactsController extends Controller
{
    public function showContacts(){
        $data = array(
            'title' => "Contact Us",
            'contacts' => ['eu', 'tu', 'ela', 'outra ela']   
        );
        return view('pages.static.contacts') -> with($data);
    }
}
