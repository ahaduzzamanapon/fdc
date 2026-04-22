<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FilmPackage;
use App\Models\FilmApplication;
use App\Models\ProducerBalance;
use App\Models\ApprovalFlowMaster;
use App\Models\ApprovalFlowSteps;
use App\Models\ApprovalRequests;
use App\Models\ApprovalLogs;
use App\Models\Package;
use App\Models\Booking;
use App\Models\ProducerBalanceDetails;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\NotificationMail;
use Flash;

class PaymentController extends Controller
{
    /**
     * Get PayStation credentials from .env
     */
    private function getPayStationConfig()
    {
        return [
            'base_url' => env('PAYSTATION_BASE_URL', 'https://sandbox.paystation.com.bd'),
            'merchant_id' => env('PAYSTATION_MERCHANT_ID'),
            'password' => env('PAYSTATION_PASSWORD'),
        ];
    }

    /**
     * Initiate PayStation payment for a given set of payment data.
     * Returns redirect to PayStation payment page or back with error.
     */
    private function initiatePayStationPayment(array $paymentData)
    {
        $config = $this->getPayStationConfig();
        $postData = [
            'invoice_number' => $paymentData['invoice_number'],
            'currency' => 'BDT',
            'payment_amount' => $paymentData['amount'],
            'reference' => $paymentData['reference'] ?? $paymentData['invoice_number'],
            'cust_name' => $paymentData['cust_name'] ?? 'Customer',
            'cust_phone' => $paymentData['cust_phone'] ?? '01700000000',
            'cust_email' => $paymentData['cust_email'] ?? '',
            'cust_address' => $paymentData['cust_address'] ?? 'Dhaka, Bangladesh',
            'callback_url' => $paymentData['callback_url'],
            'checkout_items' => $paymentData['checkout_items'] ?? 'Payment',
            'merchantId' => $config['merchant_id'],
            'password' => $config['password'],
        ];

        try {
            $response = Http::asForm()->post($config['base_url'] . '/initiate-payment', $postData);

            if ($response->successful()) {
                $result = $response->json();

                // PayStation typically returns a payment URL to redirect to
                if (isset($result['payment_url'])) {
                    return redirect()->away($result['payment_url']);
                }

                // If the response itself is a redirect URL string
                if (isset($result['url'])) {
                    return redirect()->away($result['url']);
                }

                // If there's a redirect in the response
                if (isset($result['redirect_url'])) {
                    return redirect()->away($result['redirect_url']);
                }

                // Log full response for debugging
                Log::info('PayStation initiate response', ['response' => $result]);

                // Fallback: if gateway_url exists
                if (isset($result['gateway_url'])) {
                    return redirect()->away($result['gateway_url']);
                }

                Flash::error('Payment initiation failed: Unexpected response from payment gateway.');
                return back();
            } else {
                Log::error('PayStation payment initiation failed', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
                Flash::error('Payment initiation failed. Please try again.');
                return back();
            }
        } catch (\Exception $e) {
            Log::error('PayStation payment exception', ['error' => $e->getMessage()]);
            Flash::error('Payment service unavailable. Please try again later.');
            return back();
        }
    }

    /**
     * Check transaction status from PayStation
     * Uses: POST https://api.paystation.com.bd/v2/transaction-status
     * Header: merchantId
     * Body: {"trxId": "..."}
     */
    public function checkTransactionStatus($trxId)
    {
        $config = $this->getPayStationConfig();
        try {
            $response = Http::withHeaders([
                'merchantId' => $config['merchant_id'],
                'Content-Type' => 'application/json',
            ])->post($config['base_url'] . '/transaction-status', [ 'invoice_number' => $trxId, ]);

            $result = $response->json();
            Log::info('PayStation transaction status', ['invoice_number' => $trxId, 'response' => $result]);
            return $result;
        } catch (\Exception $e) {
            Log::error('PayStation status check failed', ['invoice_number' => $trxId, 'error' => $e->getMessage()]);
            return null;
        }
    }

    /**
     * Verify if a PayStation transaction was successful.
     * Returns true if status_code=200 and trx_status=success.
     */
    private function isPayStationPaymentSuccess($trxId)
    {
        $result = $this->checkTransactionStatus($trxId);
        if (!empty($result['status_code']) && $result['status_code'] == '200' && !empty($result['data']['trx_status']) && $result['data']['trx_status'] == 'successful') {
            return true;
        }
        return false;
    }

    // =============================================
    // CUSTOM PACKAGE PAYMENT
    // =============================================

    public function initiate_cm_payment($transaction_id)
    {
        $film_package = Package::where('trn_id', $transaction_id)->first();

        if (!$film_package) {
            return response()->json(['error' => 'Transaction not found'], 404);
        }

        $user = Auth::guard('producer')->user();
        $BackUrl = url('');

        return $this->initiatePayStationPayment([
            'invoice_number' => $transaction_id,
            'amount' => $film_package->amount,
            'reference' => 'CM-' . $transaction_id,
            'cust_name' => $user->organization_name,
            'cust_phone' => $user->phone_number,
            'cust_email' => $user->email ?? '',
            'cust_address' => $user->address ?? 'Dhaka, Bangladesh',
            'callback_url' => $BackUrl . '/customPackage/payment/success?transId=' . $transaction_id,
            'checkout_items' => 'Custom Package Fee',
        ]);
    }

    public function ekPayCmSuccess(Request $request)
    {
        $transId = $request->query('transId');
        $package = Package::where('trn_id', $transId)->first();

        if (!$package) {
            return response()->json(['error' => 'Transaction not found'], 404);
        }

        // Verify transaction with PayStation API
        if (!$this->isPayStationPaymentSuccess($transId)) {
            Log::warning('PayStation CM payment verification failed', ['transId' => $transId]);
            Flash::error('Payment verification failed. Please contact support.');
            return redirect()->route('makePayments.cm_package_list');
        }

        $producer = Auth::guard('producer')->user();
        $role_id = $producer->group_id;
        $flow = ApprovalFlowMaster::where('name', 'like', '%Payment Flow%')->first();
        $step = ApprovalFlowSteps::where('from_role_id', $role_id)->where('flow_id', $flow->id)->first();
        $next = ApprovalFlowSteps::where('from_role_id', $step->to_role_id)->where('flow_id', $flow->id)->first();

        DB::beginTransaction();
        try {
            $package->pay_status = 'paid';
            $package->updated_by = $producer->id;
            $package->review_status = 'on process';
            $package->desk_id = $step->to_role_id;
            $package->save();

            $data1 = array(
                'master_id' => $package->id,
                'request_id' => null,
                'request_type' => $flow->name,
                'flow_id' => $flow->id,
                'action_by' => $producer->id,
                'action_role_id' => $role_id,
                'next_role_id' => $step->to_role_id,
                'status' => 'success',
                'remarks' => 'New Payment',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            );
            $insert1 = ApprovalLogs::create($data1);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        Flash::success('Payment successful');
        return redirect()->route('makePayments.cm_package_list');
    }

    public function ekPayCmCancel(Request $request)
    {
        $transId = $request->query('transId');

        // Double-check with PayStation — maybe user cancelled but payment went through
        if ($this->isPayStationPaymentSuccess($transId)) {
            Log::info('PayStation CM cancel callback but payment was successful', ['transId' => $transId]);
            return $this->ekPayCmSuccess($request);
        }

        $data = array(
            'pay_status' => 'unpaid',
            'updated_by' => Auth::guard('producer')->user()->id,
            'updated_at' => date('Y-m-d H:i:s'),
        );
        Package::where('trn_id', $transId)->update($data);

        Flash::error('Payment cancelled');
        return redirect()->route('makePayments.cm_package_list');
    }

    // =============================================
    // FILM PACKAGE PAYMENT
    // =============================================
    public function innitiate_payment($transaction_id)
    {
        $film_package = FilmPackage::where('trn_id', $transaction_id)->first();

        if (!$film_package) {
            return response()->json(['error' => 'Transaction not found'], 404);
        }

        $user = Auth::guard('producer')->user();
        $BackUrl = url('');

        return $this->initiatePayStationPayment([
            'invoice_number' => $transaction_id,
            'amount' => $film_package->amount,
            'reference' => $film_package->type . '-' . $transaction_id,
            'cust_name' => $user->organization_name ?? 'Demo User',
            'cust_phone' => $user->phone_number ?? '01700000000',
            'cust_email' => $user->email ?? '',
            'cust_address' => $user->address ?? 'Dhaka, Bangladesh',
            'callback_url' => $BackUrl . '/filmApplications/payment/success?transId=' . $transaction_id,
            'checkout_items' => $film_package->name . ' Fee BDT',
        ]);
    }

    public function ekPaySuccess(Request $request)
    {
        $transId = $request->query('transId');
        $pstatus = $request->query('status');
        $film_package = FilmPackage::where('trn_id', $transId)->first();

        if ($pstatus == 'Canceled') {
            $data = array(
                'status' => 'canceled',
                'review_status' => 'on process',
                'updated_by' => Auth::guard('producer')->user()->id,
                'updated_at' => date('Y-m-d H:i:s'),
            );
            FilmPackage::where('trn_id', $transId)->update($data);

            if ($film_package->type == 'booking') {
                $booking = Booking::find($film_package->package_id);
                if ($booking) {
                    $booking->pay_status = 'canceled';
                    $booking->updated_by = Auth::guard('producer')->user()->id;
                    $booking->save();
                }
            }

            Flash::error('Payment cancelled');
            return redirect()->route('makePayments.index');
        }

        if (!$film_package) {
            return response()->json(['error' => 'Transaction not found'], 404);
        }

        // Verify transaction with PayStation API
        if (!$this->isPayStationPaymentSuccess($transId)) {
            Log::warning('PayStation payment verification failed', ['transId' => $transId]);
            Flash::error('Payment verification failed. Please contact support.');
            return redirect()->route('makePayments.index');
        }

        $producer = Auth::guard('producer')->user();
        $role_id = $producer->group_id;
        $flow = ApprovalFlowMaster::where('name', 'like', '%Payment Flow%')->first();
        $step = ApprovalFlowSteps::where('from_role_id', $role_id)->where('flow_id', $flow->id)->first();
        $next = ApprovalFlowSteps::where('from_role_id', $step->to_role_id)->where('flow_id', $flow->id)->first();

        DB::beginTransaction();
        try {
            $user_id = $film_package->created_by;
            if ($user_id == $producer->id) {
                $film_package->updated_by = $producer->id;
                $film_package->trn_id = $transId;
                $film_package->status = 'success';
                $film_package->review_status = 'on process';
                $film_package->desk_id = $step->to_role_id;
                $film_package->paid_at = date('Y-m-d H:i:s');
                $film_package->updated_at = date('Y-m-d H:i:s');
                $film_package->save();

                $producer_balance = ProducerBalance::where('producer_id', $user_id)->first();
                if (empty($producer_balance)) {
                    $producer_balance = new ProducerBalance;
                    $producer_balance->producer_id = $user_id;
                    $producer_balance->total_in = $film_package->amount;
                    $producer_balance->current_balance = $film_package->amount;
                    $producer_balance->created_at = date('Y-m-d H:i:s');
                    $producer_balance->updated_at = date('Y-m-d H:i:s');
                    $producer_balance->save();
                } else {
                    $producer_balance->current_balance = $producer_balance->current_balance + $film_package->amount;
                    $producer_balance->total_in = $producer_balance->total_in + $film_package->amount;
                    $producer_balance->updated_at = date('Y-m-d H:i:s');
                    $producer_balance->save();
                }

                $balance_details = new ProducerBalanceDetails;
                $balance_details->payment_id = $film_package->id;
                $balance_details->producer_id = $user_id;
                $balance_details->amount = $film_package->amount;
                $balance_details->type = 'in';
                $balance_details->created_at = date('Y-m-d H:i:s');
                $balance_details->created_by = Auth::guard('producer')->user()->id;
                $balance_details->save();

                // update booking payment status if this package is for booking
                if ($film_package->type == 'booking') {
                    $booking = Booking::find($film_package->package_id);
                    if ($booking) {
                        $booking->status = 'success';
                        $booking->pay_status = 'paid';
                        $booking->exprired_at = null;
                        $booking->updated_at = date('Y-m-d H:i:s');
                        $booking->updated_by = Auth::guard('producer')->user()->id;
                        $booking->save();
                    }
                }

                // payment approval flow
                $data = array(
                    'flow_id' => $flow->id,
                    'request_type' => $flow->name,
                    'application_id' => $producer->id,
                    'prev_role_id' => $role_id,
                    'current_role_id' => $step->to_role_id,
                    'next_role_id' => !empty($next) ? $next->to_role_id : $step->to_role_id,
                    'status' => 'on process',
                    'created_by' => $producer->id,
                    'updated_by' => $producer->id,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                );
                $insert = ApprovalRequests::create($data);

                $data1 = array(
                    'master_id' => $film_package->id,
                    'request_id' => $insert->id,
                    'request_type' => $flow->name,
                    'flow_id' => $flow->id,
                    'action_by' => $producer->id,
                    'action_role_id' => $role_id,
                    'next_role_id' => $step->to_role_id,
                    'status' => 'forward',
                    'remarks' => 'New Payment',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                );
                $insert1 = ApprovalLogs::create($data1);

                // Send email notification
                try {
                    Mail::to($producer->email)->queue(new NotificationMail([
                        'type' => 'service_acceptance',
                        'subject' => 'আপনার পেমেন্ট সফল হয়েছে',
                        'producer_name' => $producer->owners_name,
                        'status' => 'success',
                        'service_name' => $film_package->name,
                        'title' => 'আপনার পেমেন্ট সফল হয়েছে। ধন্যবাদ।',
                        'message' => 'আপনার পেমেন্ট সফল হয়েছে। আপনার আবেদনটি পর্যালোচনা করা হবে এবং শীঘ্রই আপডেট দেওয়া হবে। ধন্যবাদ।',
                    ]));
                } catch (\Throwable $e) {
                    \Log::error('Mail failed', ['error' => $e->getMessage()]);
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        Flash::success('Payment successful');
        return redirect()->route('makePayments.index');
    }

    public function ekPayCancel(Request $request)
    {
        $transId = $request->query('transId');

        // Double-check with PayStation — maybe user cancelled but payment went through
        if ($this->isPayStationPaymentSuccess($transId)) {
            Log::info('PayStation Film cancel callback but payment was successful', ['transId' => $transId]);
            return $this->ekPaySuccess($request);
        }

        Flash::error('Payment cancelled');
        return redirect()->route('filmApplications.index');
    }
}
