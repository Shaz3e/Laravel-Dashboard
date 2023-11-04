<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserDashboardController extends Controller
{
    // View Folder
    protected $view = 'user.';

    public function dashboard(Request $request)
    {

        return view(
            $this->view . 'dashboard'
        );
    }
}
