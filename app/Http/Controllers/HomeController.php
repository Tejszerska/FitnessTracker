<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\HomeService;


class HomeController extends Controller
{
    private HomeService $service;

    public function __construct(HomeService $hService)
    {
        $this->service = $hService;
    }

    public function index()
    {
        $lastWorkout = $this->service->getLastWorkout();

        return view('home.index', [
            'lastWorkout' => $lastWorkout
        ]);
    }
}
