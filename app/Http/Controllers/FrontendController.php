<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producer;
use Illuminate\Support\Facades\DB;

class FrontendController extends Controller
{

    public function certificate_verify(Producer $producer)
    {
        return view('font_end.certificate_verify', compact('producer'));
    }

    public function index()
    {
        return view('font_end.body');
    }
    public function about_us()
    {
        return view('font_end.about_us');
    }

    public function films_released_by_decade($decade)
    {
        $decadeStart = (int)$decade;
        $decadeEnd = $decadeStart + 9;
        
        $films = DB::table('decade_film_lists')
            ->whereRaw("YEAR(release_date) >= ? AND YEAR(release_date) <= ?", [$decadeStart, $decadeEnd])
            ->orderBy('release_date', 'ASC')
            ->get();
        
        return view('font_end.films_released_by_decade', compact('decade', 'films'));
    }

    public function films_photo_gallery()
    {
        return redirect()->route('filmsPhotoGallery.films_photo_by_decade', ['decade' => 1960]);
    }

    public function films_photo_by_decade($decade)
    {
        $decadeStart = (int)$decade;
        $decadeEnd = $decadeStart + 9;
        
        $galleries = DB::table('photo_galleries')
            ->whereRaw("YEAR(release_date) >= ? AND YEAR(release_date) <= ?", [$decadeStart, $decadeEnd])
            ->orderBy('release_date', 'ASC')
            ->get();
        
        return view('font_end.films_photo_gallery', compact('decade', 'galleries'));
    }

    public function rate_card()
    {
        return view('font_end.rate_card');
    }

    public function film_related()
    {
        $data = \App\Models\FilmRelated::all();
        return view('font_end.pages.film_related', compact('data'));
    }

    public function privacy_policy()
    {
        $data = \App\Models\PrivacyPolicy::all();
        return view('font_end.pages.privacy_policy', compact('data'));
    }

    public function terms_of_use()
    {
        $data = \App\Models\TermsOfUse::all();
        return view('font_end.pages.terms_of_use', compact('data'));
    }

    public function notices()
    {
        $data = \App\Models\Notice::all();
        return view('font_end.pages.notices', compact('data'));
    }

    public function faqs()
    {
        $data = \App\Models\Faq::all();
        return view('font_end.pages.faqs', compact('data'));
    }

    public function contact_info()
    {
        $data = \App\Models\ContactInfo::all();
        return view('font_end.pages.contact_info', compact('data'));
    }
}
