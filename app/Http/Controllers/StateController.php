<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Khoshe;
use App\Models\Standard;
use App\Models\City;
use Illuminate\Http\Request;
use Validator;
use DB;
class StateController extends Controller
{
    //

    public function states()
    {
        $items=City::whereNull('parent')->get();
         return view('dashboard.city.states',compact('items'));
    }
    public function statesChange(Request $req){
        $states=City::whereNull('parent')->get();
        foreach ($states as $ss){
            $iid=$ss->id;
            if(isset($req->$iid))
                {
                    $ss->active=1;
                }
                else{
                $ss->active=0;
                }
                $ss->save();
        }
        return redirect()->back();
    }
    
     public function cities(Request $req)
    {
        $id=$req->id;
        $items=City::where('parent',$req->id)->get();
         return view('dashboard.city.city',compact('items','id'));
    }
    public function citiesChange(Request $req){
        $states=City::where('parent',$req->city)->get();
        foreach ($states as $ss){
            $iid=$ss->id;
            if(isset($req->$iid))
                {
                    $ss->active=1;
                }
                else{
                    $ss->active=0;
                }
                $ss->save();
        }
        return redirect()->back();
    }



   
}
