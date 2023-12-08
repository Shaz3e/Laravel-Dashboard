<?php

namespace App\Http\Controllers\User\Auth;

use App\Helpers\LogActivity;
use App\Http\Controllers\Controller;
use App\Mail\User\Auth\ResetPassword;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('user.auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        // Validate reCAPTCHA
        if (!validateRecaptcha($request->input('g-recaptcha-response'))) {
            return back();
        }

        $validator = Validator::make(
            $request->all(),
            [
                'email' => 'required|email|exists:users',
            ],
            [
                'email.required' => 'Email is required',
                'email.email' => 'Email is not valid',
                'email.exists' => 'Email is not registered',
            ]
        );

        // Validator
        if ($validator->fails()) {
            Session::flash('error', [
                'text' => $validator->errors()->first(),
            ]);
            return redirect()->back()->withInput();
        }

        // Generate random token
        $token = Str::random(64);

        // Prepare data
        $data = [
            'email' => $request->email,
            'token' => $token,
            'created_at' => now(),
        ];

        // Getting User Name            
        $name = User::where('email', $request->email)->value('first_name') . ' ' .  User::where('email', $request->email)->value('last_name');


        // Prepare mail data
        $mailData = [
            'name' => $name,
            'url' => config('app.url') . '/reset-password/' . $request->email . '/' . $token,
        ];

        // Send Email
        $sendEmail = Mail::to($request->email)->send(new ResetPassword($mailData));

        // Check Email if not added in database
        $checkEmail = DB::table('password_reset_tokens')->where('email', $request->email)->exists();

        // Update token if email exists
        if ($checkEmail) {
            DB::table('password_reset_tokens')->where('email', $request->email)->update([
                'token' => $token,
            ]);

            // Send email after update the record
            if ($sendEmail) {
                LogActivity::addToLog($request, 'password reset link has been sent to ' . $request->email);
                Session::flash('message', [
                    'text' => 'Password reset link has been sent to your email.',
                ]);
            } else {
                LogActivity::addToLog($request, 'password reset link could not be sent to ' . $request->email . ' due to SMTP connectivity issue');
                Session::flash('error', [
                    'text' => 'Something went wrong, please try again',
                ]);
            }
        } else {
            $result = DB::table('password_reset_tokens')->insert($data);
            if ($result) {

                // Send email
                if ($sendEmail) {
                    LogActivity::addToLog($request, 'password reset link has been sent to ' . $request->email);
                    Session::flash('message', [
                        'text' => 'Password reset link has been sent to your email.',
                    ]);
                } else {
                    LogActivity::addToLog($request, 'password reset link could not be sent to ' . $request->email . ' due to SMTP connectivity issue');
                    Session::flash('error', [
                        'text' => 'Something went wrong, please try again',
                    ]);
                }
            } else {
                LogActivity::addToLog($request, 'Database connectivity issue occured while sending a request of reset password ' . $request->email);
                Session::flash('error', [
                    'text' => 'Something went wrong, please try again',
                ]);
            }
        }
        
        return redirect()->back()->withInput();
    }
}
