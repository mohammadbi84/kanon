<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PannelController extends Controller
{
    public function index(){
        return view('panel.index');
    }
    public function personal_page(){
        return view('panel.personal_page');
    }
}
