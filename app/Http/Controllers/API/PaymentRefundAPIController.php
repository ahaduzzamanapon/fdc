<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Http\Resources\PaymentRefundResource;
use Illuminate\Http\Request;
use App\Models\PaymentRefund;
use App\Services\BfdcAccountingService;
use Response;

/**
 * Class PaymentRefundAPIController
 * @package App\Http\Controllers\API
 */
class PaymentRefundAPIController extends AppBaseController
{
    /**
     * Display a listing of Payment Refunds.
     * GET|HEAD /payment-refunds
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $query = PaymentRefund::latest();

        if ($request->has('status')) {
            $query->where('status', strtolower($request->status));
        }

        if ($request->has('type')) {
            $query->where('type', strtolower($request->type));
        }

        if ($request->has('date')) {
            $query->whereDate('created_at', $request->date);
        }

        if ($request->get('limit')) {
            $query->limit((int) $request->get('limit'));
        }

        $refunds = $query->get();

        return $this->sendResponse(
            PaymentRefundResource::collection($refunds),
            'Payment Refunds retrieved successfully'
        );
    }

    /**
     * Display the specified Payment Refund by ID or TRN ID.
     * GET|HEAD /payment-refunds/{identifier}
     *
     * @param string $identifier
     * @return Response
     */
    public function show($identifier)
    {
        $refund = null;

        if (str_starts_with(strtoupper($identifier), 'RFD-')) {
            $numId = (int) substr($identifier, 4);
            $refund = PaymentRefund::find($numId);
        }

        if (!$refund && is_numeric($identifier)) {
            $refund = PaymentRefund::find((int) $identifier);
        }

        if (!$refund) {
            $refund = PaymentRefund::where('trn_id', $identifier)->first();
        }

        if (empty($refund)) {
            return $this->sendError('Payment Refund not found', 404);
        }

        return $this->sendResponse(
            new PaymentRefundResource($refund),
            'Payment Refund retrieved successfully'
        );
    }

    /**
     * Trigger manual push of a refund record to the external BFDC Accounting System.
     * POST /payment-refunds/push
     *
     * @param Request $request
     * @param BfdcAccountingService $accountingService
     * @return Response
     */
    public function pushManual(Request $request, BfdcAccountingService $accountingService)
    {
        $request->validate([
            'identifier' => 'required|string',
        ]);

        $identifier = $request->identifier;
        $refund = null;

        if (str_starts_with(strtoupper($identifier), 'RFD-')) {
            $numId = (int) substr($identifier, 4);
            $refund = PaymentRefund::find($numId);
        }

        if (!$refund && is_numeric($identifier)) {
            $refund = PaymentRefund::find((int) $identifier);
        }

        if (!$refund) {
            $refund = PaymentRefund::where('trn_id', $identifier)->first();
        }

        if (empty($refund)) {
            return $this->sendError('Payment Refund record not found for the given identifier', 404);
        }

        $result = $accountingService->pushRefundToAccounting($refund);

        if ($result['success']) {
            return $this->sendResponse($result, 'Payment Refund pushed to BFDC Accounting successfully');
        }

        return $this->sendError(
            'Failed to push refund to Accounting: ' . ($result['error'] ?? 'Unknown error'),
            $result['status'] ?? 500,
            $result
        );
    }
}
