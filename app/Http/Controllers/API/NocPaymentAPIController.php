<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Http\Resources\NocPaymentResource;
use App\Models\Noc;
use Illuminate\Http\Request;
use Response;

/**
 * Class NocPaymentAPIController
 * @package App\Http\Controllers\API
 */
class NocPaymentAPIController extends AppBaseController
{
    /**
     * Display a listing of NOC Payments.
     * GET|HEAD /noc-payments
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $query = Noc::query();

        // Default to showing paid or filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        } else {
            $query->whereIn('status', ['paid', 'success', 'approved']);
        }

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('trx_id', 'like', "%{$search}%")
                  ->orWhere('token', 'like', "%{$search}%")
                  ->orWhere('producer', 'like', "%{$search}%")
                  ->orWhere('organization', 'like', "%{$search}%")
                  ->orWhere('full_name', 'like', "%{$search}%")
                  ->orWhere('mobile_no', 'like', "%{$search}%");
            });
        }

        if ($request->has('date')) {
            $query->whereDate('updated_at', $request->date);
        }

        if ($request->get('limit')) {
            $query->limit((int) $request->get('limit'));
        }

        $nocPayments = $query->latest()->get();

        return $this->sendResponse(
            NocPaymentResource::collection($nocPayments),
            'NOC Payments retrieved successfully'
        );
    }

    /**
     * Display the specified NOC Payment by token, trx_id or secure ID.
     * GET|HEAD /noc-payments/{identifier}
     *
     * @param string $identifier
     * @return Response
     */
    public function show($identifier)
    {
        // Try finding by token, trx_id or ID
        $query = Noc::where('token', $identifier)
            ->orWhere('trx_id', $identifier);

        if (is_numeric($identifier)) {
            $query->orWhere('id', $identifier);
        }

        $noc = $query->first();

        if (empty($noc)) {
            // Also check if it's prefixed NOC-00001
            if (str_starts_with(strtoupper($identifier), 'NOC-')) {
                $rawId = (int) substr($identifier, 4);
                $noc = Noc::find($rawId);
            }
        }

        if (empty($noc)) {
            return $this->sendError('NOC Payment not found');
        }

        return $this->sendResponse(
            new NocPaymentResource($noc),
            'NOC Payment retrieved successfully'
        );
    }
}
