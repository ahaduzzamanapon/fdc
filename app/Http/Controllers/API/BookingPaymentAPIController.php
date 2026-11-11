<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Http\Resources\MakePaymentResource;
use Illuminate\Http\Request;
use App\Models\MakePayment;
use App\Models\FilmPackage;
use App\Services\BfdcAccountingService;
use Response;

/**
 * Class BookingPaymentAPIController
 * @package App\Http\Controllers\API
 */
class BookingPaymentAPIController extends AppBaseController
{
    /**
     * Display a listing of BookingPayments formatted for Accounting with Party & Bill Memo.
     * GET|HEAD /booking-payments
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $allowedStatuses = ['success', 'refound', 'refund'];

        $query = MakePayment::latest();

        if ($request->has('status') && in_array(strtolower($request->status), $allowedStatuses)) {
            $query->where('status', strtolower($request->status));
        } else {
            $query->whereIn('status', $allowedStatuses);
        }

        if ($request->has('date')) {
            $query->whereDate('paid_at', $request->date);
        }

        if ($request->get('limit')) {
            $query->limit((int) $request->get('limit'));
        }

        $filmPackages = $query->get();

        return $this->sendResponse(
            MakePaymentResource::collection($filmPackages),
            'Booking Payments retrieved successfully'
        );
    }

    /**
     * Display a specific MakePayment by trn_id or TrxID.
     * GET|HEAD /booking-payments/{trn_id}
     *
     * @param string $trn_id
     * @return Response
     */
    public function show($trn_id)
    {
        /** @var MakePayment $booking */
        $booking = MakePayment::where('trn_id', $trn_id)
            ->orWhere('TrxID', $trn_id)
            ->first();

        if (empty($booking)) {
            return $this->sendError('Booking Payment not found');
        }

        return $this->sendResponse(
            new MakePaymentResource($booking),
            'Booking Payment retrieved successfully'
        );
    }

    /**
     * Push payment(s) to BFDC Accounting manually from Admin or API.
     * POST /api/booking-payments/push
     *
     * @param Request $request
     * @param BfdcAccountingService $service
     * @return Response
     */
    public function pushManual(Request $request, BfdcAccountingService $service)
    {
        $id = $request->input('id');
        $trnId = $request->input('trn_id');
        $trxId = $request->input('trx_id');

        if ($id || $trnId || $trxId) {
            $payment = FilmPackage::when($id, fn($q) => $q->where('id', $id))
                ->when($trnId, fn($q) => $q->where('trn_id', $trnId))
                ->when($trxId, fn($q) => $q->where('TrxID', $trxId))
                ->first();

            if (!$payment) {
                return $this->sendError('Payment record not found');
            }

            $result = $service->pushToAccounting($payment);
            return $this->sendResponse($result, 'Payment pushed to Accounting');
        }

        // Batch manual push for latest successful payments
        $limit = (int) $request->input('limit', 10);
        $payments = FilmPackage::where('status', 'success')->latest()->limit($limit)->get();

        $results = [];
        foreach ($payments as $p) {
            $results[] = $service->pushToAccounting($p);
        }

        return $this->sendResponse([
            'count' => count($results),
            'items' => $results
        ], 'Batch push to Accounting completed');
    }
}
