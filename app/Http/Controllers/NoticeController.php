<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;

class NoticeController extends Controller
{
    public function index()
    {
        $notices = Notice::all();
        return view('notices.index', compact('notices'));
    }

    public function create()
    {
        return view('notices.create');
    }

    public function store(Request $request)
    {
        $input = $request->all();
        Notice::create($input);
        Flash::success('নোটিশ সমূহ saved successfully.');
        return redirect(route('notices.index'));
    }

    public function edit($id)
    {
        $notice = Notice::find($id);
        if (empty($notice)) {
            Flash::error('নোটিশ সমূহ not found');
            return redirect(route('notices.index'));
        }
        return view('notices.edit', compact('notice'));
    }

    public function update(Request $request, $id)
    {
        $notice = Notice::find($id);
        if (empty($notice)) {
            Flash::error('নোটিশ সমূহ not found');
            return redirect(route('notices.index'));
        }
        $notice->fill($request->all());
        $notice->save();
        Flash::success('নোটিশ সমূহ updated successfully.');
        return redirect(route('notices.index'));
    }

    public function destroy($id)
    {
        $notice = Notice::find($id);
        if (empty($notice)) {
            Flash::error('নোটিশ সমূহ not found');
            return redirect(route('notices.index'));
        }
        $notice->delete();
        Flash::success('নোটিশ সমূহ deleted successfully.');
        return redirect(route('notices.index'));
    }
}
