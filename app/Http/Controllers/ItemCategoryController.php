<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateItemCategoryRequest;
use App\Http\Requests\UpdateItemCategoryRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\ItemCategory;
use Illuminate\Http\Request;
use Flash;
use Response;

class ItemCategoryController extends AppBaseController
{
    /**
     * Display a listing of the ItemCategory.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        /** @var ItemCategory $itemCategories */
        $itemCategories = ItemCategory::paginate(10);

        return view('item_categories.index')
            ->with('itemCategories', $itemCategories);
    }

    /**
     * Show the form for creating a new ItemCategory.
     *
     * @return Response
     */
    public function create()
    {
        return view('item_categories.create');
    }

    /**
     * Store a newly created ItemCategory in storage.
     *
     * @param CreateItemCategoryRequest $request
     *
     * @return Response
     */
    public function store(CreateItemCategoryRequest $request)
    {
        $input = $request->all();

        /** @var ItemCategory $itemCategory */
        $itemCategory = ItemCategory::create($input);

        Flash::success('Item Category saved successfully.');

        return redirect(route('itemCategories.index'));
    }

    /**
     * Display the specified ItemCategory.
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
            Flash::error('Item Category not found');

            return redirect(route('itemCategories.index'));
        }

        return view('item_categories.show')->with('itemCategory', $itemCategory);
    }

    /**
     * Show the form for editing the specified ItemCategory.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        /** @var ItemCategory $itemCategory */
        $itemCategory = ItemCategory::find($id);

        if (empty($itemCategory)) {
            Flash::error('Item Category not found');

            return redirect(route('itemCategories.index'));
        }

        return view('item_categories.edit')->with('itemCategory', $itemCategory);
    }

    /**
     * Update the specified ItemCategory in storage.
     *
     * @param int $id
     * @param UpdateItemCategoryRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateItemCategoryRequest $request)
    {
        /** @var ItemCategory $itemCategory */
        $itemCategory = ItemCategory::find($id);

        if (empty($itemCategory)) {
            Flash::error('Item Category not found');

            return redirect(route('itemCategories.index'));
        }

        $itemCategory->fill($request->all());
        $itemCategory->save();

        Flash::success('Item Category updated successfully.');

        return redirect(route('itemCategories.index'));
    }

    /**
     * Remove the specified ItemCategory from storage.
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
            Flash::error('Item Category not found');

            return redirect(route('itemCategories.index'));
        }

        $itemCategory->delete();

        Flash::success('Item Category deleted successfully.');

        return redirect(route('itemCategories.index'));
    }
}
