<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function display()
    {
        return view('tasks.index.display');
    }
}

