<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateItemUnitRequest;
use App\Http\Requests\UpdateItemUnitRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\ItemUnit;
use Illuminate\Http\Request;
use Flash;
use Response;

class ItemUnitController extends AppBaseController
{
    /**
     * Display a listing of the ItemUnit.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        /** @var ItemUnit $itemUnits */
        $itemUnits = ItemUnit::paginate(10);

        return view('item_units.index')
            ->with('itemUnits', $itemUnits);
    }

    /**
     * Show the form for creating a new ItemUnit.
     *
     * @return Response
     */
    public function create()
    {
        return view('item_units.create');
    }

    /**
     * Store a newly created ItemUnit in storage.
     *
     * @param CreateItemUnitRequest $request
     *
     * @return Response
     */
    public function store(CreateItemUnitRequest $request)
    {
        $input = $request->all();

        /** @var ItemUnit $itemUnit */
        $itemUnit = ItemUnit::create($input);

        Flash::success('Item Unit saved successfully.');

        return redirect(route('itemUnits.index'));
    }

    /**
     * Display the specified ItemUnit.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var ItemUnit $itemUnit */
        $itemUnit = ItemUnit::find($id);

        if (empty($itemUnit)) {
            Flash::error('Item Unit not found');

            return redirect(route('itemUnits.index'));
        }

        return view('item_units.show')->with('itemUnit', $itemUnit);
    }

    /**
     * Show the form for editing the specified ItemUnit.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        /** @var ItemUnit $itemUnit */
        $itemUnit = ItemUnit::find($id);

        if (empty($itemUnit)) {
            Flash::error('Item Unit not found');

            return redirect(route('itemUnits.index'));
        }

        return view('item_units.edit')->with('itemUnit', $itemUnit);
    }

    /**
     * Update the specified ItemUnit in storage.
     *
     * @param int $id
     * @param UpdateItemUnitRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateItemUnitRequest $request)
    {
        /** @var ItemUnit $itemUnit */
        $itemUnit = ItemUnit::find($id);

        if (empty($itemUnit)) {
            Flash::error('Item Unit not found');

            return redirect(route('itemUnits.index'));
        }

        $itemUnit->fill($request->all());
        $itemUnit->save();

        Flash::success('Item Unit updated successfully.');

        return redirect(route('itemUnits.index'));
    }

    /**
     * Remove the specified ItemUnit from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var ItemUnit $itemUnit */
        $itemUnit = ItemUnit::find($id);

        if (empty($itemUnit)) {
            Flash::error('Item Unit not found');

            return redirect(route('itemUnits.index'));
        }

        $itemUnit->delete();

        Flash::success('Item Unit deleted successfully.');

        return redirect(route('itemUnits.index'));
    }
}
