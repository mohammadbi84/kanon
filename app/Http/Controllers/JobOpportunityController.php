<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\HerfeOrgan;
use Illuminate\Http\Request;

class JobOpportunityController extends Controller
{
    public function categories()
    {
        $group_organ = HerfeOrgan::pluck('herfe_id');
        $groups = Group::orderBy('name', 'asc')->whereIn('id', $group_organ)->get();
        return view('site.job_opportunity.categories', compact('groups'));
    }
    public function index()
    {
        return view('site.job_opportunity.jobs');
    }
}
