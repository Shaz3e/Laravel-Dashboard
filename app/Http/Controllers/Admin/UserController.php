<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\LogActivity;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Models\Country;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    // View & Route
    protected $view = "admin.clients.";
    protected $route = "admin/clients";

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dataSet = User::all();
        return view($this->view . 'index', compact('dataSet'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $countries = Country::all();
        return view($this->view . 'create', compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'username' => 'nullable|regex:/^[a-zA-Z0-9]*$/|max:64|unique:users',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:8|max:64',
                'first_name' => 'required|max:64',
                'last_name' => 'required|max:64',
                'dob' => 'nullable|date_format:Y-m-d',
                'mobile' => 'nullable|unique:users',
            ],
            [
                'username.regex' => 'Username must contain alphabet or number no special character or spaces are allowed.',
                'username.unique' => 'The username has already been taken.',
                'email.required' => 'The email field is required.',
                'email.unique' => 'The email has already been taken.',
                'password.required' => 'The password field is required.',
                'password.min' => 'The password must not be less than 8 characters.',
                'password.max' => 'The password must not be greater than 64 characters.',
                'first_name.required' => 'First name is required.',
                'first_name.max' => 'First name must not be greater than 64 characters.',
                'last_name.required' => 'Last name is required.',
                'last_name.max' => 'Last name must not be greater than 64 characters.',
                'dob.date_format' => 'Date of birth must be a valid date.',
                'mobile.unique' => 'The mobile has already been taken.',
            ]
        );

        if ($validator->fails()) {
            Session::flash('error', [
                'text' => $validator->errors()->first(),
            ]);
            return redirect()->back()->withInput();
        }

        $data = new User();
        $data->username = $request->username;
        $data->email = $request->email;
        $data->password = Hash::make($request->password);
        $data->first_name = $request->first_name;
        $data->last_name = $request->last_name;
        $data->dob = $request->dob;
        $data->mobile = $request->mobile;
        $data->country = $request->country;
        $data->state = $request->state;
        $data->city = $request->city;
        $data->zip_code = $request->zip_code;
        $data->company = $request->company;
        $data->house_number = $request->house_number;
        $data->address1 = $request->address1;
        $data->address2 = $request->address2;

        $data->save();

        return redirect($this->route)->with('message', [
            'text' => 'User created successfully.',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = User::find($id);
        if (!$data) {
            return redirect($this->route)->with('error', [
                'text' => 'User not found.',
            ]);
        }

        return redirect($this->route . '/' . $id . '/edit');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, string $id)
    {
        $data = User::find($id);

        if ($request->status != null) {
            User::where('id',$request->id)->update([
                'is_verified' => $request->status,
                'email_verified_at' => now(),
            ]);
            Session::flash('message', [
                'text' => "Status has been changed successfully",
            ]);
            return redirect()->back();
        }

        // Caculate Age
        $dateOfBirth = $data->dob;
        $age = Carbon::parse($dateOfBirth)->age;
        if (!$data) {
            return redirect($this->route)->with('error', [
                'text' => 'User not found.',
            ]);
        }

        $countries = Country::all();

        return view(
            $this->view . 'edit',
            compact(
                'data',
                'countries',
                'age'
            )
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = User::find($id);

        if ($request->has('profile')) {
            $validator = Validator::make(
                $request->all(),
                [
                    'username' => 'required|max:64|unique:users,username,' . $id,
                    'first_name' => 'required|max:255|regex:/^[a-zA-Z]+$/',
                    'last_name' => 'required|max:255|regex:/^[a-zA-Z]+$/',
                    'dob' => 'required|date|max:255',
                    'email' => 'required|email|max:255|unique:users,email,' . $id,
                    'mobile' => 'required|numeric|unique:users,mobile,' . $id,
                    'house_number' => 'required|max:255',
                    'address1' => 'required|max:255',
                    'address1' => 'nullable|max:255',
                ],
                [
                    // Usrname
                    'username.required' => 'Username is required',
                    'username.max' => 'Username must be less then 255 characters',
                    'username.unique' => 'This username has already been taken',
                    
                    // First Name
                    'first_name.required' => 'First Name is required',
                    'first_name.regax' => 'First Name consist only on alphabet',
                    'first_name.max' => 'First Name must be less then 255 characters',

                    // Last Name
                    'last_name.required' => 'Last Name is required',
                    'last_name.regax' => 'Last Name consist only on alphabet',
                    'last_name.max' => 'Last Name must be less then 255 characters',

                    // Date of birth
                    'dob.required' => 'Date of birth is required',
                    'dob.max' => 'Date of birth must be less then 255 characters',

                    // Email
                    'email.required' => 'Email is required',
                    'email.max' => 'Email must be less then 255 characters',
                    'email.email' => 'Email is invalid',
                    'email.unique' => 'This email already have an account',

                    // Mobile
                    'mobile.required' => 'Mobile is required',
                    'mobile.email' => 'Mobile is invalid',
                    'mobile.max' => 'Mobile must be less then 255 characters',
                    'mobile.unique' => 'This mobile number already have an account',

                    // House / Flat No
                    'house_number.required' => 'House / Flat No is required',
                    'house_number.max' => 'House / Flat No must be less then 255 characters',

                    // Address
                    'address1.required' => 'Address is required',
                    'address1.max' => 'Address must be less then 255 characters',
                    'address2.max' => 'Address Line 2 must be less then 255 characters',
                ],
            );


            /**
             * Check Age limit as defined in App Basic Settings
             * @param age_limit
             */
            $dateOfBirth = $request->dob;
            $age_limit = Carbon::parse($dateOfBirth)->age;

            if ($age_limit <= DiligentCreators('age_limit') && $age_limit != 0) {
                Session::flash('error', [
                    'text' => 'Age should be ' . DiligentCreators('age_limit') . ' years old.',
                ]);
                return redirect()->back()->withInput();
            }

            $data->first_name = $request->first_name;
            $data->last_name = $request->last_name;
            $data->dob = $request->dob;
            $data->email = $request->email;
            $data->mobile = $request->mobile;
            $data->house_number = $request->house_number;
            $data->address1 = $request->address1;
            $data->address2 = $request->address2;

            LogActivity::addToLog($request, 'profile updated');
        } elseif ($request->has('location')) {
            $validator = Validator::make(
                $request->all(),
                [
                    'zip_code' => 'required|max:10',
                    'country' => 'required',
                    'state' => 'required',
                    'city' => 'required',
                ],
                [
                    // Zip Code
                    'zip_code.required' => 'Zip Code is required',
                    'zip_code.max' => 'Zip Code must be less then 255 characters',

                    // Country
                    'country.required' => 'Country is required',
                    'country.max' => 'Country must be less then 255 characters',

                    // State
                    'state.required' => 'State is required',
                    'state.max' => 'State must be less then 255 characters',

                    // City
                    'city.required' => 'City is required',
                    'city.max' => 'City must be less then 255 characters',
                ],
            );

            $data->zip_code = $request->zip_code;
            $data->country = $request->country;
            $data->state = $request->state;
            $data->city = $request->city;

            LogActivity::addToLog($request, 'user location updated');
        } elseif ($request->has('security')) {
            $validator = Validator::make(
                $request->all(),
                [
                    'password' => 'required|min:8|max:64',
                ],
                [
                    // Password
                    'password.required' => 'Password is required',
                    'password.min' => 'Password must be at least 8 characters',
                    'password.max' => 'Password must be less than 64 characters',
                ],
            );

            $data->password = Hash::make($request->password);

            LogActivity::addToLog($request, 'user password changed');
            /**
             * Prepare mail data
             */
            $mailData = [
                'first_name' => $data->first_name,
                'last_name' => $data->last_name,
                'email' => $data->email,
                'password' => $request->password,
            ];

            /**
             * Send Email
             */
        }

        if ($validator->fails()) {
            Session::flash('error', [
                'text' => $validator->errors()->first(),
            ]);
            return redirect()->back()->withInput();
        } else {
            $result = $data->save();
            if ($result) {
                Session::flash('message', [
                    'text' => "Data has been Saved",
                ]);
                LogActivity::addToLog($request, 'Client updated');
            } else {
                Session::flash('error', [
                    'text' => "Something went wrong, please try again",
                ]);
            }
        }
        return redirect()->back()->withInput();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = User::find($id);
        if (!$data) {
            return redirect($this->route)->with('error', [
                'text' => 'User not found.',
            ]);
        }
        $data->delete();
        return redirect($this->route)->with('message', [
            'text' => 'User deleted successfully.',
        ]);
    }

    /**
     * Login as Client
     */
    public function loginAs($userId)
    {
        global $request;

        // Get the user by ID
        $user = User::find($userId);

        if ($user) {
            session(['original_user_id' => $user->id]);

            Auth::login($user);

            Session::flash('message', [
                'text' => 'Logged in as ' . $user->first_name . ' ' . $user->last_name,
            ]);

            LogActivity::addToLog($request, 'login as ' . $user->first_name . ' ' . $user->last_name);
            return redirect('/');
        } else {
            // Handle the case when the user is not found
            // You can throw an exception, redirect the user, or display an error message
            Session::flash('warning', [
                'text' => 'Unable to login as Client',
            ]);
            return redirect()->back();
        }
    }

    /**
     * Login Back as Admin
     */
    public function loginBack()
    {
        global $request;
        // Get the original user's ID from the session
        $originalUserId = session('original_user_id');

        // Get the original user by ID
        $originalUser = User::find($originalUserId);

        if ($originalUser) {
            // Log in as the original user
            Auth::login($originalUser);

            // Clear the original user's ID from the session
            session()->forget('original_user_id');

            Session::flash('message', [
                'text' => 'Logged in as ' . $originalUser->first_name . ' ' . $originalUser->last_name,
            ]);
            LogActivity::addToLog($request, 'login as ' . Auth::guard('admin')->user()->name);

            return redirect('/admin');
        } else {
            // Handle the case when the original user is not found
            // You can throw an exception, redirect the user, or display an error message
            Session::flash('error', [
                'text' => 'Unable to login',
            ]);

            return redirect()->back();
        }
    }
}
