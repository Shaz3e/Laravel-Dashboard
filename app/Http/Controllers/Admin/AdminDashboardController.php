<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\LoginHistory;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class AdminDashboardController extends Controller
{
    // View Folder
    protected $view = 'admin.';

    public function dashboard(Request $request)
    {
        $authUser = Auth::guard('admin')->user();

        if($authUser->is_active == 0){
            Auth::guard('admin')->logout();
            return redirect('/admin');
        }

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
