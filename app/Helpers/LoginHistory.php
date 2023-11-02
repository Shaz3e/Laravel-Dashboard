<?php

namespace App\Helpers;

use App\Models\LoginHistories as ModelsLoginHistory;
use Illuminate\Http\Request;

class LoginHistory
{
    public static function addToLoginHistory(Request $request, $user_id)
    {
        $log = [];
        $log['user_id'] = $user_id;
        $log['browser'] = $request->header('user-agent');
        $log['os'] = '';
        $log['device'] = '';
        $log['ip_address'] = $request->ip();
        $log['date_time'] = now();

        ModelsLoginHistory::create($log);
    }

    public static function loginHistoryLists()
    {
        // return ModelsLoginHistory::latest()->get();
        // return ModelsLoginHistory::orderBy('id', 'desc')->limit(50)->get();

        // return LoginHistory with 50 records and join with users table
        return ModelsLoginHistory::select(
            'login_histories.*',
            'users.id as userId',
            'users.first_name as firstName',
            'users.last_name as lastName',
            'users.email as email',
        )
            ->join('users', 'users.id', 'login_histories.user_id')
            ->orderBy('login_histories.id', 'desc')
            ->limit(50)
            ->get();
    }
}
