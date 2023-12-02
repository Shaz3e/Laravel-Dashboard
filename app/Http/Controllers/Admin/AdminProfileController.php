<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\LogActivity;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AdminProfileController extends Controller
{
    // View folder name
    protected $view = "admin.profile.";

    // route name
    protected $route = "admin/profile";

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $id = Auth::guard('admin')->user()->id;
        $dataSet = Admin::where('id', $id)->get();
        LogActivity::addToLog($request, 'viewed profile');
        return view($this->view . 'index', compact('dataSet'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $id = Auth::guard('admin')->user()->id;
        $data = Admin::find($id);
        if ($request->has('email')) {

            $validator = Validator::make(
                $request->all(),
                [
                    'email' => 'required|email|unique:admins,email,' . $id . '|max:255',
                    'name' => 'required|max:255',
                    'username' => 'nullable|max:255|regex:/^[a-zA-Z0-9]+$/|unique:admins,username,' . $id,
                ],
                [
                    'email.required' => 'Email is required',
                    'email.email' => 'Email is invalid',
                    'email.unique' => 'Email already exists',
                    'email.max' => 'Email must be less then 255 characters',

                    'name.required' => 'Name is required',
                    'name.max' => 'Name must be less then 255 characters',
                    
                    'username.max' => 'Username must be less then 255 characters',
                    'username.regex' => 'Username must be alphabets or number without space',
                    'username.unique' => 'Username already exists',
                ],
            );

            $data->email = $request->email;
            $data->name = $request->name;
            $data->username = $request->username;

            if ($validator->fails()) {
                Session::flash('error', [
                    'text' => $validator->errors()->first(),
                ]);
            } else {
                $result = $data->save();
                if ($result) {
                    Session::flash('message', [
                        'text' => "Profile updated",
                    ]);
                    LogActivity::addToLog($request, 'profile info updated');
                } else {
                    Session::flash('errors', [
                        'text' => "Something went wrong, please try again",
                    ]);
                }
            }

            return redirect()->back()->withInput();
        } else if ($request->has('password')) {

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
                    if ($result) {
                        Session::flash('message', [
                            'text' => "Password updated",
                        ]);
                        LogActivity::addToLog($request, 'profile security updated');
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
            return back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
