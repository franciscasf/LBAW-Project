<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\AnswerToQuestion;
use App\Models\UserPostsAnswer;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Controllers\QuestionController;
use App\Models\Notification;
use App\Models\AnswerToAnswer;

class AnswerController extends Controller
{

    public function createAnswer(Request $request)
    {
        $this->authorize('create', Answer::class); 
        $user = auth()->user();

        $request->validate([
            'content' => 'required|max:1500',
            'question_id' => 'required|exists:question,question_id', 
        ]);
    
        $question = Question::findOrFail($request->question_id);


        // Create the answer
        $answer = Answer::create([
            'content' => $request->content,
            'created_date' => now(),
        ]);

        UserPostsAnswer::create([
            'user_id' => $user->user_id,
            'answer_id' => $answer->answer_id,
        ]);

        AnswerToQuestion::create([
            'answer_id' => $answer->answer_id,
            'question_id' => $request->question_id, 
        ]);

        if ($question->author_id != $user->user_id) { 
            Notification::create([
                'user_id' => $question->author_id, 
                'is_read' => false,
                'created_at' => now(),
                'responder_id' => $user->user_id, 
                'question_id' => $question->question_id,
                'message' => "O utilizador {$user->name} respondeu à sua pergunta: {$question->title}.",
            ]);
        }

        // Lógica para badges
        $totalQuestions = $user->questions()->count();
        $totalAnswers = $user->answers()->count();
        $totalInteractions = $user->questions()->count() + $totalAnswers;
        
        if ($totalAnswers == 5) {
            $user->assignBadge('Respondo sempre');
        }
        if ($totalAnswers == 10) {
            $user->assignBadge('Mentor');
        }
        if ($totalInteractions == 50) {
            $user->assignBadge('Colaborador ativo');
        }
        if ($totalQuestions >= 20 && $totalAnswers >= 10) {
            $user->assignBadge('Guru');
        }
            
       
       

        foreach ($question->followers as $follower) {
            if ($follower->user_id != $user->user_id && $follower->user_id != $question->author_id) {
                Notification::create([
                    'user_id' => $follower->user_id,
                    'question_id' => $question->question_id,
                    'responder_id' => $user->user_id,
                    'created_at' => now(),
                    'is_read' => false,
                    'message' => "Uma nova resposta foi publicada na pergunta que você segue: {$question->title}.",
                ]);
            }
        }

        return redirect()->route('question.show', ['id' => $request->question_id])
        ->with('success', 'Your answer has been submitted!');

    }

    public function storeAnswer(Request $request, $id)
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

    public function index()
    {
        $answers = Answer::all();  // all answers
    
        // Pass answers to the view
        return view('your_view', compact('answers'));
    }


    public function createAnswerToAnswer(Request $request, $answerId)
    {
        $this->authorize('create', Answer::class);
    
        $user = auth()->user();
    
        $request->validate([
            'content' => 'required|max:1500',
            'answer_id' => 'exists:askleic.answer,answer_id', 
        ]);
    
        $parentAnswer = Answer::findOrFail($answerId);
    
        $newAnswer = Answer::create([
            'content' => $request->content,
            'created_date' => now(),
        ]);
    
        UserPostsAnswer::create([
            'user_id' => $user->user_id,
            'answer_id' => $newAnswer->answer_id,
        ]);
    
        AnswerToAnswer::create([
            'answer_reply' => $newAnswer->answer_id,
            'answer' => $parentAnswer->answer_id,
        ]);
    
        return response()->json([
            'success' => true,
            'reply' => [
                'content' => $newAnswer->content,
                'created_date' => $newAnswer->created_date,
                'author' => [
                    'user_id' => $user->user_id,
                    'first_name' => $user->first_name,
                    'last_name' => $user->last_name,
                ],
            ],
        ]);
    }
    

    



public function fetchReplies($answerId)
{
    $answer = Answer::findOrFail($answerId);

    $replies = $answer->answers()->with('author')->get();

    return response()->json($replies);
}


    public function getReplyCount($answerId)
    {
        // Find the answer
        $answer = Answer::findOrFail($answerId);

        // Use the `answers()` relationship to get replies (this uses the 'answer_to_answer' pivot table)
        $replies = $answer->answers; // Fetch all replies

        // Return the count of replies
        return response()->json([
            'replies_count' => $replies->count() // Return the number of replies
        ]);
    }









    public function edit($id)
    {
        $answer = Answer::findOrFail($id);

        if ($answer->author && ($answer->author->user_id == auth()->id() || auth()->user()->isModerator() || auth()->user()->isAdmin())) {
            return view('answers.edit', compact('answer'));
        } else {
            abort(403, 'Unauthorized action.');
        }

        return view('answers.edit', compact('answer'));
    }

    public function update(Request $request, $id)
    {
        $answer = Answer::findOrFail($id);

        if ($answer->author && ($answer->author->user_id == auth()->id() || auth()->user()->isModerator() || auth()->user()->isAdmin())) {
        
            $request->validate([
                'content' => 'required|max:1500',
            ]);

            $answer->content = $request->input('content');
            $answer->edited_date = now(); 
            $answer->save();

            $question = $answer->question->question;

            return redirect()->route('question.show', $question->question_id)
                        ->with('success', 'Your answer has been updated!');
        } else {
            abort(403, 'Unauthorized action.');
        }
    }

    public function deleteAnswer(Request $request, $answer_id)
    {
        $user = auth()->user();

        // Retrieve the answer model
        $answer = Answer::find($answer_id);


        if (!$answer) {
            return response()->json(['message' => 'Answer not found'], 404);
        }

        // Check if the user has the right to delete the answer
        if (($answer->author->user_id !== $user->user_id) && !($user->isModerator() || $user->isAdmin())) {
            return response()->json(['message' => 'You are not authorized to delete this answer'], 403);
        }

        // Manually delete related records

        // Delete the associated AnswerToQuestion record
        $answerToQuestion = AnswerToQuestion::where('answer_id', $answer->id)->first();
        if ($answerToQuestion) {
            $answerToQuestion->delete();
        }

        // Manually detach votes and users if applicable
        $answer->votes()->detach();  // Remove all associated votes
        $answer->users()->detach();  // Remove all associated users
        $answer->answers()->detach();

        // Now delete the answer
        $answer->delete();

        // Redirect to the question page
        return response()->json([
            'success' => true,
            'message' => 'Answer deleted successfully'
        ], 200);
    }

    public function getQuestionIdForAnswer($answerId)
{
    $answer = Answer::find($answerId);

    if ($answer) {
        if ($answer->question) {
            return $answer->question->question_id;
        }

        if ($answer->answer && $answer->answer->question) {
            return $answer->answer->question->question_id;
        }
    }
    return null;
}


    public function verify($id)
    {
        $answer = Answer::findOrFail($id);

        // Ensure the user is verified and answer isn't already verified
        if (auth()->user()->isVerified() && !$answer->isVerified()) {
            $answer->verify();
            return redirect()->back()->with('success', 'Answer has been verified.');
        }

        return redirect()->back()->with('error', 'Unable to verify the answer.');
    }

}
