<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Mail\Admin\Auth\NewUserSignUp;
use App\Mail\Clients\Auth\VerificationEmail;
use App\Models\Country;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\IpUtils;

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
        $validator = Validator::make(
            $request->all(),
            [
                'first_name' => 'required|max:255',
                'last_name' => 'required|max:255',
                'email' => 'required|email|unique:users,email|max:255',
                'country' => 'required',
                'mobile' => 'required|unique:users,mobile',
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
                'country.required' => 'The country is required',
                'mobile.required' => 'The mobile is required',
                'mobile.unique' => 'The mobile is already registered',
                'mobile.max' => 'The mobile is too long',
            ]
        );

        if ($validator->fails()) {
            Session::flash('error', [
                'text' => $validator->errors()->first(),
            ]);
        }

        if (DiligentCreators('google_recaptcha') == 1) {
            $recaptcha_response = $request->input('g-recaptcha-response');

            if (is_null($recaptcha_response)) {
                Session::flash('error', [
                    'text' => 'Please Complete the Recaptcha to proceed'
                ]);
                return redirect()->back()->withInput();
            }

            $url = "https://www.google.com/recaptcha/api/siteverify";

            $body = [
                'secret' => DiligentCreators('google_secret_key'),
                'response' => $recaptcha_response,
                'remoteip' => IpUtils::anonymize($request->ip()) //anonymize the ip to be GDPR compliant. Otherwise just pass the default ip address
            ];

            $response = Http::withoutVerifying()->asForm()->post($url, $body);

            $result = json_decode($response);

            if ($response->successful() && $result->success == true) {

                $this->registerUser($request);
                
                return redirect()->route('login');
            } else {
                
                Session::flash('error', [
                    'text' => 'Please Complete the Recaptcha Again to proceed'
                ]);
                return redirect()->back()->withInput();
            }
        } else {
            
            $this->registerUser($request);
            return redirect()->route('login');
        }
    }

    public function registerUser(Request $request)
    {
        $password = GeneratePassword();
        $user = new User();
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->mobile = $request->mobile;
        $user->country = $request->country;
        $user->state = $request->state;
        $user->city = $request->city;
        $user->dob = $request->dob;
        $user->password = Hash::make($password);
        $user->save();

        $mailData = [
            'verification_link' => DiligentCreators('dashboard_url') . '/verify-email/' . $request->email . '/' . $request->_token,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => $password,
        ];

        Mail::to($request->email)->send(new VerificationEmail($mailData));
        Mail::to(DiligentCreators('to_email'))->send(new NewUserSignUp($mailData));

        Session::flash('message', [
            'text' => 'Email has been sent',
        ]);
    }
}
