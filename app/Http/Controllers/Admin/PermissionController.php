<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\LogActivity;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

use function Laravel\Prompts\text;

class PermissionController extends Controller
{
    protected $view = 'admin.app-permissions.';
    protected $route = 'admin/app-permissions';

    public function __construct()
    {
        $this->middleware('superadmin');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::all();
        $dataSet = Permission::all();

        return view(
            $this->view . 'index',
            compact(
                'roles',
                'dataSet'
            )
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::where('id', '!=', 1)->get();
        return view($this->view . 'create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|max:255|unique:permissions,name',
                'role_ids' => 'required|array',
                'role_ids.*' => 'numeric',
            ],
            [
                'name.required' => 'Permission Name is required',
                'name.max' => 'Permission Name must be less than 255 characters',
                'name.unique' => 'Permission Name must be unique',
                'role_ids.required' => 'At least one role is required',
                'role_ids.*.numeric' => 'Role is invalid',
            ]
        );

        if ($validator->fails()) {
            Session::flash('error', [
                'text' => $validator->errors()->first(),
            ]);
            return redirect()->back()->withInput();
        } else {
            $permission = Permission::create(['guard_name' => 'admin', 'name' => $request->name]);
            $roleIds = $request->role_ids;

            foreach ($roleIds as $roleId) {
                $role = Role::find($roleId);

                // Assign the permission to the selected role
                if ($role) {
                    $role->givePermissionTo($permission);
                }
            }
            return redirect($this->route)->with('message', [
                'text' => 'Permission created successfully.'
            ]);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Permission::find($id);
        if ($data) {
            return redirect($this->route . '/' . $id . '/edit');
        } else {
            return redirect($this->route)->with('warning', [
                'text' => "Permission not found",
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $roles = Role::where('id', '!=',1)->get();
        $data = Permission::find($id);

        return view(
            $this->view . 'edit',
            compact(
                'roles',
                'data'
            )
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|max:255|unique:permissions,name,' . $id,
                'role_ids' => 'required|array',
                'role_ids.*' => 'numeric',
            ],
            [
                'name.required' => 'Permission Name is required',
                'name.max' => 'Permission Name must be less than 255 characters',
                'name.unique' => 'Permission Name must be unique',
                'role_ids.required' => 'At least one role is required',
                'role_ids.*.numeric' => 'Role is invalid',
            ]
        );

        if ($validator->fails()) {
            Session::flash('error', [
                'text' => $validator->errors()->first(),
            ]);
            return redirect()->back()->withInput();
        }

        $permission = Permission::findOrFail($id);
        $permission->name = $request->name;
        $permission->save();

        // Detach all existing roles
        $permission->roles()->detach();

        // Attach the updated roles
        $roleIds = $request->role_ids;
        $validRoleIds = Role::where('guard_name', 'admin')
            ->whereIn('id', $roleIds)
            ->pluck('id')
            ->toArray();

        $permission->syncRoles($validRoleIds);

        // $permission->syncRoles($roleIds);

        return redirect($this->route)->with('message', [
            'text' => 'Permission updated successfully.',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        global $request;

        if (Permission::where('id', $id)->exists()) {
            $result = Permission::destroy($id);
            if ($result) {
                Session::flash('message', [
                    'text' => 'Permission has been deleted',
                ]);
                LogActivity::addToLog($request, 'Delete Permission');
            } else {
                Session::flash('warning', [
                    'text' => 'Something went wrong, please try again',
                ]);
            }
        } else {
            Session::flash('danger', [
                'text' => 'Permission not found',
            ]);
        }
        return redirect($this->route);
    }

    public function appRoutes()
    {
        $routes = Route::getRoutes();
        return view($this->view . 'routes', compact('routes'));
    }
}
