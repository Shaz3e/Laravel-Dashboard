<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Helpers\LogActivity;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AdminLoginRequest;
use App\Models\Admin;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
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
        return view('admin.auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(AdminLoginRequest $request): RedirectResponse
    {
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

            $EmailExist = Admin::where('email', $request->email)->exists();
            if (!$EmailExist) {
                LogActivity::addToLog($request, $request->email . ' does not exists');
                Session::flash('error', [
                    'text' => "Invalid Credentials",
                ]);
                return redirect()->back();
            } else {
                $AdminPassword = Admin::where('email', $request->email)->value('password');

                if (Hash::check($request->password, $AdminPassword)) {
                    /**
                     * Check status
                     */
                    if (Admin::where('email', $request->email)->value('is_active') != 1) {
                        LogActivity::addToLog($request, 'an inactive account (' . $request->email . ') tried to login in dashboard');
                        Session::flash('error', [
                            'text' => 'You are not authorized to access as your account is not active',
                        ]);
                        return redirect()->back()->withInput();
                    } else {
                        /**
                         * Start session when user is authorized
                         */
                        $request->authenticate();
                        $request->session()->regenerate();
                        $name = Admin::where('email', $request->email)->value('name');
                        if (!Admin::where('id', 1)) {
                            LogActivity::addToLog($request, $request->email . ' logged into dashboard');
                        }
                        Session::flash('message', [
                            'text' => "Login Successfully! Welcome " . $name,
                        ]);
                        // return redirect()->intended();
                        return redirect('/admin');
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
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/admin');
    }
}
