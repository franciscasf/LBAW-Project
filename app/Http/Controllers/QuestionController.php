<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\User;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller

{
    public function create()
    {
        $this->authorize('create', Question::class); 

        $tags = Tag::all();

        return view('questions.create', compact('tags'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:150',
            'content'=> 'required|max:1500',
            'tags' => 'required|array|min:1|max:5', 
            'tags.*' => 'exists:tag,tag_id', 
        ]);

        $user = auth()->user();

        $question = Question::create([
            'title' => $request->title,
            'content' => $request->content,
            'author_id' => $user->user_id,
        ]);

        $question->tags()->sync($request->tags);

        $totalQuestions = $user->questionsCount();
        $totalInteractions = $totalQuestions + $user->answers()->count();

        if ($totalQuestions == 1) {
            $user->assignBadge('Iniciante');
        } elseif ($totalQuestions == 5) {
            $user->assignBadge('Explorador');
        } elseif ($totalQuestions == 10) {
            $user->assignBadge('Contribuinte');
        }

        if ($totalInteractions == 50) {
            $user->assignBadge('Colaborador ativo');
        }
        
        return redirect()->route('home')
                        ->with('success', 'Question created successfully');
    }


    public function deleteQuestion(Request $request, $question_id)
    {
        $user = auth()->user();

        $question = Question::find($question_id);

        if (!$question) 
        {
            return response()->json(['message' => 'Question not found'], 404);
        }

        if($question->author_id !== $user->user_id && (!($user->isModerator() || $user->isAdmin())))
        {
            return response()->json([
                'message' => 'You are not authorized to delete this question'
            ], 403);
        }

        $question->tags()->detach();
        $question->votes()->detach();
        $question->answers()->detach();

        $question->delete();

        return redirect()->route('home')->with('success', 'Question deleted successfully');
    }


    public function show($id)
{
    $question = Question::with(['answers', 'author', 'tags'])->findOrFail($id);

    return view('pages.question', compact('question'));
}

    public function storeanswer(Request $request, $id)
    {
        $request->validate([
            'content' => 'required|max:1500',
        ]);

        $question = Question::findOrFail($id);

        $answer = $question->answers()->create([
            'content' => $request->content,
            'created_date' => now(),
            'author_id' => auth()->id(),
        ]);

        return redirect()->route('question.show', ['id' => $id])
                        ->with('success', 'Your answer has been posted!');
    }

    public function searchFT(Request $request)
    {
        $term = $request->input('search');
        $questions = Question::search($term)->get();

        return view('search_results', ['questions' => $questions]);
    }


    public function edit($id)
    {
        $question = Question::with('tags')->findOrFail($id);
        $tags = Tag::all();

        if (auth()->id() !== $question->author_id && !auth()->user()->isModerator() && !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        return view('questions.edit', compact('question', 'tags'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|max:150',
            'content' => 'required|max:1500',
            'tags' => 'required|array|min:1|max:5',
            'tags.*' => 'exists:tag,tag_id',
        ]);

        $question = Question::findOrFail($id);

        if (auth()->id() !== $question->author_id && !auth()->user()->isModerator() && !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        $question->update([
            'title' => $request->title,
            'content' => $request->content,
        ]);

        $question->tags()->sync($request->tags);

        return redirect()->route('question.show', $question->question_id)->with('success', 'Question updated successfully!');
    }

    public function showUserAnswers()
    {
        $user = auth()->user(); 
        $answers = $user->answers;

        return view('profile', compact('user', 'answers'));
    }


    public function filterByTags(Request $request)
    {
        $tags = $request->get('tags', []);  
        $title = "Filter Results";  
        
        if (empty($tags)) {
            $title = "Home Page";  
        }

        $allTags = Tag::all();

        if (!empty($tags)) {
        
            $latestQuestions = Question::with('tags')
                ->whereHas('tags', function ($query) use ($tags) {
                
                    $query->whereIn('askleic.tag.tag_id', $tags);  
                })
                ->orderBy('created_date', 'desc')
                ->get();
        } else {
        
            $latestQuestions = Question::with('tags')
                ->orderBy('created_date', 'desc')
                ->get();
        }
    
        return view('pages.homePage', compact('title', 'latestQuestions', 'allTags'));
    }


    public function followQuestion($id)
    {
        $user = Auth::user();
        $question = Question::findOrFail($id);

        if (!$user->followedQuestions()->where('question_id', $id)->exists()) {
            $user->followedQuestions()->attach($id);
            return redirect()->back()->with('success', 'You are now following this question.');
        }

        return redirect()->back()->with('info', 'You are already following this question.');
    }

    public function unfollowQuestion($id)
    {
        $user = Auth::user();
        $question = Question::findOrFail($id);

        if ($user->followedQuestions()->where('question_id', $id)->exists()) {
            $user->followedQuestions()->detach($id);
            return redirect()->back()->with('success', 'You have unfollowed this question.');
        }

        return redirect()->back()->with('info', 'You are not following this question.');
    }


    public function myFeed(Request $request)
{
    $user = Auth::user();

    $followedTags = $user->followedTags;

    $filteredTags = $request->get('tags', []);

    $taggedQuestions = Question::whereHas('tags', function ($query) use ($followedTags, $filteredTags) {
        $query->whereIn('askleic.question_has_tag.tag_id', $followedTags->pluck('tag_id'));
        if (!empty($filteredTags)) {
            $query->whereIn('askleic.question_has_tag.tag_id', $filteredTags);
        }
    })->with('tags')->get();

    $personalQuestions = $user->questions()->with('tags')->when(!empty($filteredTags), function ($query) use ($filteredTags) {
        $query->whereHas('tags', function ($subQuery) use ($filteredTags) {
            $subQuery->whereIn('askleic.question_has_tag.tag_id', $filteredTags);
        });
    })->get();

    $answeredQuestions = Question::whereHas('answers', function ($query) use ($user) {
        $query->where('author_id', $user->user_id);
    })->with('tags')->when(!empty($filteredTags), function ($query) use ($filteredTags) {
        $query->whereHas('tags', function ($subQuery) use ($filteredTags) {
            $subQuery->whereIn('askleic.question_has_tag.tag_id', $filteredTags);
        });
    })->get();

    $followedQuestions = Question::whereHas('followers', function ($query) use ($user) {
        $query->where('askleic.user_follows_question.user_id', $user->user_id);
    })->with('tags')->when(!empty($filteredTags), function ($query) use ($filteredTags) {
        $query->whereHas('tags', function ($subQuery) use ($filteredTags) {
            $subQuery->whereIn('askleic.question_has_tag.tag_id', $filteredTags);
        });
    })->get();

    $feedQuestions = $personalQuestions
        ->merge($taggedQuestions)
        ->merge($answeredQuestions)
        ->merge($followedQuestions)
        ->sortByDesc('created_date');

    $allTags = Tag::all();

    return view('pages.myFeed', compact('feedQuestions', 'allTags', 'followedTags'))->with('title', 'My Feed');
}

public function follow($id)
{
    $user = Auth::user();
    $question = Question::findOrFail($id);

    if (!$user->followedQuestions()->where('askleic.user_follows_question.question_id', $id)->exists()) {
        $user->followedQuestions()->attach($id);
        return response()->json(['status' => 'success', 'action' => 'follow'], 200);
    }

    return response()->json(['status' => 'error', 'message' => 'Already following'], 400);
}

public function unfollow($id)
{
    $user = Auth::user();
    $question = Question::findOrFail($id);

    if ($user->followedQuestions()->where('askleic.user_follows_question.question_id', $id)->exists()) {
        $user->followedQuestions()->detach($id);
        return response()->json(['status' => 'success', 'action' => 'unfollow'], 200);
    }

    return response()->json(['status' => 'error', 'message' => 'Not following'], 400);
}


    public function vote(Request $request, $id)
    {
        $request->validate(['vote_type' => 'required|boolean']);

        $user = auth()->user();
        $question = Question::findOrFail($id);
        $voteType = $request->input('vote_type'); 

        $question->votes()->updateOrCreate(
            ['user_id' => $user->user_id],
            ['vote_type' => $voteType]
        );

        $upvotes = $question->upvotesCount();
        $downvotes = $question->downvotesCount();

        return response()->json([
            'status' => 'success',
            'upvotes' => $upvotes,
            'downvotes' => $downvotes,
        ]);

    }  
}    