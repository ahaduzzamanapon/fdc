<?php

namespace App\Http\Controllers;

use App\Models\AboutUs;
use App\Models\AboutUsFeature;
use App\Models\AboutUsOfficer;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;

class AboutUsController extends Controller
{
    public function index()
    {
        $aboutUs = AboutUs::first();
        if (!$aboutUs) {
            $aboutUs = AboutUs::create([
                'banner_title' => 'আমাদের সম্পর্কে',
                'banner_subtitle' => 'একটি আধুনিক ও ইউজার-ফ্রেন্ডলি সল্যুশন...',
                'main_title' => 'আমাদের সম্পর্কে',
                'main_description' => 'একটি আধুনিক ও ইউজার-ফ্রেন্ডলি সল্যুশন...',
                'main_image' => '/assets/images/about.png',
                'team_title' => 'কর্মকর্তাবৃন্দ',
            ]);
        }

        $features = AboutUsFeature::orderBy('sort_order', 'asc')->get();
        $officers = AboutUsOfficer::orderBy('sort_order', 'asc')->get();

        return view('about_uses.index', compact('aboutUs', 'features', 'officers'));
    }

    public function updateMain(Request $request)
    {
        $aboutUs = AboutUs::first();
        if (!$aboutUs) {
            $aboutUs = new AboutUs();
        }

        $input = $request->only([
            'banner_title',
            'banner_subtitle',
            'main_title',
            'main_description',
            'team_title',
        ]);

        if ($request->hasFile('main_image')) {
            $file = $request->file('main_image');
            $input['main_image'] = uploadFile($file, 'uploads/about_us', 'main_' . time());
        }

        $aboutUs->fill($input);
        $aboutUs->save();

        Flash::success('আমাদের সম্পর্কে পেজের তথ্য সফলভাবে আপডেট করা হয়েছে।');
        return redirect()->route('about_uses.index', ['tab' => 'main']);
    }

    public function storeFeature(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        AboutUsFeature::create([
            'title' => $request->title,
            'items' => $request->items,
            'sort_order' => $request->sort_order ?? 0,
        ]);

        Flash::success('নতুন ফিচার তথ্য সফলভাবে যোগ করা হয়েছে।');
        return redirect()->route('about_uses.index', ['tab' => 'features']);
    }

    public function updateFeature(Request $request, $id)
    {
        $feature = AboutUsFeature::findOrFail($id);
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $feature->update([
            'title' => $request->title,
            'items' => $request->items,
            'sort_order' => $request->sort_order ?? 0,
        ]);

        Flash::success('ফিচার তথ্য সফলভাবে আপডেট করা হয়েছে।');
        return redirect()->route('about_uses.index', ['tab' => 'features']);
    }

    public function destroyFeature($id)
    {
        $feature = AboutUsFeature::findOrFail($id);
        $feature->delete();

        Flash::success('ফিচার তথ্য মোছা হয়েছে।');
        return redirect()->route('about_uses.index', ['tab' => 'features']);
    }

    public function storeOfficer(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $input = [
            'name' => $request->name,
            'designation' => $request->designation,
            'sort_order' => $request->sort_order ?? 0,
        ];

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $input['image'] = uploadFile($file, 'uploads/about_us', 'officer_' . time());
        }

        AboutUsOfficer::create($input);

        Flash::success('কর্মকর্তার তথ্য সফলভাবে যোগ করা হয়েছে।');
        return redirect()->route('about_uses.index', ['tab' => 'officers']);
    }

    public function updateOfficer(Request $request, $id)
    {
        $officer = AboutUsOfficer::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $input = [
            'name' => $request->name,
            'designation' => $request->designation,
            'sort_order' => $request->sort_order ?? 0,
        ];

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $input['image'] = uploadFile($file, 'uploads/about_us', 'officer_' . time());
        }

        $officer->update($input);

        Flash::success('কর্মকর্তার তথ্য সফলভাবে আপডেট করা হয়েছে।');
        return redirect()->route('about_uses.index', ['tab' => 'officers']);
    }

    public function destroyOfficer($id)
    {
        $officer = AboutUsOfficer::findOrFail($id);
        $officer->delete();

        Flash::success('কর্মকর্তার তথ্য মোছা হয়েছে।');
        return redirect()->route('about_uses.index', ['tab' => 'officers']);
    }
}
