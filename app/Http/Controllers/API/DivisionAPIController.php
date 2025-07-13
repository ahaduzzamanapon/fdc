<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateDivisionAPIRequest;
use App\Http\Requests\API\UpdateDivisionAPIRequest;
use App\Models\Division;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\DivisionResource;
use Response;

/**
 * Class DivisionController
 * @package App\Http\Controllers\API
 */

class DivisionAPIController extends AppBaseController
{
    /**
     * Display a listing of the Division.
     * GET|HEAD /divisions
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $query = Division::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $divisions = $query->get();

        return $this->sendResponse(DivisionResource::collection($divisions), 'Divisions retrieved successfully');
    }

    /**
     * Store a newly created Division in storage.
     * POST /divisions
     *
     * @param CreateDivisionAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateDivisionAPIRequest $request)
    {
        $input = $request->all();

        /** @var Division $division */
        $division = Division::create($input);

        return $this->sendResponse(new DivisionResource($division), 'Division saved successfully');
    }

    /**
     * Display the specified Division.
     * GET|HEAD /divisions/{id}
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
            return $this->sendError('Division not found');
        }

        return $this->sendResponse(new DivisionResource($division), 'Division retrieved successfully');
    }

    /**
     * Update the specified Division in storage.
     * PUT/PATCH /divisions/{id}
     *
     * @param int $id
     * @param UpdateDivisionAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateDivisionAPIRequest $request)
    {
        /** @var Division $division */
        $division = Division::find($id);

        if (empty($division)) {
            return $this->sendError('Division not found');
        }

        $division->fill($request->all());
        $division->save();

        return $this->sendResponse(new DivisionResource($division), 'Division updated successfully');
    }

    /**
     * Remove the specified Division from storage.
     * DELETE /divisions/{id}
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
            return $this->sendError('Division not found');
        }

        $division->delete();

        return $this->sendSuccess('Division deleted successfully');
    }
}
