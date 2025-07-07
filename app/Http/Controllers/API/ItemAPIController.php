<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateItemAPIRequest;
use App\Http\Requests\API\UpdateItemAPIRequest;
use App\Models\Item;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\ItemResource;
use Response;

/**
 * Class ItemController
 * @package App\Http\Controllers\API
 */

class ItemAPIController extends AppBaseController
{
    /**
     * Display a listing of the Item.
     * GET|HEAD /items
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $query = Item::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $items = $query->get();

        return $this->sendResponse(ItemResource::collection($items), 'Items retrieved successfully');
    }

    /**
     * Store a newly created Item in storage.
     * POST /items
     *
     * @param CreateItemAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateItemAPIRequest $request)
    {
        $input = $request->all();

        /** @var Item $item */
        $item = Item::create($input);

        return $this->sendResponse(new ItemResource($item), 'Item saved successfully');
    }

    /**
     * Display the specified Item.
     * GET|HEAD /items/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Item $item */
        $item = Item::find($id);

        if (empty($item)) {
            return $this->sendError('Item not found');
        }

        return $this->sendResponse(new ItemResource($item), 'Item retrieved successfully');
    }

    /**
     * Update the specified Item in storage.
     * PUT/PATCH /items/{id}
     *
     * @param int $id
     * @param UpdateItemAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateItemAPIRequest $request)
    {
        /** @var Item $item */
        $item = Item::find($id);

        if (empty($item)) {
            return $this->sendError('Item not found');
        }

        $item->fill($request->all());
        $item->save();

        return $this->sendResponse(new ItemResource($item), 'Item updated successfully');
    }

    /**
     * Remove the specified Item from storage.
     * DELETE /items/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Item $item */
        $item = Item::find($id);

        if (empty($item)) {
            return $this->sendError('Item not found');
        }

        $item->delete();

        return $this->sendSuccess('Item deleted successfully');
    }
}
