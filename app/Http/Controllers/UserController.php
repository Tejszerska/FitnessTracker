<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;


class UserController extends Controller
{
    private UserService $service;

    public function __construct(UserService $uService)
    {
        $this->service = $uService;
    }

    public function registerPage()
    {
        return view('user.register');
    }

    public function registerUser(Request $request)
    {
        $this->service->createUser($request);
        return redirect('/');
    }

    public function logoutUser(Request $request)
    {
        $this->service->logout($request);
        return redirect('/login');
    }

    public function loginPage()
    {
        return view('user.login');
    }

    public function loginUser(Request $request)
    {
        $this->service->login($request);
        return redirect('/');
    }
}
