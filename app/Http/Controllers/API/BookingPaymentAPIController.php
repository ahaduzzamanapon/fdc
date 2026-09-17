<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Http\Resources\MakePaymentResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\MakePayment;
use App\Models\Booking;
use App\Models\Package;
use Response;

/**
 * Class BookingPaymentAPIController
 * @package App\Http\Controllers\API
 */

class BookingPaymentAPIController extends AppBaseController
{
    /**
     * Display a listing of the BookingPayment with status 'success' or 'refound'.
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

        $filmPackage = $query->get();

        return $this->sendResponse(MakePaymentResource::collection($filmPackage), 'Booking Payments retrieved successfully');
    }

    /**
     * Display the specified MakePayment by trn_id.
     * GET|HEAD /booking-payments/{trn_id}
     *
     * @param string $trn_id
     *
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

        $type = $booking->type;
        $items = null;
        if ($type == 'booking') {
            $items = Booking::with(['details.item', 'details.shift', 'film', 'producer'])->find($booking->package_id);
        } else {
            $items = Package::with(['details.item', 'film', 'producer'])->find($booking->package_id);
        }
        $booking->details = $items;

        return $this->sendResponse($booking, 'Booking Payment retrieved successfully');
    }

    /**
     * Store a newly created MakePayment in storage.
     * POST /MakePayment
     *
     * @param CreateMakePaymentAPIRequest $request
     *
     * @return Response
    */
    // public function store(CreateMakePaymentAPIRequest $request)
    // {
    //     $input = $request->all();

    //     /** @var MakePayment $MakePayment */
    //     $MakePayment = MakePayment::create($input);

    //     return $this->sendResponse(new MakePaymentResource($MakePayment), 'Approval Requests saved successfully');
    // }

    /**
     * Update the specified MakePayment in storage.
     * PUT/PATCH /MakePayment/{id}
     *
     * @param int $id
     * @param UpdateMakePaymentAPIRequest $request
     *
     * @return Response
    */
    // public function update($id, UpdateMakePaymentAPIRequest $request)
    // {
    //     /** @var MakePayment $MakePayment */
    //     $MakePayment = MakePayment::find($id);

    //     if (empty($MakePayment)) {
    //         return $this->sendError('Approval Requests not found');
    //     }

    //     $MakePayment->fill($request->all());
    //     $MakePayment->save();

    //     return $this->sendResponse(new MakePaymentResource($MakePayment), 'MakePayment updated successfully');
    // }

    /**
     * Remove the specified MakePayment from storage.
     * DELETE /MakePayment/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
    */
    // public function destroy($id)
    // {
    //     /** @var MakePayment $MakePayment */
    //     $MakePayment = MakePayment::find($id);

    //     if (empty($MakePayment)) {
    //         return $this->sendError('Approval Requests not found');
    //     }

    //     $MakePayment->delete();

    //     return $this->sendSuccess('Approval Requests deleted successfully');
    // }
}
