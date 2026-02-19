<?php

namespace App\Http\Controllers;

use App\Models\Badge;
use Illuminate\Http\Request;

class BadgeController extends Controller
{
    // Lista todos os badges
    public function index()
{
    $badges = Badge::all();
    return view('pages.admin.manageBadges', compact('badges'));
}

    
    // Armazena um novo badge
    public function store(Request $request)
    {
        $messages = [
            'name.unique' => 'This badge name already exists. Please choose a different name.',
        ];

        
        $request->validate([
            'name' => 'required|string|max:255|unique:badge,name',
            'description' => 'required|string|max:1000',
        ]);
        

        // Criação do badge
        Badge::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.badges.manage')->with('success', 'Badge created successfully!');
    }


    // formulário 
    public function edit($id)
    {
        $badges = Badge::all(); 
        $editBadge = Badge::findOrFail($id); 
        return view('pages.admin.manageBadges', compact('badges', 'editBadge'));
    }

    public function update(Request $request, $id)
    {
        $messages = [
            'name.unique' => 'This badge name already exists. Please choose a different name.',
        ];


        $request->validate([
            'name' => 'required|string|max:255|unique:badge,name,' . $id . ',badge_id',
            'description' => 'required|string|max:1000',
        ]);

        $badge = Badge::findOrFail($id);
        $badge->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.badges.manage')->with('success', 'Badge updated successfully!');
    }

    // Excluir um badge
    public function destroy($id)
{
    $badge = Badge::findOrFail($id); 
    $badge->delete(); 

    return redirect()->route('admin.badges.manage')->with('success', 'Badge deleted successfully!');
}

}
