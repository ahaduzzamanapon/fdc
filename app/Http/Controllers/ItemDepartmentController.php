<?php

namespace App\Http\Controllers;

use App\Models\ItemDepartment;
use Illuminate\Http\Request;
use Flash;
use Response;

class ItemDepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /** @var ItemDepartment $ItemDepartment */
        $ItemDepartments = ItemDepartment::all();

        return view('item_departments.index')
            ->with('ItemDepartments', $ItemDepartments);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('item_departments.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        /** @var ItemDepartment $ItemDepartment */
        $ItemDepartment = ItemDepartment::create($input);

        Flash::success('Item Department saved successfully.');

        return redirect(route('itemDepartments.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ItemDepartment  $itemDepartment
     * @return \Illuminate\Http\Response
     */
    public function show(ItemDepartment $itemDepartment)
    {
        if (empty($itemDepartment)) {
            Flash::error('Item department not found');
            return redirect(route('itemDepartments.index'));
        }
        return view('item_departments.show')->with('itemDepartment', $itemDepartment);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ItemDepartment  $itemDepartment
     * @return \Illuminate\Http\Response
     */
    public function edit(ItemDepartment $itemDepartment)
    {

        if (empty($itemDepartment)) {
            Flash::error('Item department not found');
            return redirect(route('itemDepartments.index'));
        }
        return view('item_departments.edit')->with('itemDepartment', $itemDepartment);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ItemDepartment  $itemDepartment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ItemDepartment $itemDepartment)
    {
        if (empty($itemDepartment)) {
            Flash::error('Item department not found');
            return redirect(route('itemDepartments.index'));
        }

        $itemDepartment->fill($request->all());
        $itemDepartment->save();

        Flash::success('Item Department updated successfully.');

        return redirect(route('itemDepartments.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ItemDepartment  $itemDepartment
     * @return \Illuminate\Http\Response
     */
    public function destroy(ItemDepartment $itemDepartment)
    {
        //
    }
}
