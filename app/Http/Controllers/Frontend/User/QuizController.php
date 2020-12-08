<?php

namespace App\Http\Controllers\Frontend\User;

use App\Http\Controllers\Controller;

class QuizController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('frontend.user.quiz');
    }
}
