<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateDivisionRequest;
use App\Http\Requests\UpdateDivisionRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\Division;
use Illuminate\Http\Request;
use Flash;
use Response;

class DivisionController extends AppBaseController
{
    /**
     * Display a listing of the Division.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        /** @var Division $divisions */
        $divisions = Division::paginate(10);

        return view('divisions.index')
            ->with('divisions', $divisions);
    }

    /**
     * Show the form for creating a new Division.
     *
     * @return Response
     */
    public function create()
    {
        return view('divisions.create');
    }

    /**
     * Store a newly created Division in storage.
     *
     * @param CreateDivisionRequest $request
     *
     * @return Response
     */
    public function store(CreateDivisionRequest $request)
    {
        $input = $request->all();

        /** @var Division $division */
        $division = Division::create($input);

        Flash::success('Division saved successfully.');

        return redirect(route('divisions.index'));
    }

    /**
     * Display the specified Division.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Division $division */
        $division = Division::find($id);

        if (empty($division)) {
            Flash::error('Division not found');

            return redirect(route('divisions.index'));
        }

        return view('divisions.show')->with('division', $division);
    }

    /**
     * Show the form for editing the specified Division.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        /** @var Division $division */
        $division = Division::find($id);

        if (empty($division)) {
            Flash::error('Division not found');

            return redirect(route('divisions.index'));
        }

        return view('divisions.edit')->with('division', $division);
    }

    /**
     * Update the specified Division in storage.
     *
     * @param int $id
     * @param UpdateDivisionRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateDivisionRequest $request)
    {
        /** @var Division $division */
        $division = Division::find($id);

        if (empty($division)) {
            Flash::error('Division not found');

            return redirect(route('divisions.index'));
        }

        $division->fill($request->all());
        $division->save();

        Flash::success('Division updated successfully.');

        return redirect(route('divisions.index'));
    }

    /**
     * Remove the specified Division from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Division $division */
        $division = Division::find($id);

        if (empty($division)) {
            Flash::error('Division not found');

            return redirect(route('divisions.index'));
        }

        $division->delete();

        Flash::success('Division deleted successfully.');

        return redirect(route('divisions.index'));
    }
}
