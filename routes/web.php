<?php


use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AnswerController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\VerifiedUserController;
use App\Http\Controllers\SuggestionController;

use App\Http\Controllers\VoteController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\BadgeController;
use App\Http\Controllers\Auth\ForgotPasswordController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::redirect('/', '/home');

//-- HomePage Routes --//
Route::controller(HomePageController::class)->group(function () {
    Route::get('/home', 'showHomePage')->name('home');
    Route::get('/about', 'showAbout')->name('about_us');
    Route::get('/mainFeatures', 'showMainFeatures')->name('main_features');
    Route::get('/suggestions', 'showSuggestions')->name('suggestions');
    Route::get('/contacts', 'showContacts')->name('contacts');
    Route::get('/load-more-questions', 'loadMoreQuestions')->name('questions.loadMore');
    Route::get('/userHasBeenBlocked', 'showUserHasBeenBlockedPage')->name('user.blockedPage');
});

//-- MyFeed Route --//
Route::get('/my-feed', [QuestionController::class, 'myFeed'])->name('myFeed'); // Corrigido para fora do grupo

//-- Authentication Routes --//
Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'showLoginForm')->name('login');
    Route::post('/login', 'authenticate');
    Route::get('/logout', 'logout')->name('logout');
});

Route::controller(RegisterController::class)->group(function () {
    Route::get('/register', 'showRegistrationForm')->name('register');
    Route::post('/register', 'register');
});

//-- UserProfile Routes --//
Route::controller(UserProfileController::class)

    ->group(function () {
        Route::get('/userProfile/{id}', 'showUserProfile')->name('userProfile');
        Route::get('/user/{id}/edit', 'edit')->name('user.edit');
        Route::put('/user/{id}', 'update')->name('user.update');
        Route::get('/user/{id}/change-password', 'changePassword')->name('password.change');
        Route::put('/user/{id}/update-password', 'updatePassword')->name('password.update');
        Route::get('/user/{user}', 'show')->name('user.show');
        Route::post('/user/{id}/tags', 'addTags')->name('user.addTags');
    });

//-- Question Routes --//
Route::controller(QuestionController::class)->group(function () {
    Route::delete('/questions/{question_id}', 'deleteQuestion')->name('questions.delete');
    Route::get('/questions/create', 'create')->name('questions.create');
    Route::post('/questions', 'store')->name('questions.store');
    Route::get('/questions/{id}/edit', 'edit')->name('questions.edit');
    Route::put('/questions/{id}', 'update')->name('questions.update');
    Route::get('/questions/{id}', 'show')->where('id', '[0-9]+')->name('question.show');
    Route::get('/questions/filter-by-tag', 'filterByTags')->name('questions.filterByTags');

    // Routes for Follow e Unfollow
    Route::middleware('auth')->group(function () {
        Route::post('/questions/{id}/follow', [QuestionController::class, 'follow'])->name('questions.follow');
        Route::delete('/questions/{id}/unfollow', [QuestionController::class, 'unfollow'])->name('questions.unfollow');

    });
});

//-- Answer Routes --//
Route::controller(AnswerController::class)->group(function () {
    Route::delete('/answers/{answer_id}', 'deleteAnswer')->name('answers.delete');
    Route::post('/questions/{question_id}', 'createAnswer')->name('answers.store');
});
Route::middleware('auth')->group(function () {
    Route::get('/answers/{id}/edit', [AnswerController::class, 'edit'])->name('answers.edit');
    Route::put('/answers/{id}', [AnswerController::class, 'update'])->name('answers.update');
});

//-- Search Route --//
Route::get('/search', [SearchController::class, 'search'])->name('search');

//-- Tag Routes --//
Route::middleware('auth')->group(function () {
    Route::get('/tags/create', [TagController::class, 'showCreateForm'])->name('tags.create');
    Route::post('/tags', [TagController::class, 'store'])->name('tags.store');
});

//-- Admin Routes --//
Route::get('/userAdministration', [UserController::class, 'index'])->name('user_administration');//also creates dynamic roles
Route::post('/users/create', [UserController::class, 'create'])->name('users.create');
Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');

//-- Profile Picture and Verification Routes --//
Route::post('/profile-picture', [UserController::class, 'updateProfilePicture'])->name('user.updateProfilePicture');
Route::post('/apply-for-verification', [UserController::class, 'applyForVerification'])->name('user.applyForVerification');
Route::get('/verification-requests', [UserController::class, 'verificationRequests'])->name('admin.verificationRequests');
Route::delete('/verified-users/{id}', [VerifiedUserController::class, 'destroyVerifiedUser'])->name('verified_users.destroy');
Route::post('/verification-approve/{userId}', [UserController::class, 'approveVerification'])->name('admin.approveVerification');
Route::post('/answers/{id}/verify', [AnswerController::class, 'verify'])->name('answers.verify');


