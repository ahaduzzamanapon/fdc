<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateItemUnitAPIRequest;
use App\Http\Requests\API\UpdateItemUnitAPIRequest;
use App\Models\ItemUnit;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\ItemUnitResource;
use Response;

/**
 * Class ItemUnitController
 * @package App\Http\Controllers\API
 */

class ItemUnitAPIController extends AppBaseController
{
    /**
     * Display a listing of the ItemUnit.
     * GET|HEAD /itemUnits
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $query = ItemUnit::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $itemUnits = $query->get();

        return $this->sendResponse(ItemUnitResource::collection($itemUnits), 'Item Units retrieved successfully');
    }

    /**
     * Store a newly created ItemUnit in storage.
     * POST /itemUnits
     *
     * @param CreateItemUnitAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateItemUnitAPIRequest $request)
    {
        $input = $request->all();

        /** @var ItemUnit $itemUnit */
        $itemUnit = ItemUnit::create($input);

        return $this->sendResponse(new ItemUnitResource($itemUnit), 'Item Unit saved successfully');
    }

    /**
     * Display the specified ItemUnit.
     * GET|HEAD /itemUnits/{id}
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
            return $this->sendError('Item Unit not found');
        }

        return $this->sendResponse(new ItemUnitResource($itemUnit), 'Item Unit retrieved successfully');
    }

    /**
     * Update the specified ItemUnit in storage.
     * PUT/PATCH /itemUnits/{id}
     *
     * @param int $id
     * @param UpdateItemUnitAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateItemUnitAPIRequest $request)
    {
        /** @var ItemUnit $itemUnit */
        $itemUnit = ItemUnit::find($id);

        if (empty($itemUnit)) {
            return $this->sendError('Item Unit not found');
        }

        $itemUnit->fill($request->all());
        $itemUnit->save();

        return $this->sendResponse(new ItemUnitResource($itemUnit), 'ItemUnit updated successfully');
    }

    /**
     * Remove the specified ItemUnit from storage.
     * DELETE /itemUnits/{id}
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
            return $this->sendError('Item Unit not found');
        }

        $itemUnit->delete();

        return $this->sendSuccess('Item Unit deleted successfully');
    }
}
