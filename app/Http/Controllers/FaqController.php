<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::all();
        return view('faqs.index', compact('faqs'));
    }

    public function create()
    {
        return view('faqs.create');
    }

    public function store(Request $request)
    {
        $input = $request->all();
        Faq::create($input);
        Flash::success('সচরাচর জিজ্ঞাসা saved successfully.');
        return redirect(route('faqs.index'));
    }

    public function edit($id)
    {
        $faq = Faq::find($id);
        if (empty($faq)) {
            Flash::error('সচরাচর জিজ্ঞাসা not found');
            return redirect(route('faqs.index'));
        }
        return view('faqs.edit', compact('faq'));
    }

    public function update(Request $request, $id)
    {
        $faq = Faq::find($id);
        if (empty($faq)) {
            Flash::error('সচরাচর জিজ্ঞাসা not found');
            return redirect(route('faqs.index'));
        }
        $faq->fill($request->all());
        $faq->save();
        Flash::success('সচরাচর জিজ্ঞাসা updated successfully.');
        return redirect(route('faqs.index'));
    }

    public function destroy($id)
    {
        $faq = Faq::find($id);
        if (empty($faq)) {
            Flash::error('সচরাচর জিজ্ঞাসা not found');
            return redirect(route('faqs.index'));
        }
        $faq->delete();
        Flash::success('সচরাচর জিজ্ঞাসা deleted successfully.');
        return redirect(route('faqs.index'));
    }
}
