<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Teacher;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;


class AdminController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('admin.dashboard');
    }

    public function show(Request $request)
    {
        if ($user = Admin::where('id', $request->id)->first()) {
            //"Password protection"
            $user->password = NULL;
        } else {
            //Redirect to yourself
            $user = Admin::where('id', Auth::user()->id)->first();
        }

        //dd(__METHOD__, $user, $request);

        return view('admin.profile', [
            'user' => $user,
        ]);

    }

    public function showUsersList()
    {
        return view('admin.users_list', [
            'users' => User::paginate(10)
        ]);
    }

    public function showTeachersList()
    {
        return view('admin.users_list', [
            'users' => Teacher::paginate(10)
        ]);
    }

    public function showAdminsList()
    {
        return view('admin.users_list', [
            'users' => Admin::paginate(10)
        ]);
    }

    public function edit()
    {
        $user = Admin::where('id', Auth::user()->id)->first();
        return view('custom.user.settings.edit', [
            'user' => $user,
        ]);
    }

}
