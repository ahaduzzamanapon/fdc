<?php

namespace App\Http\Controllers;

use App\Models\ContactInfo;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;

class ContactInfoController extends Controller
{
    public function index()
    {
        $contact_infos = ContactInfo::all();
        return view('contact_infos.index', compact('contact_infos'));
    }

    public function create()
    {
        return view('contact_infos.create');
    }

    public function store(Request $request)
    {
        $input = $request->all();
        ContactInfo::create($input);
        Flash::success('যোগাযোগ saved successfully.');
        return redirect(route('contact_infos.index'));
    }

    public function edit($id)
    {
        $contactInfo = ContactInfo::find($id);
        if (empty($contactInfo)) {
            Flash::error('যোগাযোগ not found');
            return redirect(route('contact_infos.index'));
        }
        return view('contact_infos.edit', compact('contactInfo'));
    }

    public function update(Request $request, $id)
    {
        $contactInfo = ContactInfo::find($id);
        if (empty($contactInfo)) {
            Flash::error('যোগাযোগ not found');
            return redirect(route('contact_infos.index'));
        }
        $contactInfo->fill($request->all());
        $contactInfo->save();
        Flash::success('যোগাযোগ updated successfully.');
        return redirect(route('contact_infos.index'));
    }

    public function destroy($id)
    {
        $contactInfo = ContactInfo::find($id);
        if (empty($contactInfo)) {
            Flash::error('যোগাযোগ not found');
            return redirect(route('contact_infos.index'));
        }
        $contactInfo->delete();
        Flash::success('যোগাযোগ deleted successfully.');
        return redirect(route('contact_infos.index'));
    }
}
