<?php

use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\User\AccountController;
use App\Http\Controllers\Frontend\User\DashboardController;
use App\Http\Controllers\Frontend\User\WordsController;
use App\Http\Controllers\Frontend\User\ProfileController;
use App\Http\Controllers\Frontend\User\QuizController;
use App\Http\Controllers\Frontend\User\LevelController;
use App\Http\Controllers\Frontend\User\SentencesController;
use App\Http\Controllers\Frontend\User\LessonController;
use App\Http\Controllers\Frontend\User\GrammarSiteController;
use App\Http\Controllers\Frontend\User\GrammarSingleController;
use App\Http\Controllers\Frontend\SchoolQuizController;

/*
 * Frontend Controllers
 * All route names are prefixed with 'frontend.'.
 */
Route::get('/', [HomeController::class, 'index'])->name('index');
Route::get('schools/{id}',  [SchoolQuizController::class, 'index'])->name('schoolQuiz');
Route::get('contact', [ContactController::class, 'index'])->name('contact');
Route::post('contact/send', [ContactController::class, 'send'])->name('contact.send');

/*
 * These frontend controllers require the user to be logged in
 * All route names are prefixed with 'frontend.'
 * These routes can not be hit if the password is expired
 */
Route::group(['middleware' => ['auth', 'password_expires']], function () {
    Route::group(['namespace' => 'User', 'as' => 'user.'], function () {
        // User Dashboard Specific
        Route::get('home', [DashboardController::class, 'index'])->name('dashboard');

        //User Words
        Route::get('words', [WordsController::class, 'index'])->name('words');
        //User Level
        Route::get('level/{id}', [LevelController::class, 'index'])->name('level');
        //User Sentences
        Route::get('sentences', [SentencesController::class, 'index'])->name('sentences');

        Route::get('test', [TestController::class, 'index'])->name('test');

        Route::get('grammar', [GrammarSiteController::class, 'index'])->name('grammar');

        Route::get('grammar/{id}', [GrammarSingleController::class, 'index'])->name('grammarSingle');

        //User Quiz Specific
        Route::get('{type}/quiz/{id}', [QuizController::class, 'index'])->name('quiz');

        // User Account Specific
        Route::get('account', [AccountController::class, 'index'])->name('account');

        // User Profile Specific
        Route::patch('profile/update', [ProfileController::class, 'update'])->name('profile.update');

        // User Quiz
        Route::get('home', [DashboardController::class, 'index'])->name('dashboard');
    });
});
