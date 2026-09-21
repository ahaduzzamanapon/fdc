<?php

namespace App\Http\Controllers;

use App\Models\CinemaHeritagePage;
use App\Models\CinemaHeritageItem;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;

class CinemaHeritageController extends Controller
{
    public function index(Request $request)
    {
        $currentSlug = $request->get('page', 'classic_films');
        $subTab = $request->get('subtab', 'info');
        $validSlugs = ['classic_films', 'top_grossing_films', 'national_film_awards', 'international_films'];

        if (!in_array($currentSlug, $validSlugs)) {
            $currentSlug = 'classic_films';
        }

        $pages = CinemaHeritagePage::whereIn('slug', $validSlugs)->get()->keyBy('slug');
        $currentPage = $pages->get($currentSlug);

        if (!$currentPage) {
            $currentPage = CinemaHeritagePage::create([
                'slug' => $currentSlug,
                'title' => 'নতুন পেজ',
                'banner_subtitle' => '',
                'main_description' => '',
            ]);
            $pages->put($currentSlug, $currentPage);
        }

        $items = $currentPage->items;

        return view('cinema_heritage.index', compact('pages', 'currentPage', 'currentSlug', 'items', 'subTab'));
    }

    public function updatePage(Request $request, $id)
    {
        $page = CinemaHeritagePage::findOrFail($id);

        $input = $request->only([
            'title',
            'banner_subtitle',
            'main_description',
        ]);

        if ($request->hasFile('banner_image')) {
            $file = $request->file('banner_image');
            $input['banner_image'] = uploadFile($file, 'uploads/cinema_heritage', 'banner_' . $page->slug . '_' . time());
        }

        $page->update($input);

        Flash::success($page->title . ' পেজের তথ্য সফলভাবে আপডেট করা হয়েছে।');
        return redirect()->route('cinema_heritage.index', ['page' => $page->slug, 'subtab' => 'info']);
    }

    public function storeItem(Request $request)
    {
        $request->validate([
            'page_id' => 'required|exists:cinema_heritage_pages,id',
            'title' => 'required|string|max:255',
        ]);

        $page = CinemaHeritagePage::findOrFail($request->page_id);

        $input = [
            'page_id' => $page->id,
            'title' => $request->title,
            'sub_title' => $request->sub_title,
            'description' => $request->description,
            'sort_order' => $request->sort_order ?? 0,
        ];

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $input['image'] = uploadFile($file, 'uploads/cinema_heritage', 'item_' . time());
        }

        CinemaHeritageItem::create($input);

        Flash::success('নতুন তথ্য/আইটেম সফলভাবে যোগ করা হয়েছে।');
        return redirect()->route('cinema_heritage.index', ['page' => $page->slug, 'subtab' => 'items']);
    }

    public function updateItem(Request $request, $id)
    {
        $item = CinemaHeritageItem::findOrFail($id);
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $input = [
            'title' => $request->title,
            'sub_title' => $request->sub_title,
            'description' => $request->description,
            'sort_order' => $request->sort_order ?? 0,
        ];

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $input['image'] = uploadFile($file, 'uploads/cinema_heritage', 'item_' . time());
        }

        $item->update($input);

        Flash::success('তথ্য/আইটেম সফলভাবে আপডেট করা হয়েছে।');
        return redirect()->route('cinema_heritage.index', ['page' => $item->page->slug, 'subtab' => 'items']);
    }

    public function destroyItem($id)
    {
        $item = CinemaHeritageItem::findOrFail($id);
        $slug = $item->page->slug;
        $item->delete();

        Flash::success('তথ্য/আইটেম মোছা হয়েছে।');
        return redirect()->route('cinema_heritage.index', ['page' => $slug, 'subtab' => 'items']);
    }
}
