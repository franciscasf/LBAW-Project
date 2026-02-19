<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vote;
use App\Models\VoteOnQuestion;
use App\Models\Question;
use App\Models\Answer;
use App\Models\VoteOnAnswer;
use App\Models\Notification;
use App\Models\User;


class VoteController extends Controller
{
    public function createVoteQuestion(Request $request, $questionId)
{
    $user = auth()->user();

    $request->validate([
        'vote_type' => 'required|boolean',
    ]);

    $question = Question::findOrFail($questionId);

    $existingVote = Vote::where('user_id', $user->user_id)
        ->whereHas('questions', function ($query) use ($questionId) {
            $query->where('vote_on_question.question_id', $questionId);
        })
        ->first();

    if ($existingVote) {
 
        $existingVote->update(['vote_type' => $request->vote_type]);

        return response()->json(['message' => 'Vote successfully updated.'], 200);
    }


    $vote = Vote::create([
        'vote_type' => $request->vote_type,
        'user_id' => $user->user_id,
    ]);

    VoteOnQuestion::create([
        'vote_id' => $vote->vote_id,
        'question_id' => $question->question_id,
    ]);

    
    if ($question->author_id != $user->user_id) {
        Notification::create([
            'user_id' => $question->author_id,
            'question_id' => $question->question_id,
            'responder_id' => $user->user_id,
            'created_at' => now(),
            'is_read' => false,
            'message' => "Someone has voted on your question",
        ]);
    }

    $upvotes = $question->upvotesCount();
    $downvotes = $question->downvotesCount();

    return response()->json([
        'status' => 'success',
        'upvotes' => $upvotes,
        'downvotes' => $downvotes,
    ],201);
}


public function createVoteAnswer(Request $request, $answerId)
{
    $user = auth()->user();

    $request->validate([
        'vote_type' => 'required|boolean',
    ]);

    $answer = Answer::findOrFail($answerId);

    // Check for an existing vote
    $existingVote = Vote::where('user_id', $user->user_id)
        ->whereHas('answers', function ($query) use ($answerId) {
            $query->where('vote_on_answer.answer_id', $answerId);
        })
        ->first();

    if ($existingVote) {
        // Update the existing vote
        $existingVote->update(['vote_type' => $request->vote_type]);

        // Recalculate upvotes and downvotes
        $upvotes = $answer->upvotesCount();
        $downvotes = $answer->downvotesCount();

        return response()->json([
            'message' => 'Vote successfully updated.',
            'upvotes' => $upvotes,
            'downvotes' => $downvotes,
        ], 200);
    }

    // Create a new vote
    $vote = Vote::create([
        'vote_type' => $request->vote_type,
        'user_id' => $user->user_id,
    ]);

    VoteOnAnswer::create([
        'vote_id' => $vote->vote_id,
        'answer_id' => $answer->answer_id,
    ]);

    // Notify the author if the voter is not the author
    if ($answer->author_id != $user->user_id) {
        Notification::create([
            'user_id' => $answer->author_id,
            'answer_id' => $answer->answer_id,
            'question_id' => $answer->getQuestionId(),
            'responder_id' => $user->user_id,
            'created_at' => now(),
            'is_read' => false,
            'message' => "Someone has voted on your answer",
        ]);
    }

    // Recalculate upvotes and downvotes
    $upvotes = $answer->upvotesCount();
    $downvotes = $answer->downvotesCount();

    return response()->json([
        'message' => 'Vote successfully created.',
        'upvotes' => $upvotes,
        'downvotes' => $downvotes,
    ], 201);
}



    public function voteOnQuestion(Request $request, $questionId)
    {

        $user = auth()->user();

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Usuário não autenticado.'], 401);
        }

        $request->validate([
            'vote_type' => ['required', 'boolean'],
        ]);


        $question = Question::findOrFail($questionId);

        $existingVote = Vote::where('user_id', $user->user_id)
            ->whereHas('questions', function ($query) use ($questionId) {
                $query->where('vote_on_question.question_id', $questionId);
            })->first();

        if ($existingVote) {
            $existingVote->update(['vote_type' => $request->vote_type]);
        } else {
            $vote = Vote::create([
                'vote_type' => $request->vote_type,
                'user_id' => $user->user_id,
            ]);
            $vote->questions()->attach($questionId);
        }

        return back()->with('success', 'Seu voto foi registrado!');
    }

    public function voteOnAnswer(Request $request, $answerId)
    {
        $request->validate(['vote_type' => 'required|boolean']);

        $user = auth()->user();
        $answer = Answer::findOrFail($answerId);
        $voteType = $request->input('vote_type');

        $existingVote = Vote::where('user_id', $user->user_id)
            ->whereHas('answers', function ($query) use ($answerId) {
                $query->where('askleic.vote_on_answer.answer_id', $answerId);
            })->first();

        if ($existingVote) {
            $existingVote->update(['vote_type' => $voteType]);
        } else {
            $vote = Vote::create([
                'vote_type' => $voteType,
                'user_id' => $user->user_id,
            ]);

            VoteOnAnswer::create([
                'vote_id' => $vote->vote_id,
                'answer_id' => $answerId,
            ]);
        }

        $upvotes = $answer->upvotesCount();
        $downvotes = $answer->downvotesCount();

        return response()->json([
            'status' => 'success',
            'upvotes' => $upvotes,
            'downvotes' => $downvotes,
        ]);
    }

    public function addTags(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $user->followedTags()->sync($request->input('tags', []));

        return redirect()->back()->with('success', 'Tags updated successfully!');
    }
}
