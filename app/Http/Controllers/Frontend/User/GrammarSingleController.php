<?php

namespace App\Http\Controllers\Frontend\User;

use App\Grammar;
use App\Http\Controllers\Controller;

/**
 * Class DashboardController.
 */
class GrammarSingleController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('frontend.user.blog.single');
    }
}
