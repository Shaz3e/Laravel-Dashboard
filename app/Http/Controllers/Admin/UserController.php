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
    public function edit(string $id)
    {
        $data = User::find($id);

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

        // Validate Profile

        if ($request->has('profile')) {

            $validator = Validator::make(
                [
                    'username' => 'nullable|regex:/^[a-zA-Z0-9]*$/|max:64|unique:users,username,' . $id,
                    'email' => 'required|email|unique:users,email,' . $id,
                    'password' => 'required|min:8|max:64',
                    'first_name' => 'required|max:64',
                    'last_name' => 'required|max:64',
                    'dob' => 'nullable|date_format:Y-m-d',
                    'mobile' => 'nullable|unique:users,mobile,' . $id,
                ],
                [
                    'username.max' => 'The username must not be greater than 64 characters.',
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

            // Update profile            
            $data->username = $request->username;
            $data->email = $request->email;
            $data->first_name = $request->first_name;
            $data->last_name = $request->last_name;
            $data->dob = $request->dob;
            $data->mobile = $request->mobile;
            $data->zip_code = $request->zip_code;
            $data->company = $request->company;
            $data->house_number = $request->house_number;
            $data->address1 = $request->address1;
            $data->address2 = $request->address2;
        }
        // Update Location
        elseif ($request->has('location')) {

            // Validate Data
            $validator = Validator::make(
                $request->all(),
                [
                    'zip_code' => 'required|numeric',
                    'country' => [
                        'required',
                        function ($attribute, $value, $fail) {
                            if (!DB::table('countries')->where('id', $value)->exists()) {
                                $fail("The selected $attribute is not valid.");
                            }
                        },
                    ],
                    'state' => [
                        'required',
                        function ($attribute, $value, $fail) {
                            if (!DB::table('states')->where('id', $value)->exists()) {
                                $fail("The selected $attribute is not valid.");
                            }
                        },
                    ],
                    'city' => [
                        'required',
                        function ($attribute, $value, $fail) {
                            if (!DB::table('cities')->where('id', $value)->exists()) {
                                $fail("The selected $attribute is not valid.");
                            }
                        },
                    ],
                ],
                [
                    'zip_code.required' => 'The zip code field is required.',
                    'zip_code.numeric' => 'The zip code must be a number.',
                    'country.required' => 'The country field is required.',
                    'country.exists' => 'The country is not valid.',
                    'state.required' => 'The state field is required.',
                    'state.exists' => 'The state is not valid.',
                    'city.required' => 'The city field is required.',
                    'city.exists' => 'The city is not valid.',
                ],
            );

            // Save Data
            $data->zip_code = $request->zip_code;
            $data->country = $request->country;
            $data->state = $request->state;
            $data->city = $request->city;
        }

        elseif ($request->has('security')) {

            $validator = Validator::make(
                $request->all(),
                [
                    'password' => 'required|min:8|max:64',
                ],
                [
                    'password.required' => 'The password field is required.',
                    'password.min' => 'The password must not be less than 8 characters.',
                    'password.max' => 'The password must not be greater than 64 characters.',
                ],
            );

            $data->password = Hash::make($request->password);
        }

        if($validator->fails()){
            Session::flash('error', [
                'text' => $validator->errors()->first(),
            ]);
            return redirect()->back()->withInput();
        }else{
            

            DB::enableQueryLog();

        $data->save();
        dd(DB::getQueryLog());

        return redirect($this->route)->with('message', [
            'text' => 'User updated successfully.',
        ]);
        }
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
