<?php

namespace App\Helpers;

use App\Models\LogActivity as ModelsLogActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class LogActivity
{
    public static function addToLog(Request $request, $subject)
    {
        $adminUser = Auth::guard('admin')->user();
        $regularUser = Auth::user();

        $log = [];
        if ($adminUser) {
            $log['admin_id'] = $adminUser->id;
            $log['subject'] = $adminUser->name . ' ' . $adminUser->email . ' ' . $subject;
        }elseif ($regularUser) {
            $log['user_id'] = $regularUser->id;
            $log['subject'] = $regularUser->first_name . ' ' . $regularUser->last_name . ' ' . $regularUser->email . ' ' . $subject;
        }else{
            $log['subject'] = $subject;
        }
        $log['url'] = $request->fullUrl();
        $log['method'] = $request->method();
        $log['ip'] = $request->ip();
        $log['agent'] = $request->header('user-agent');

        ModelsLogActivity::create($log);
    }

    public static function logActivityLists()
    {
        return ModelsLogActivity::latest()->get();
    }

    public static function adminLogActivityList()
    {
        return ModelsLogActivity::whereNotNull('admin_id')->get();
    }

    public static function userLogActivityList()
    {
        return ModelsLogActivity::whereNotNull('user_id')->get();
    }
}
