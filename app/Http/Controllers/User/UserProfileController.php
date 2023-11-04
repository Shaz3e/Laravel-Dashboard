<?php

namespace App\Http\Controllers\User;

use App\Helpers\LogActivity;
use App\Http\Controllers\Controller;
use App\Mail\Admin\ChangeAgentAccountPassword;
use App\Models\AccountTypes;
use App\Models\IbClients;
use App\Models\KycDocuments;
use App\Models\LoginHistories;
use App\Models\TradingAccounts;
use App\Models\User;
use App\Models\Wallets;
use CMT5Request;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class UserProfileController extends Controller
{

    // View folder name
    protected $view = "user.profile.";

    // route name
    protected $route = "profile";


    /**
     * Display a listing of the resource.
     */
    public function View(Request $request)
    {
        $data = User::find(auth()->user()->id);

        // Caculate Age
        $dateOfBirth = $data->dob;
        $age = Carbon::parse($dateOfBirth)->age;

        $loginHistory = LoginHistories::where('user_id', $data->id)->get();


        return view($this->view. 'index',
        compact('data',
        'age',
        'loginHistory'
        )
    );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function Update(Request $request)
    {
        if ($request->has('username')) {

            $id = auth()->user()->id;
            $data = User::find($id);

            $validator = Validator::make(
                $request->all(),
                [
                    'email' => 'required|max:255|email|unique:users,email,' . $id,
                    'first_name' => 'required|regex:/^[a-zA-Z]+$/|max:255',
                    'last_name' => 'required|regex:/^[a-zA-Z]+$/|max:255',
                    'username' => 'nullable|regex:/^[a-zA-Z0-9]*$/|max:50|unique:users,username,' . $id,
                    'mobile' => 'required|regex:/^[0-9+]+$/|unique:users,mobile,' . $id,
                    'dob' => 'nullable|date_format:Y-m-d',
                    'company' => 'nullable|max:255',
                    'house_number' => 'required|max:255',
                    'address1' => 'required|max:255',
                    'address2' => 'max:255',
                ],
                [
                    'email.required' => 'Email is required',
                    'email.email' => 'Email is invalid',
                    'email.unique' => 'Email already exists',
                    'email.max' => 'Email must be less then 255 characters',

                    'first_name.required' => 'First Name is required',
                    'first_name.regex' => 'Space not allowed in First Name',
                    'first_name.max' => 'First Name must be less then 255 characters',

                    'last_name.required' => 'Last Name is required',
                    'last_name.regex' => 'Space not allowed in Last Name',
                    'last_name.max' => 'Last Name must be less then 255 characters',

                    'username.unique' => 'User Name already exists',
                    'username.max' => 'User Name must be less then 50 characters',
                    'username.regex' => 'Username must contain alphabet or number no special character or spaces are allowed.',

                    'mobile.required' => 'Mobile Number is required',
                    'mobile.regex' => 'Mobile is invalid',
                    'mobile.unique' => 'Mobile already exists',
                    'mobile.min' => 'Mobile must be at least 10 digits',
                    'mobile.max' => 'Mobile must be less then 13 digits',

                    'dob.required' => 'Date of birth is required',
                    'dob.date_format' => 'Date of birth is invalid',

                    'account_type_id.required' => 'Account type is required',
                    'account_type_id.numeric' => 'Account type is invalid',

                    // 'company.required' => 'Company is required',
                    'company.max' => 'Company must be less then 255 characters',

                    'house_number.required' => 'House Number is required',
                    'house_number.max' => 'House Number must be less then 255 characters',

                    'address1.required' => 'Address is required',
                    'address1.max' => 'Address must be less then 255 characters',

                    'address2.max' => 'address2 must be less then 255 characters',
                ],
            );

            $data->email = $request->email;
            $data->first_name = $request->first_name;
            $data->last_name = $request->last_name;
            $data->mobile = $request->mobile;
            $data->username = $request->username;
            $data->dob = $request->dob;
            $data->company = $request->company;
            $data->house_number = $request->house_number;
            $data->address1 = $request->address1;
            $data->address2 = $request->address2;

            if ($validator->fails()) {
                Session::flash('error', [
                    'text' => $validator->errors()->first(),
                ]);
            } else {
                $result = $data->save();
                LogActivity::addToLog($request, 'update profile');
                if ($result) {
                    Session::flash('message', [
                        'text' => "Profile updated",
                    ]);
                } else {
                    Session::flash('errors', [
                        'text' => "Something went wrong, please try again",
                    ]);
                }
            }

            return redirect()->back();
        } else if ($request->has('password')) {

            $id = auth()->user()->id;
            $data = User::find($id);

            $validator = Validator::make(
                $request->all(),
                [
                    'password' => 'required',
                    'new_password' => 'required|min:8|max:64',
                    'confirm_new_password' => 'required|same:new_password',
                ],
                [
                    'password.required' => 'Current Password is required',

                    'new_password.required' => 'New Password is required',
                    'new_password.password' => 'New Password must be different then password',
                    'new_password.min' => 'New Password must be at least 8 characters',
                    'new_password.max' => 'New Password must be less then 64 characters',

                    'confirm_new_password.required' => 'Confirm New Password is required',
                    'confirm_new_password.same' => 'Confirm New Password does not matched',
                ],
            );

            if ($validator->fails()) {
                Session::flash('error', [
                    'text' => $validator->errors()->first(),
                ]);
            } else {
                if (Hash::check($request->password, $data->password)) {
                    $data->password = Hash::make($request->new_password);
                    $result = $data->save();
                    LogActivity::addToLog($request, 'changed password');

                    if ($result) {
                        Session::flash('message', [
                            'text' => "Password updated",
                        ]);
                    } else {
                        Session::flash('errors', [
                            'text' => "Something went wrong, please try again",
                        ]);
                    }
                } else {
                    Session::flash('error', [
                        'text' => 'Incorrect current password',
                    ]);
                }
            }
            return redirect()->back()->withInput();
        }
    }
}
