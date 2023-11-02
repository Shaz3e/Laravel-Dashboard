<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\LoginHistory;
use App\Http\Controllers\Controller;
use App\Models\User;

class AdminDashboardController extends Controller
{
    // View Folder
    protected $view = 'admin.';

    public function dashboard()
    {
        /**
         * Fetch last 50 records from
         * @table LoginHistories
         */
        $userLoginHistory = LoginHistory::loginHistoryLists();

        $users = number_format(User::count(), 0);

        return view(
            $this->view . 'dashboard',
            compact(
                'users',
                'userLoginHistory',
            )
        );
    }
}
