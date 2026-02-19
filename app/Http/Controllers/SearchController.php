<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\User;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $search = $request->input('search');
        $filter = $request->input('filter', 'all');

        if (empty($search)) {
            return redirect()->back()->with('error', 'Search term cannot be empty.');
        }

        $questions = collect();
        $users = collect();

        if ($filter === 'all' || $filter === 'questions') {
            $questions = Question::search($search)->get();
        }

        if ($filter === 'all' || $filter === 'users') {
            $users = User::search($search)->get();
        }

        if ($filter === 'verified_answers') {
            $searchTerms = array_filter(explode(' ', $search));

            $questions = Question::query()
                ->whereHas('answers', function ($query) {
                    $query->where('verified', true);
                })
                ->where(function ($query) use ($searchTerms) {
                    foreach ($searchTerms as $term) {
                        $term = strtolower($term); 
                        $query->orWhereRaw('LOWER(title) LIKE ?', ["%{$term}%"])
                              ->orWhereRaw('LOWER(content) LIKE ?', ["%{$term}%"])
                              ->orWhereHas('answers', function ($subQuery) use ($term) {
                                  $subQuery->whereRaw('LOWER(content) LIKE ?', ["%{$term}%"]);
                              });
                    }
                })
                ->distinct() 
                ->get();
        }

        return view('search.results', compact('questions', 'users', 'search', 'filter'));
    }
}


