<?php

namespace App\Http\Middleware;

use App\Models\Khabar;
use App\Models\topadv;
use App\Models\Training_course;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SendDataToView
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */   public function handle(Request $request, Closure $next)
    {
        $courses = Training_course::all();
        $adv = topadv::orderBy('id', 'desc')->first();
        $khabars = Khabar::orderBy('id', 'desc')->get();

        view()->share('courses', $courses);
        view()->share('adv', $adv);
        view()->share('khabars', $khabars);

        return $next($request);
    }
}
