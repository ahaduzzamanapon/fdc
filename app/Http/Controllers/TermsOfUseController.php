<?php

namespace App\Http\Controllers;

use App\Models\TermsOfUse;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;

class TermsOfUseController extends Controller
{
    public function index()
    {
        $terms_of_uses = TermsOfUse::all();
        return view('terms_of_uses.index', compact('terms_of_uses'));
    }

    public function create()
    {
        return view('terms_of_uses.create');
    }

    public function store(Request $request)
    {
        $input = $request->all();
        TermsOfUse::create($input);
        Flash::success('ব্যবহারের শর্তাবলি saved successfully.');
        return redirect(route('terms_of_uses.index'));
    }

    public function edit($id)
    {
        $termsOfUse = TermsOfUse::find($id);
        if (empty($termsOfUse)) {
            Flash::error('ব্যবহারের শর্তাবলি not found');
            return redirect(route('terms_of_uses.index'));
        }
        return view('terms_of_uses.edit', compact('termsOfUse'));
    }

    public function update(Request $request, $id)
    {
        $termsOfUse = TermsOfUse::find($id);
        if (empty($termsOfUse)) {
            Flash::error('ব্যবহারের শর্তাবলি not found');
            return redirect(route('terms_of_uses.index'));
        }
        $termsOfUse->fill($request->all());
        $termsOfUse->save();
        Flash::success('ব্যবহারের শর্তাবলি updated successfully.');
        return redirect(route('terms_of_uses.index'));
    }

    public function destroy($id)
    {
        $termsOfUse = TermsOfUse::find($id);
        if (empty($termsOfUse)) {
            Flash::error('ব্যবহারের শর্তাবলি not found');
            return redirect(route('terms_of_uses.index'));
        }
        $termsOfUse->delete();
        Flash::success('ব্যবহারের শর্তাবলি deleted successfully.');
        return redirect(route('terms_of_uses.index'));
    }
}
