<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PannelController extends Controller
{
    public function index(){
        return view('panel.index');
    }
}
