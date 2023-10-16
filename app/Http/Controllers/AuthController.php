<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Mail\ForgotPasswordMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login()
    {
        if(Auth::check())
        {
            switch(Auth::user()->user_type) {
                case 1:
                    return redirect('admin/dashboard');
                case 2:
                    return redirect('teacher/dashboard');
                case 3:
                    return redirect('student/dashboard');
                case 4:
                    return redirect('parent/dashboard');
            }
        }

        return view('auth.login');
    }

    public function Authlogin(Request $request)
    {
        $remember = $request->has('remember') ? true : false;

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password], $remember)) {
            switch(Auth::user()->user_type) {
                case 1:
                    return redirect('admin/dashboard');
                case 2:
                    return redirect('teacher/dashboard');
                case 3:
                    return redirect('student/dashboard');
                case 4:
                    return redirect('parent/dashboard');
            }
        }
        else
        {
            return redirect()->back()->with('error', 'Invalid Credentials');
        }

        //dd($request->all());
    }

    public function logout()
    {
        Auth::logout();
        return redirect((url('')));
    }

    public function forgotPassword()
    {
        return view('auth.forgot');
    }

    public function postForgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $user = User::getEmailSingle($request->email);
        if(!empty($user))
        {
            $user->remember_token = Str::random(30);
            $user->save();

            Mail::to($user->email)->send(new ForgotPasswordMail($user));
            return redirect()->back()->with('success', 'Password reset link sent to your email.');
        }
        else
        {
            return redirect()->back()->with('error', 'Email not found.');
        }
    }

    public function reset($token)
    {
        $user = User::getTokenSingle($token);
        if(!empty($user))
        {
            $data['user'] = $user;
            return view('auth.reset', $data);
        }
        else
        {
            abort(404);
        }
    }

    public function postReset($token, Request $request)
    {
        if($request->password == $request->cpassword)
        {
            $user = User::getTokenSingle($token);
            if(!empty($user))
            {
                $user->password = Hash::make($request->password);
                $user->remember_token = Str::random(30);
                $user->save();
            }
            return redirect(url(''))->with('success', 'Password reset successfully.');
        }
        else
        {
            return redirect()->back()->with('error', 'Passwords do not match.');
        }
    }
}
