<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::all(); 
        return view('pages.admin.manageTags', compact('tags'));
    }


    public function create()
    {
        return view('pages.admin.createTag');
    }


    public function store(Request $request)
{
    $messages = [
        'acronym.unique' => 'This acronym is already in use. Please choose a different one.',
        'full_name.unique' => 'This tag name is already in use. Please choose a different one.',
    ];

    $validated = $request->validate([
        'acronym' => 'required|string|max:20|unique:tag,acronym',
        'full_name' => 'required|string|max:100|unique:tag,full_name',
        'description' => 'nullable|string|max:300',
    ], $messages);

    Tag::create($validated);

    return redirect()->route('admin.tags.manage')->with('success', 'Tag created successfully!');
}



    public function edit($id)
    {
        $tag = Tag::findOrFail($id);
        return view('pages.admin.editTag', compact('tag'));
    }


    public function update(Request $request, $id)
{
    $messages = [
        'acronym.unique' => 'This acronym is already in use. Please choose a different one.',
        'full_name.unique' => 'This tag name is already in use. Please choose a different one.',
    ];

    $validated = $request->validate([
        'acronym' => 'required|string|max:20|unique:tag,acronym,' . $id . ',tag_id',
        'full_name' => 'required|string|max:100|unique:tag,full_name,' . $id . ',tag_id',
        'description' => 'nullable|string|max:300',
    ], $messages);

    $validated['description'] = $validated['description'] ?? '';

    $tag = Tag::findOrFail($id);
    $tag->update($validated);

    return redirect()->route('admin.tags.manage')->with('success', 'Tag updated successfully!');
}

    public function destroy($id)
    {
        $tag = Tag::findOrFail($id);
        $tag->delete();

        return redirect()->route('admin.tags.manage')->with('success', 'Tag deleted successfully!');
    }
}
