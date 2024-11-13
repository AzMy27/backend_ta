<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

 
class DashboardController extends Controller implements HasMiddleware
{
    /**
     * Get the middleware that should be assigned to the controller.
     */
    public static function middleware(): array
    {
        return [
            'auth',
            // new Middleware('log', only: ['index']),
            // new Middleware('subscribed', except: ['store']),
        ];
    }

    public function index()
    {
        return view('dashboard.admin');
    }
}

