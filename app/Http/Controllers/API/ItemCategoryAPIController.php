<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateItemCategoryAPIRequest;
use App\Http\Requests\API\UpdateItemCategoryAPIRequest;
use App\Models\ItemCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\ItemCategoryResource;
use Response;

/**
 * Class ItemCategoryController
 * @package App\Http\Controllers\API
 */

class ItemCategoryAPIController extends AppBaseController
{
    /**
     * Display a listing of the ItemCategory.
     * GET|HEAD /itemCategories
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $query = ItemCategory::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $itemCategories = $query->get();

        return $this->sendResponse(ItemCategoryResource::collection($itemCategories), 'Item Categories retrieved successfully');
    }

    /**
     * Store a newly created ItemCategory in storage.
     * POST /itemCategories
     *
     * @param CreateItemCategoryAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateItemCategoryAPIRequest $request)
    {
        $input = $request->all();

        /** @var ItemCategory $itemCategory */
        $itemCategory = ItemCategory::create($input);

        return $this->sendResponse(new ItemCategoryResource($itemCategory), 'Item Category saved successfully');
    }

    /**
     * Display the specified ItemCategory.
     * GET|HEAD /itemCategories/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var ItemCategory $itemCategory */
        $itemCategory = ItemCategory::find($id);

        if (empty($itemCategory)) {
            return $this->sendError('Item Category not found');
        }

        return $this->sendResponse(new ItemCategoryResource($itemCategory), 'Item Category retrieved successfully');
    }

    /**
     * Update the specified ItemCategory in storage.
     * PUT/PATCH /itemCategories/{id}
     *
     * @param int $id
     * @param UpdateItemCategoryAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateItemCategoryAPIRequest $request)
    {
        /** @var ItemCategory $itemCategory */
        $itemCategory = ItemCategory::find($id);

        if (empty($itemCategory)) {
            return $this->sendError('Item Category not found');
        }

        $itemCategory->fill($request->all());
        $itemCategory->save();

        return $this->sendResponse(new ItemCategoryResource($itemCategory), 'ItemCategory updated successfully');
    }

    /**
     * Remove the specified ItemCategory from storage.
     * DELETE /itemCategories/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var ItemCategory $itemCategory */
        $itemCategory = ItemCategory::find($id);

        if (empty($itemCategory)) {
            return $this->sendError('Item Category not found');
        }

        $itemCategory->delete();

        return $this->sendSuccess('Item Category deleted successfully');
    }
}
