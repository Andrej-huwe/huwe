<?php

namespace App\Http\Controllers\Frontend\User;

use App\Http\Controllers\Controller;

class SentencesController extends Controller
{
    public function index()
    {
        return view('frontend.user.level');
    }
}