// Route to create a reply
Route::post('/answers/{answerId}/reply', [AnswerController::class, 'createAnswerToAnswer'])->name('answers.reply');
// Route to fetch replies
Route::get('/answers/{answerId}/replies', [AnswerController::class, 'fetchReplies'])->name('answers.replies');
Route::get('/answers/{answerId}/reply-count', [AnswerController::class, 'getReplyCount']);
Route::post('/answers/{answerId}/reply', [AnswerController::class, 'createAnswerToAnswer'])->name('answers.replies.create');
Route::get('/get-reply-form/{answerId}', function ($answerId) {
    return view('reply_form', ['answerId' => $answerId]);
});


Route::post('/answers/{answerId}/reply', [AnswerController::class, 'createAnswerToAnswer']);
Route::post('/answers/{answerId}/reply', [AnswerController::class, 'createAnswerToAnswer'])->name('answers.reply');


//-- Admin Routes --//
Route::middleware('auth')->group(function () {
    Route::get('/admin/tags', [TagController::class, 'index'])->name('admin.tags.manage');
    Route::get('/admin/tags/create', [TagController::class, 'create'])->name('admin.tags.create');
    Route::post('/admin/tags', [TagController::class, 'store'])->name('admin.tags.store');
    Route::get('/admin/tags/{id}/edit', [TagController::class, 'edit'])->name('admin.tags.edit');
    Route::put('/admin/tags/{id}', [TagController::class, 'update'])->name('admin.tags.update');
    Route::delete('/admin/tags/{id}', [TagController::class, 'destroy'])->name('admin.tags.destroy');
});

// Vote Routes
Route::middleware('auth')->group(function () {
    // Votos em Answers
    Route::post('/answers/{id}/vote', [VoteController::class, 'createVoteAnswer'])->name('answers.vote');

    // Votos em Questions
    Route::post('/questions/{id}/vote', [VoteController::class, 'createVoteQuestion'])->name('questions.vote');
});


//-- Notifications Routes --//
Route::middleware('auth')->group(function () {
    Route::get('/notifications', [NotificationController::class, 'index'])
        ->name('notifications.index');

    Route::post('/notifications/read/{id}', [NotificationController::class, 'markAsRead'])
        ->where('id', '[0-9]+')
        ->name('notifications.read');

    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])
        ->name('notifications.readAll');
});


//-- Badges Routes --//
Route::middleware('auth')->group(function () {
    Route::get('/admin/badges', [BadgeController::class, 'index'])->name('admin.badges.manage');
    Route::post('/admin/badges', [BadgeController::class, 'store'])->name('admin.badges.store');
    Route::get('/admin/badges/{id}/edit', [BadgeController::class, 'edit'])->name('admin.badges.edit');
    Route::put('/admin/badges/{id}', [BadgeController::class, 'update'])->name('admin.badges.update');
    Route::delete('/admin/badges/{id}', [BadgeController::class, 'destroy'])->name('admin.badges.destroy');
});





Route::put('/user/{id}/block', [UserController::class, 'block'])->name('user.block');
Route::delete('/users/{id}/unblock', [UserController::class, 'unblock'])->name('user.unblock');


Route::post('/users/{id}/changeRole', [UserController::class, 'changeRole'])->name('user.changeRole');



Route::get('/password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');

Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');


Route::post('/notifications', [NotificationController::class, 'store']);
Route::post('/notifications/create', [NotificationController::class, 'store']);



Route::get('/questions/filter-by-tag', [QuestionController::class, 'filterByTags'])->name('questions.filterByTags');

Route::get('/test-email', function () {
    Mail::raw('This is a test email from AskLeic using Mailtrap.', function ($message) {
        $message->to('test@example.com')->subject('Test Email');
    });

    return 'Test email sent!';
});

Route::get('/suggestions', [SuggestionController::class, 'create'])->name('suggestions.create');
Route::post('/suggestions', [SuggestionController::class, 'store'])->name('suggestions.store');


Route::post('/notifications/read/{id}', [NotificationController::class, 'markAsRead'])
    ->where('id', '[0-9]+')
    ->name('notifications.read');


    