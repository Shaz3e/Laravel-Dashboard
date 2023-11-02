<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\LogActivity;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    // View & Route
    protected $view = "admin.manage-roles.";
    protected $route = "admin/manage-roles";

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $dataSet = Role::all();

        return view(
            $this->view . 'index',
            compact(
                'dataSet',
            )
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view($this->view . 'create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|unique:roles|max:64',
            ],
            [
                'name.required' => 'Role name is required',
                'name.unique'   => 'This role already exists!',
                'name.max'      => 'Role name should be 64 character long.'
            ],
        );

        if ($validator->fails()) {
            Session::flash('error', [
                'text' => $validator->errors()->first()
            ]);
            return redirect()->back()->withInput();
        } else {
            // Create Role
            $result = Role::create(['guard_name' => 'admin', 'name' => $request->name]);

            if ($result) {
                Session::flash('success', [
                    'text' => "New role has been added successfully."
                ]);
                LogActivity::addToLog($request, "Added New Role");
                return redirect($this->route);
            } else {
                Session::flash('error', [
                    'text' => "Something went wrong!"
                ]);
                return redirect()->back();
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Role::find($id);
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
        $data = Role::find($id);
        if ($data) {
            $permissions = Permission::all();
            return view(
                $this->view . 'edit',
                compact(
                    'data',
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

        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|unique:roles,name,' . $id . '|max:64',
            ],
            [
                'name.required' => 'Role name is required',
                'name.unique'   => 'This role already exists!',
                'name.max'      => 'Role name should be 64 character long.'
            ],
        );

        if ($validator->fails()) {
            Session::flash('error', [
                'text' => $validator->errors()->first(),
            ]);
            return back();
        } else {
            $data = Role::find($id);
            $data->name = strtolower($request->name);
            $result = $data->save();

            if ($result) {
                LogActivity::addToLog($request, 'Role name updated');
                Session::flash('message', [
                    'text' => "Role has been successfully updated.",
                ]);
                return redirect($this->route);
            } else {
                Session::flash('error', [
                    'text' => "Failed to update role."
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

        if (Role::where('id', $id)->exists()) {
            $result = Role::destroy($id);

            if ($result) {
                Session::flash('message', [
                    'text' => 'Record has been deleted',
                ]);
                LogActivity::addToLog($request, 'role has been deleted');
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

    public function updatePermissions(Request $request, string $id)
    {
        $role = Role::where('id', $id)->where('guard_name', 'admin')->first();

        if (!$role) {
            // Handle the case where the role is not found
            Session::flash('error', [
                'text' => 'The requested record was not found.'
            ]);
            return redirect($this->route);
        }

        // Decode JSON into an array
        $permissions = json_decode($request->input('permissions'), true);

        if (!is_array($permissions)) {
            // Handle the case where permissions is not an array
            // For example, you can set it to an empty array
            $permissions = [];
        }

        // Detach all permissions from the role
        $role->permissions()->sync([]);

        // Attach the selected permissions to the role
        foreach ($permissions as $permission) {
            // Check if the permission exists for the 'admin' guard
            $perm = Permission::where('name', $permission)->where('guard_name', 'admin')->first();

            if ($perm) {
                $role->givePermissionTo($perm);
            }
        }

        Session::flash('success', [
            'text' => 'Permissions have been updated.',
        ]);

        return redirect($this->route);
    }
}
