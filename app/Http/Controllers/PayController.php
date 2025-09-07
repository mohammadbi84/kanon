<?php

namespace App\Http\Controllers;

use App\Models\Organ;
use App\Models\Pay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PayController extends Controller
{
    //
    public function pay($id)
    {
        $pay=new  Pay();
        $pay->year=verta()->year;
        $pay->user_id=Auth::user()->id;
        $pay->value=0;
        $pay->organ_id=$id;
        $pay->save();
        return redirect()->back();


    }
    public function payAll($organ_id){
        $schools=Organ::where('type',2)->where('organ_id',$organ_id)->get();
//                    $year=
        $year = verta()->year;

        foreach ($schools as $school){
            $paid=Pay::where('organ_id',$school->id)->where('year',$year)->first();
            if(!$paid){
                $pay=new  Pay();
                $pay->year=verta()->year;
                $pay->user_id=Auth::user()->id;
                $pay->value=0;
                $pay->organ_id=$school->id;
                $pay->save();
            }
        }
        return redirect()->back();
    }
}
