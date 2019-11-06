<?php

namespace App\Http\Controllers;

use App\Models\Course;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('guest.landing', [
            'courses' => Course::orderBy('created_at', 'desc')->paginate(6),
        ]);
    }

}
