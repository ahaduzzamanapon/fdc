<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Http\Resources\ProducerPartyResource;
use App\Models\Producer;
use Illuminate\Http\Request;
use Response;

/**
 * Class ProducerPartyAPIController
 * @package App\Http\Controllers\API
 */
class ProducerPartyAPIController extends AppBaseController
{
    /**
     * Display a listing of Producers / Parties.
     * GET|HEAD /parties or /producers
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $query = Producer::query();

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('organization_name', 'like', "%{$search}%")
                  ->orWhere('owners_name', 'like', "%{$search}%")
                  ->orWhere('phone_number', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $producers = $query->latest()->get();

        return $this->sendResponse(ProducerPartyResource::collection($producers), 'Producers/Parties retrieved successfully');
    }

    /**
     * Display the specified Producer / Party.
     * GET|HEAD /parties/{id} or /producers/{id}
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        /** @var Producer $producer */
        $producer = Producer::find($id);

        if (empty($producer)) {
            return $this->sendError('Producer/Party not found');
        }

        return $this->sendResponse(new ProducerPartyResource($producer), 'Producer/Party retrieved successfully');
    }
}
