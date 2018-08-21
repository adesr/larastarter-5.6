<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Menu;

class HomeCtrl extends Controller
{
    
    public function index()
    {
        if(auth()->check()) {
            return view('home.index');
        }
        return view('login');
    }

}
