<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateShiftRequest;
use App\Http\Requests\UpdateShiftRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\Shift;
use Illuminate\Http\Request;
use Flash;
use Response;

class ShiftController extends AppBaseController
{
    /**
     * Display a listing of the Shift.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        /** @var Shift $shifts */
        $shifts = Shift::select([
            'shifts.id',
            'shifts.name',
            'shifts.start_time',
            'shifts.end_time',
            'shifts.description',
            'itemcategorys.name_bn as category_name_bn',
            'items.name_bn as item_name_bn',
        ])
            ->join('itemcategorys', 'shifts.category_id', '=', 'itemcategorys.id')
            ->join('items', 'shifts.item_id', '=', 'items.id')
            ->get();
       

        return view('shifts.index')
            ->with('shifts', $shifts);
    }

    /**
     * Show the form for creating a new Shift.
     *
     * @return Response
     */
    public function create()
    {
        return view('shifts.create');
    }

    /**
     * Store a newly created Shift in storage.
     *
     * @param CreateShiftRequest $request
     *
     * @return Response
     */
    public function store(CreateShiftRequest $request)
    {
        $input = $request->all();

        /** @var Shift $shift */
        $shift = Shift::create($input);

        Flash::success('Shift saved successfully.');

        return redirect(route('shifts.index'));
    }

    /**
     * Display the specified Shift.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Shift $shift */
        $shift = Shift::find($id);

        if (empty($shift)) {
            Flash::error('Shift not found');

            return redirect(route('shifts.index'));
        }

        return view('shifts.show')->with('shift', $shift);
    }

    /**
     * Show the form for editing the specified Shift.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        /** @var Shift $shift */
        $shift = Shift::find($id);

        if (empty($shift)) {
            Flash::error('Shift not found');

            return redirect(route('shifts.index'));
        }

        return view('shifts.edit')->with('shift', $shift);
    }

    /**
     * Update the specified Shift in storage.
     *
     * @param int $id
     * @param UpdateShiftRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateShiftRequest $request)
    {
        /** @var Shift $shift */
        $shift = Shift::find($id);

        if (empty($shift)) {
            Flash::error('Shift not found');

            return redirect(route('shifts.index'));
        }

        $shift->fill($request->all());
        $shift->save();

        Flash::success('Shift updated successfully.');

        return redirect(route('shifts.index'));
    }

    /**
     * Remove the specified Shift from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Shift $shift */
        $shift = Shift::find($id);

        if (empty($shift)) {
            Flash::error('Shift not found');

            return redirect(route('shifts.index'));
        }

        $shift->delete();

        Flash::success('Shift deleted successfully.');

        return redirect(route('shifts.index'));
    }
}
