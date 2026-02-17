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
use App\Models\ProducerPaymentDetails;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Flash;

class PaymentController extends Controller
{
    // custom package
    public function initiate_cm_payment($transaction_id)
    {
        $film_package = Package::where('trn_id', $transaction_id)->first();

        if (!$film_package) {
            return response()->json(['error' => 'Transaction not found'], 404);
        }

        $amount = $film_package->amount;
        $reqst_id = $transaction_id;
        $user = Auth::guard('producer')->user();
        // Prepare request object
        $requestObj = (object) [
            'id' => $reqst_id,
            'amount' => $amount,
            'citizen_name' => $user->organization_name,
            'citizen_mobile' => $user->phone_number,
            'citizen_address' => $user->address,
        ];

        return $this->ekPayCm($requestObj);
    }
    public function ekPayCm($request)
    {
        $reqst_id = $request->id;
        $paymentUrl = 'https://sandbox.ekpay.gov.bd/ekpaypg/';
        $token = $this->ekPayTokenCm($request);
        $redirect = $paymentUrl . "v1?sToken=$token&trnsID=$reqst_id";
        return redirect($redirect);
    }
    public function ekPayTokenCm($request)
    {
        date_default_timezone_set('Asia/Dhaka');
        $req_timestamp = date('Y-m-d H:i:s') . ' GMT+6';

        $BackUrl = url('');
        $paymentUrl = 'https://sandbox.ekpay.gov.bd/ekpaypg/';
        $userName = 'bbs_test';
        $password = 'BbstaT@tsT12';
        $mac_addr = '1.1.1.1';

        // Append trnsID to callback URLs
        $responseUrlSuccess = $BackUrl . '/customPackage/payment/success';
        $responseUrlCancel = $BackUrl . '/customPackage/payment/cancel';

        $ipnUrlTrxinfo = $BackUrl . '/response-ekpay-ipn-tax';

        $payload = json_encode([
            "mer_info" => [
                "mer_reg_id" => $userName,
                "mer_pas_key" => $password
            ],
            "req_timestamp" => $req_timestamp,
            "feed_uri" => [
                "s_uri" => $responseUrlSuccess,
                "f_uri" => $responseUrlCancel,
                "c_uri" => $responseUrlCancel
            ],
            "cust_info" => [
                "cust_id" => $request->id,
                "cust_name" => $request->citizen_name,
                "cust_mobo_no" => "+88" . $request->citizen_mobile,
                "cust_mail_addr" => $request->citizen_address
            ],
            "trns_info" => [
                "trnx_id" => $request->id,
                "trnx_amt" => $request->amount,
                "trnx_currency" => "BDT",
                "ord_id" => $request->id,
                "ord_det" => "Custom Package Fee"
            ],
            "ipn_info" => [
                "ipn_channel" => "3",
                "ipn_email" => "mafizur.mysoftheaven@gmail.com",
                "ipn_uri" => $ipnUrlTrxinfo
            ],
            "mac_addr" => $mac_addr
        ]);

        //dd($payload);

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $paymentUrl . 'v1/merchant-api',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $payload,
            CURLOPT_HTTPHEADER => ['Content-Type: application/json']
        ]);
        $response = curl_exec($curl);
        curl_close($curl);
        $info = json_decode($response);
        return $info->secure_token;
    }
    public function ekPayCmSuccess(Request $request)
    {
        $transId = $request->query('transId');
        $package = Package::where('trn_id', $transId)->first();

        if (!$package) {
            return response()->json(['error' => 'Transaction not found'], 404);
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
        $data = array(
            'pay_status' => 'unpaid',
            'updated_by' => Auth::guard('producer')->user()->id,
            'updated_at' => date('Y-m-d H:i:s'),
        );
        Package::where('trn_id', $transId)->update($data);

        Flash::success('Payment cancelled');
        return redirect()->route('makePayments.cm_package_list');
    }


    // film package payment
    public function innitiate_payment($transaction_id)
    {
        $film_package = FilmPackage::where('trn_id', $transaction_id)->first();

        if (!$film_package) {
            return response()->json(['error' => 'Transaction not found'], 404);
        }

        $amount = $film_package->amount;
        $reqst_id = $transaction_id;



        // Prepare request object
        $requestObj = (object) [
            'id' => $reqst_id,
            'amount' => $amount,
            'citizen_name' => 'Demo User', // Replace with actual data if available
            'citizen_mobile' => '01700000000',
            'citizen_address' => 'Dhaka, Bangladesh',
        ];

        return $this->ekPay($requestObj);
    }

    public function ekPay($request)
    {
        $reqst_id = $request->id;
        $paymentUrl = 'https://sandbox.ekpay.gov.bd/ekpaypg/';
        $token = $this->ekPaytoken($request);
        $redirect = $paymentUrl . "v1?sToken=$token&trnsID=$reqst_id";

        return redirect($redirect);

    }

    public function ekPaytoken($request)
    {
        date_default_timezone_set('Asia/Dhaka');
        $req_timestamp = date('Y-m-d H:i:s') . ' GMT+6';

        $BackUrl = url('');
        $paymentUrl = 'https://sandbox.ekpay.gov.bd/ekpaypg/';
        $userName = 'bbs_test';
        $password = 'BbstaT@tsT12';
        $mac_addr = '1.1.1.1';

        // Append trnsID to callback URLs
        $responseUrlSuccess = $BackUrl . '/filmApplications/payment/success';
        $responseUrlCancel = $BackUrl . '/filmApplications/payment/cancel';

        $ipnUrlTrxinfo = $BackUrl . '/response-ekpay-ipn-tax';

        $payload = json_encode([
            "mer_info" => [
                "mer_reg_id" => $userName,
                "mer_pas_key" => $password
            ],
            "req_timestamp" => $req_timestamp,
            "feed_uri" => [
                "s_uri" => $responseUrlSuccess,
                "f_uri" => $responseUrlCancel,
                "c_uri" => $responseUrlCancel
            ],
            "cust_info" => [
                "cust_id" => $request->id,
                "cust_name" => $request->citizen_name,
                "cust_mobo_no" => "+88" . $request->citizen_mobile,
                "cust_mail_addr" => $request->citizen_address
            ],
            "trns_info" => [
                "trnx_id" => $request->id,
                "trnx_amt" => $request->amount,
                "trnx_currency" => "BDT",
                "ord_id" => $request->id,
                "ord_det" => "Film Application Fee"
            ],
            "ipn_info" => [
                "ipn_channel" => "3",
                "ipn_email" => "mafizur.mysoftheaven@gmail.com",
                "ipn_uri" => $ipnUrlTrxinfo
            ],
            "mac_addr" => $mac_addr
        ]);

        //dd($payload);

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $paymentUrl . 'v1/merchant-api',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $payload,
            CURLOPT_HTTPHEADER => ['Content-Type: application/json']
        ]);
        $response = curl_exec($curl);
        curl_close($curl);
        $info = json_decode($response);
        return $info->secure_token;
    }

    public function ekPaySuccess(Request $request)
    {
        $transId = $request->query('transId');
        $film_package = FilmPackage::where('trn_id', $transId)->first();

        if (!$film_package) {
            return response()->json(['error' => 'Transaction not found'], 404);
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
                $film_package->status = 'paid';
                $film_package->review_status = 'on process';
                $film_package->desk_id = $step->to_role_id;
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

                $balance_details = new ProducerPaymentDetails;
                $balance_details->producer_id = $user_id;
                $balance_details->amount = $film_package->amount;
                $balance_details->type = 'in';
                $balance_details->created_at = date('Y-m-d H:i:s');
                $balance_details->created_by = Auth::guard('producer')->user()->id;
                $balance_details->save();

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
         Flash::success('Payment cancelled');
        return redirect()->route('filmApplications.index');
    }

}








