<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    // View folder name
    protected $view = "user.auth.register";

    // route name
    protected $route = "/";

    /**
     * Display the registration view.
     */
    public function create(Request $request): View
    {
        $countries = Country::all();
        return view($this->view, compact('countries'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
    }
}
