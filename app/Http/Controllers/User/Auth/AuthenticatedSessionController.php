<?php

namespace App\Http\Controllers\User\Auth;

use App\Helpers\LogActivity;
use App\Helpers\LoginHistory;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\AppSettings;
use App\Models\LoginHistories;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        $link_one = AppSettings::where('setting_name', 'link_one')->value('setting_value');
        $link_two = AppSettings::where('setting_name', 'link_two')->value('setting_value');
        $link_three = AppSettings::where('setting_name', 'link_three')->value('setting_value');
        $link_four = AppSettings::where('setting_name', 'link_four')->value('setting_value');
        $link_five = AppSettings::where('setting_name', 'link_five')->value('setting_value');
        $link_six = AppSettings::where('setting_name', 'link_six')->value('setting_value');
        $link_seven = AppSettings::where('setting_name', 'link_seven')->value('setting_value');

        $dataSet = [
            'link_one' => $link_one,
            'link_two' => $link_two,
            'link_three' => $link_three,
            'link_four' => $link_four,
            'link_five' => $link_five,
            'link_six' => $link_six,
            'link_seven' => $link_seven,
        ];

        return view('user.auth.login', compact('dataSet'));
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Validate reCAPTCHA
        if (!validateRecaptcha($request->input('g-recaptcha-response'))) {
            return redirect()->back()->withInput();
        }
        
        $validator = Validator::make(
            $request->all(),
            [
                'email' => 'required|email|max:255',
                'password' => 'required',
            ],
            [
                'email.required' => 'Email is required',
                'email.email' => 'Email is invalid',
                'email.max' => 'Email must be less then 255 characters',

                'password.required' => 'Email is required',
            ],
        );

        if ($validator->fails()) {
            Session::flash('error', [
                'text' => $validator->errors()->first(),
            ]);
            return redirect()->back()->withInput();
        } else {
            $EmailExist = User::where('email', $request->email)->exists();
            if (!$EmailExist) {
                LogActivity::addToLog($request, $request->email . ' does not exists');
                Session::flash('error', [
                    'text' => "Invalid Credentials",
                ]);
                return redirect()->back();
            } else {
                $UserPassword = User::where('email', $request->email)->value('password');

                if (Hash::check($request->password, $UserPassword)) {

                    $checkVerified = User::where('email', $request->email)->value('is_verified');
                    $username = User::where('email', $request->email)->value('first_name') . ' ' . User::where('email', $request->email)->value('last_name');
                    if ($checkVerified == 1) {

                            $request->authenticate();
                            $request->session()->regenerate();

                            /**
                             * Update last access time
                             * @table login_histories
                             */
                            LoginHistory::addToLoginHistory($request, auth()->user()->id);

                            $username = User::where('email', $request->email)->value('first_name') . ' ' . User::where('email', $request->email)->value('last_name');
                            LogActivity::addToLog($request, 'logged into dashboard');
                            Session::flash('message', [
                                'text' => "Login Successfully! Welcome " . $username,
                            ]);
                            return redirect()->intended(RouteServiceProvider::HOME);
                        
                    } else {
                        LogActivity::addToLog($request, 'an unverified account (' . $request->email . ') tried to login in dashboard');
                        Session::flash('error', [
                            'text' => "Email Account is not verified",
                        ]);
                        return redirect()->back();
                    }
                } else {
                    /** 
                     * Check incorrect password
                     */
                    LogActivity::addToLog($request, $request->email . ' tried to login with incorrect password');
                    Session::flash('error', [
                        'text' => "Invalid Credentials",
                    ]);
                    return redirect()->back();
                }
            }
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
