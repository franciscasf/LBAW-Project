<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SuggestionController extends Controller
{
    public function create()
    {
        return view('suggestions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'suggestion' => 'required|string|max:1000',
        ]);

        return back()->with('success', 'Thank you for your suggestion!');
    }
}
