<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Mail\Admin\Auth\NewUserSignUp;
use App\Mail\User\Auth\VerificationEmail;
use App\Models\Country;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\IpUtils;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class RegisteredUserController extends Controller
{
    // View folder name
    protected $view = "user.auth.register";

    // route name
    protected $route = "/";

    /**
     * Display the registration view.
     */
    public function create(Request $request): View
    {
        $countries = Country::all();
        return view($this->view, compact('countries'));
    }

    /**
     * Handle an incoming registration request.
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
                'first_name' => 'required|max:255',
                'last_name' => 'required|max:255',
                'email' => 'required|email|unique:users,email|max:255',
                'password' => 'required|min:8|max:32',
                'confirm_password' => 'required|same:password',
                'terms' => 'required',
            ],
            [
                'first_name.required' => 'The first name is required',
                'first_name.max' => 'The first name is too long',
                'last_name.required' => 'The last name is required',
                'last_name.max' => 'The last name is too long',
                'email.required' => 'The email is required',
                'email.email' => 'The email is not valid',
                'email.unique' => 'The email is already registered',
                'email.max' => 'The email is too long',

                'password.required' => 'Please enter a password.',
                'password.min' => 'Password must be at least :min characters long.',
                'password.max' => 'Password must be at least :max characters long.',
                'confirm_password.required' => 'Please confirm your password.',
                'confirm_password.same' => 'Passwords do not match.',
            ]
        );

        if ($validator->fails()) {
            Session::flash('error', [
                'text' => $validator->errors()->first(),
            ]);

            return redirect()->back()->withInput();
        }

        $this->registerUser($request);
        return redirect()->route('login');
    }

    public function registerUser(Request $request)
    {
        $user = new User();
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->mobile = $request->mobile;
        $user->country = $request->country;
        $user->state = $request->state;
        $user->city = $request->city;
        $user->dob = $request->dob;
        $user->password = $request->password;
        $user->remember_token = Str::random(60);
        $user->save();

        $mailData = [
            'verification_link' => config('app.url') . '/verify-email/' . $request->email . '/' . $request->_token,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => $request->password,
        ];

        Mail::to($request->email)->send(new VerificationEmail($mailData));
        Mail::to(config('mail.from.address'))->send(new NewUserSignUp($mailData));

        if(DiligentCreators('user_auto_login') == 1){
            
            Auth::login($user);
            $request->session()->regenerate();

            Session::flash('message', [
                'text' => 'Please verify your email.',
            ]);

            return redirect()->intended(RouteServiceProvider::HOME);
        }

        Session::flash('message', [
            'text' => 'Please verify your email.',
        ]);
    }
}
