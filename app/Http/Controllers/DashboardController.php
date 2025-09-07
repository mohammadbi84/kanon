<?php

namespace App\Http\Controllers;

use App\Models\Organ;
use App\Models\OrganUser;
use App\Models\Pay;
use App\Models\Group;
use App\Models\Social;
use App\Models\organsocial;
use App\Models\City;
use App\Models\Moases;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    //
    public function verify(Request $req)
    {
        $user = Auth::user();
        $user->sms = '123456';
        $user->save();
        return view('dashboard.verify');
    }

    public function verifyCheck(Request $request)
    {
        //        return $request;
        $user = Auth::user();
        if ($user->sms == $request->code) {
            $organ_id = OrganUser::where('user_id', $user->id)->first()->organ_id;
            if ($organ_id) {
                $organ = Organ::find($organ_id);
                $organ->status = '0';
                $organ->save();
                $user->sms = null;
                $user->active = 1;
                $user->save();
                $status = ['title' => 'success', 'text' => 'با موفقیت تایید شد منتظر پاسخ بمانید'];
            } else {
                $status = ['title' => 'error', 'text' => 'خطای سیستمی'];
            }
            return redirect('/dashboard/home')->with($status["title"], $status["text"]);
        }
        return redirect()->back();
    }
    public function index()
    {
        $loggedIn = Auth::user();
        if ($loggedIn->hasRole('organ')) {
            if ($loggedIn->active) {
                $user_id = $loggedIn->id;

                $organUser = OrganUser::where('user_id', $user_id)->first();

                if ($organUser) {
                    $organ = Organ::find($organUser->organ_id);

                    $herfes = Group::with(['herfeOrgan' => function ($query) use ($organ) {
                        $query->where('organ_id', $organ->id);
                    }])->get();

                    foreach ($herfes as $her) {
                        $her['ok'] = $her->herfeOrgan->isNotEmpty() ? 1 : 0;
                    }

                    $socials = Social::all();
                    $organSocials = OrganSocial::where('organ_id', $organ->id)
                        ->whereIn('social_id', $socials->pluck('id'))
                        ->get();

                    foreach ($socials as $soc) {
                        $old = $organSocials->where('social_id', $soc->id)->first();
                        $soc['value'] = $old ? $old->address : null;
                    }

                    $states = City::where('active', 1)->whereNull('parent')
                        ->with(['cities' => function ($query) {
                            $query->where('active', 1);
                        }])->get();

                    $moases = Moases::where('organ_id', $organ->id)->first();
                    $city = City::find($organ->city);
                    $ostan = City::find($organ->state);

                    return view('dashboard.index', compact('city', 'ostan', 'moases', 'organ', 'socials', 'states', 'herfes'));
                }
            } else {
                return redirect('/dashboard/verify');
            }
        }

        if ($loggedIn->hasRole('user')) {
            $senf = OrganUser::where('user_id', $loggedIn->id)->first();
            if ($senf) {
                $organ = Organ::find($senf->organ_id);
                $loggedIn['role'] = $senf->role;
                $schools = Organ::where('type', 2)->where('organ_id', $organ->id)->get();
                //                    $year=
                $year = verta()->year;

                foreach ($schools as $school) {
                    $paid = Pay::where('organ_id', $school->id)->where('year', $year)->first();
                    $school['status'] = $paid;
                }


                return view('dashboard.senfIndex', compact('organ', 'schools'));
            } else {

                return redirect('/');
            }
        }
        // if ($loggedIn->hasRole('user')) {
        //     $organ = Organ::find($id);

        //     $herfes = Group::with(['herfeOrgan' => function ($query) use ($id) {
        //         $query->where('organ_id', $id);
        //     }])->get();

        //     foreach ($herfes as $her) {
        //         $her['ok'] = $her->herfeOrgan->isNotEmpty() ? 1 : 0;
        //     }

        //     $socials = Social::all();
        //     $organSocials = OrganSocial::where('organ_id', $id)
        //         ->whereIn('social_id', $socials->pluck('id'))
        //         ->get();

        //     foreach ($socials as $soc) {
        //         $old = $organSocials->where('social_id', $soc->id)->first();
        //         $soc['value'] = $old ? $old->address : null;
        //     }

        //     $states = City::where('active', 1)->whereNull('parent')
        //         ->with(['cities' => function ($query) {
        //             $query->where('active', 1);
        //         }])->get();

        //     $moases = Moases::where('organ_id', $id)->first();
        //     $city = City::find($organ->city);
        //     $ostan = City::find($organ->state);

        // }


        return view('dashboard.index');
    }
}
