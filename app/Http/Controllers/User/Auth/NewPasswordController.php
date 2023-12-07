<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;

class NewPasswordController extends Controller
{
    /**
     * Display the password reset view.
     */
    public function create(Request $request)
    {
        $checkEmailToken = DB::table('password_reset_tokens')->where('email', $request->email)->where('token', $request->token)->exists();

        // Validator
        if ($checkEmailToken) {
            return view('user.auth.reset-password', ['request' => $request]);
        } else {
            Session::flash('error', [
                'text' => 'Invalid Request',
            ]);
            return redirect('forgot-password')->withInput();
        }
    }

    /**
     * Handle an incoming new password request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'token' => 'required',
                'email' => 'required|email',
                'password' => ['required', 'min:8', 'max:64', 'confirmed', Rules\Password::defaults()],
            ],
            [
                'token.required' => 'Token is required',
                'email.required' => 'Email is required',
                'email.email' => 'Email is invalid',
                'password.required' => 'Password is required',
                'password.min' => 'Password must be at least 8 characters',
                'password.max' => 'Password must be less then 64 characters',
                'password.confirmed' => 'Passwords do not match',
            ]
        );

        // Validator
        if ($validator->fails()) {
            Session::flash('error', [
                'text' => $validator->errors()->first(),
            ]);
            return redirect()->back()->withInput();
        } else {
            $data = User::Where('email', $request->email)->update([
                'password' => Hash::make($request->password),
                'remember_token' => Str::random(60),
            ]);
            if ($data) {
                Session::flash('message', [
                    'text' => 'Your password updated successfully',
                ]);
                return redirect()->route('login');
            } else {
                Session::flash('error', [
                    'text' => 'Something went wrong, please try again later',
                ]);
                return redirect()->back()->withInput();
            }
        }
    }
}
