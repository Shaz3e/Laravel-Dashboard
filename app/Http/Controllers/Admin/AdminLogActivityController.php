<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\LogActivity;
use App\Http\Controllers\Controller;
use App\Models\LogActivity as ModelsLogActivity;
use Illuminate\Http\Request;

class AdminLogActivityController extends Controller
{
    // View folder name
    protected $view = "admin.log-activity.";
    protected $route = "admin/log-activity";

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $dataSet = LogActivity::logActivityLists();
        return view($this->view . 'index', compact('dataSet'));
    }

    public function adminLogs()
    {

        $dataSet = ModelsLogActivity::select(
            'log_activities.*',
            'admins.email as adminEmail',
        )
            ->leftJoin('admins', 'admins.id', 'log_activities.admin_id')
            ->whereNotNull('admin_id')
            ->get();

        return view($this->view . 'admin', compact('dataSet'));
    }

    public function userLogs()
    {

        $dataSet = ModelsLogActivity::select(
            'log_activities.*',
            'users.id as profileId',
            'users.first_name as firstName',
            'users.last_name as lastName',
        )
            ->leftJoin('users', 'users.id', 'log_activities.user_id')
            ->whereNotNull('user_id')
            ->get();

        return view($this->view . 'user', compact('dataSet'));
    }
}
