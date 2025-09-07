<?php

namespace App\Http\Controllers;

use App\Models\MinEducation;
use Illuminate\Http\Request;

class MinEducationController extends Controller
{
    //
    public function index()
    {
        $items = MinEducation::all();
        return view('Dashboard.mineducation.index', compact('items'));
    }

    public function create()
    {
        return view('Dashboard.mineducation.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required']);
        MinEducation::create($request->all());
        return redirect()->route('mineducation.list')->with('success', 'با موفقیت ذخیره شد');
    }

    public function edit($id)
    {
        $item = MinEducation::findOrFail($id);
        return view('Dashboard.mineducation.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $request->validate(['name' => 'required']);
        $item = MinEducation::findOrFail($id);
        $item->update($request->all());
        return redirect()->route('mineducation.list')->with('success', 'با موفقیت ویرایش شد');
    }

    public function destroy($id)
    {
        MinEducation::destroy($id);
        return redirect()->route('mineducation.list')->with('success', 'با موفقیت حذف شد');
    }
}
