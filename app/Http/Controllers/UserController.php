<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Models\ClassroomInvite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show(Request $request)
    {
        if ($user = User::where('id', $request->id)->first()) {
            //"Password protection"
            $user->password = NULL;
        } else {
            //Redirect to yourself
            $user = User::where('id', Auth::user()->id)->first();
        }
        return view('custom.user.profile.show', [
            'user' => $user,
        ]);
    }

    public function showInvites(){
        $user = User::where('id', Auth::user()->id)->first();

        $invites = ClassroomInvite::where('user_id', $user->id)->get();

        //dd($invites);

        return view('custom.user.invites',['invites' => $invites]);
    }

    public function edit()
    {
        $user = User::where('id', Auth::user()->id)->first();
        return view('custom.user.settings.edit', [
            'user' => $user,
        ]);
    }

    public function update(Request $request)
    {
        $user = User::where('id', Auth::user()->id)->first();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->dob = $request->dob;
        $user->skills = $request->skills;
        $user->hobbies = $request->hobbies;
        $user->signature = $request->signature;
        $user->sex = $request->sex;
        $user->status = $request->status;
        $file = $request->file('image');
        if (!empty($file)) {
            $path = Storage::putFile('public', $request->file('image'));
            $url = Storage::url($path);
            $user->avatar = $url;
        }
        $user->save();
        return redirect()->route('my_settings', $user);
    }
}
