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
        $auth = $this->service->login($request);
        if ($auth === true) {

            return redirect('/');
        } else {
            return back()
                ->withErrors(['email' => 'The provided credentials do not match our records.'])
                ->onlyInput('email');
        }
    }
}
