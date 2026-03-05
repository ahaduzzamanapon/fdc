<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producer;

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
        return view('font_end.films_released_by_decade', compact('decade'));
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
