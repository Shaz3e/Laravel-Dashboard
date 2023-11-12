<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\LogActivity;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    // View & Route
    protected $view = "admin.manage-staff.";
    protected $route = "admin/manage-staff";

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->status != null) {
            Admin::where('id', $request->id)->update([
                'is_active' => $request->status,
            ]);
            return redirect()->back()->with('message', [
                'text' => 'Status has been changed'
            ]);
            LogActivity::addToLog($request, 'staff has been changed');
        }
        $dataSet = Admin::where('id', '!=', 1)->get();

        return view($this->view . 'index', compact('dataSet'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $rolesDataSet = Role::where('id', '!=', 1)->get();
        return view(
            $this->view . 'create',
            compact(
                'rolesDataSet'
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|max:64',
                'username' => 'nullable|regex:/^[a-zA-Z0-9]*$/|max:64|unique:admins',
                'password' => 'required|max:64',
                'email' => 'required|unique:admins',
                'role_id' => 'required|numeric',
                'is_active' => 'required|boolean',
            ],
            [
                'username.regex' => 'Username must contain alphabet or number no special character or spaces are allowed.',
                'username.unique' => 'The username has already been taken.',
                'username.max' => 'Username must not be greater than 64 characters.',
                'email.unique' => 'The email has already been taken.',
                'email.required' => 'The email field is required.',
                'password.required' => 'The password field is required.',
                'password.max' => 'The password must not be greater than 64 characters.',
                'role_id.required' => 'The role field is required.',
                'is_active.required' => 'The status field is required.',
            ],
        );

        if ($validator->fails()) {
            Session::flash('error', [
                'text' => $validator->errors()->first(),
            ]);
            return redirect()->back()->withInput();
        } else {
            $data = new Admin();
            $data->name = $request->name;
            $data->username = $request->username;
            $data->password = Hash::make($request->password);
            $data->email = $request->email;
            $data->is_active = $request->is_active;

            $role = Role::find($request->role_id);
            $data->assignRole($role);

            $result = $data->save();

            if ($result) {
                Session::flash('message', [
                    'text' => 'New staff member has been added',
                ]);
                return redirect($this->route);
            } else {
                Session::flash('error', [
                    'text' => 'Something went wrong while adding the staff member, please try again',
                ]);
                return redirect()->back()->withInput();
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Admin::find($id);
        if ($data) {
            return redirect($this->route . '/' . $id . '/edit');
        } else {
            return redirect($this->route)->with('warning', [
                'text' => "Role not found",
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = Admin::find($id);
        $rolesDataSet = Role::where('id', '!=', 1)->get();
        if ($data) {
            $permissions = Permission::all();
            return view(
                $this->view . 'edit',
                compact(
                    'data',
                    'rolesDataSet',
                    'permissions'
                )
            );
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = Admin::find($id);

        if ($request->has('password')) {
            $validator = Validator::make(
                $request->all(),
                [
                    'password' => 'required|max:255',
                ],
                [],
            );

            if ($validator->fails()) {
                Session::flash('error', [
                    'text' => $validator->errors()->first(),
                ]);
                return redirect()->back()->withInput();
            } else {
                $data->password = Hash::make($request->password);
                $result = $data->save();

                if ($result) {
                    Session::flash('message', [
                        'text' => 'Password has been changed',
                    ]);
                    return redirect($this->route);
                } else {
                    Session::flash('error', [
                        'text' => 'Something went wrong while changing the password, please try again',
                    ]);
                    return redirect()->back()->withInput();
                }
            }
        }
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|max:64',
                'username' => 'nullable|regex:/^[a-zA-Z0-9]*$/|max:64|unique:admins,username,' . $id,
                'email' => 'required|unique:admins,email,' . $id,
                'role_id' => 'required|numeric',
                'is_active' => 'required|boolean',
            ],
            [
                'username.regex' => 'Username must contain alphabet or number no special character or spaces are allowed.',
                'username.unique' => 'The username has already been taken.',
                'username.max' => 'Username must not be greater than 64 characters.',
            ],
        );

        if ($validator->fails()) {
            Session::flash('error', [
                'text' => $validator->errors()->first(),
            ]);
            return redirect()->back()->withInput();
        } else {
            $data->name = $request->name;
            $data->username = $request->username;
            $data->email = $request->email;
            $data->is_active = $request->is_active;

            $role = Role::find($request->role_id);
            $data->roles()->detach();
            $data->assignRole($role);

            $result = $data->save();

            if ($result) {
                Session::flash('message', [
                    'text' => 'Staff data has been added',
                ]);
                return redirect($this->route);
            } else {
                Session::flash('error', [
                    'text' => 'Something went wrong while adding the staff member, please try again',
                ]);
                return redirect()->back()->withInput();
            }
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        global $request;

        if (Admin::where('id', $id)->exists()) {
            $result = Admin::destroy($id);

            if ($result) {
                Session::flash('message', [
                    'text' => 'Record has been deleted',
                ]);
                LogActivity::addToLog($request, 'staff has been deleted');
            } else {
                Session::flash('warning', [
                    'text' => 'Something went wrong, please try again',
                ]);
            }
        } else {
            Session::flash('danger', [
                'text' => 'Record not found',
            ]);
        }

        return redirect($this->route);
    }
}
