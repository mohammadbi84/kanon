<?php

namespace App\Http\Controllers;
use App\Models\AboutUs;

use Illuminate\Http\Request;

class AboutUsController extends Controller
{
    public function index()
    {
        $aboutUs = AboutUs::all();
        return view('dashboard.about_us.list', compact('aboutUs'));
    }
    public function site()
    {
        $aboutUs = AboutUs::all();
        return view('site.AboutUs', compact('aboutUs'));
    }

    public function create()
    {
        return view('dashboard.about_us.add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        $check = AboutUs::first();
        if ($check) {
            return redirect()->route('about.index')->with('error', 'بیشتر از یک مورد نمیتوان اظافه کرد');
        }
        $imageName = time().'.'.$request->image->extension();
        $request->image->move(public_path('file/about'), $imageName);

        AboutUs::create([
            'image' => 'file/about/' . $imageName,
            'description' => $request->description
        ]);

        return redirect()->route('about.index')->with('success', 'ذخیره درباره ما با موفقیت انجام شد');
    }


    public function edit($id)
    {
        $aboutUs = AboutUs::findOrFail($id);
        return view('dashboard.about_us.edit', compact('aboutUs'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'description' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $aboutUs = AboutUs::findOrFail($id);

        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('file/about'), $imageName);
            $aboutUs->image = 'file/about/' . $imageName;
        }

        $aboutUs->description = $request->description;
        $aboutUs->save();

        return redirect()->route('about.index')->with('success','بروزرسانی درباره ما با موفقیت انجام شد');
    }

    public function destroy($id)
    {
        $aboutUs = AboutUs::findOrFail($id);
        $aboutUs->delete();

        return redirect()->route('about.index')->with('success', 'حذف درباره ما با موفقیت انجام شد');
    }
}

