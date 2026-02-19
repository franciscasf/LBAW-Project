<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Tag;
use App\Models\User;

class HomePageController extends Controller
{
    public function showHomePage(Request $request)
{
    $title = "Home Page";

    $allTags = Tag::all();

    $sort = $request->input('sort', 'latest'); // Padrão: 'latest'

    $latestQuestions = Question::with('tags')
        ->when($sort === 'popularity', function ($query) {
            $query->withCount('votes') 
                ->orderBy('votes_count', 'desc');
        }, function ($query) {
            $query->orderBy('created_date', 'desc'); 
        })
        ->take(10)
        ->get();

    return view('pages.homePage', compact('title', 'latestQuestions', 'allTags'));
}


public function loadMoreQuestions(Request $request)
{
    $offset = $request->input('offset', 0); 
    $limit = 10; 

    $moreQuestions = Question::with('tags', 'author') 
    ->orderBy('created_date', 'desc')
    ->skip($offset)
    ->take($limit)
    ->get();

    return response()->json($moreQuestions);
}


    public function showMyFeed()
    {
        $title = 'My Feed';
        $allTags = Tag::all(); 
        $user = auth()->user(); 

        $personalQuestions = $user->questions()->with('tags')->get();

        $answeredQuestions = Question::whereHas('answers', function ($query) use ($user) {
            $query->whereHas('users', function ($q) use ($user) {
                $q->where('askleic.user_posts_answer.user_id', $user->user_id); 
            });
        })->with('tags')->get();

        $feedQuestions = $personalQuestions->merge($answeredQuestions)->sortByDesc('created_date');

        return view('pages.myFeed', compact('title', 'allTags', 'feedQuestions'));
    }

    public function showUserAdministrationPage()
    {
        $title = "Users";
        return view('pages.admin.userAdministration')->with('title', $title);
    }

    public function showAbout()
    {
        $title = "About Us";
        return view('pages.static.about')->with('title', $title);
    }

    public function showContacts()
    {
        $data = array(
            'title' => "Contact Us",
            'contacts' => ['eu', 'tu', 'ela', 'outra ela']
        );
        return view('pages.static.contacts')->with($data);
    }

    public function showSuggestions()
    {
        $title = "Sugestions";
        return view('pages.static.suggestions')->with('title', $title);
    }

    public function showMainFeatures()
    {
        $title = "Main Features";
        return view('pages.static.mainFeatures')->with('title', $title);
    }

    public function showUserHasBeenBlockedPage()
    {
        $title = "This account has been blocked. If you believe this decision to have been improperly made, please contact our support team for assistance.";
        return view('pages.blockedUserPage')->with('title', $title);
    }


    public function filterByTags(Request $request)
{
    $tags = $request->input('tags', []);
    $questions = Question::whereHas('tags', function ($query) use ($tags) {
        $query->whereIn('tag_id', $tags);
    })->with('tags')->get();

    $allTags = Tag::all();
    return view('pages.homePage', compact('questions', 'allTags'));
}


}
