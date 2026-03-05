<?php

namespace App\Http\Controllers;

use App\Models\PrivacyPolicy;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;

class PrivacyPolicyController extends Controller
{
    public function index()
    {
        $privacy_policies = PrivacyPolicy::all();
        return view('privacy_policies.index', compact('privacy_policies'));
    }

    public function create()
    {
        return view('privacy_policies.create');
    }

    public function store(Request $request)
    {
        $input = $request->all();
        PrivacyPolicy::create($input);
        Flash::success('গোপনীয়তার নীতিমালা saved successfully.');
        return redirect(route('privacy_policies.index'));
    }

    public function edit($id)
    {
        $privacyPolicy = PrivacyPolicy::find($id);
        if (empty($privacyPolicy)) {
            Flash::error('গোপনীয়তার নীতিমালা not found');
            return redirect(route('privacy_policies.index'));
        }
        return view('privacy_policies.edit', compact('privacyPolicy'));
    }

    public function update(Request $request, $id)
    {
        $privacyPolicy = PrivacyPolicy::find($id);
        if (empty($privacyPolicy)) {
            Flash::error('গোপনীয়তার নীতিমালা not found');
            return redirect(route('privacy_policies.index'));
        }
        $privacyPolicy->fill($request->all());
        $privacyPolicy->save();
        Flash::success('গোপনীয়তার নীতিমালা updated successfully.');
        return redirect(route('privacy_policies.index'));
    }

    public function destroy($id)
    {
        $privacyPolicy = PrivacyPolicy::find($id);
        if (empty($privacyPolicy)) {
            Flash::error('গোপনীয়তার নীতিমালা not found');
            return redirect(route('privacy_policies.index'));
        }
        $privacyPolicy->delete();
        Flash::success('গোপনীয়তার নীতিমালা deleted successfully.');
        return redirect(route('privacy_policies.index'));
    }
}
