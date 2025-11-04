<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FilmPackage;
use App\Models\FilmApplication;
use App\Models\ProducerBalance;
use App\Models\ProducerPaymentDetails;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Flash;

class PaymentController extends Controller
{
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
        $film_package->status = 'paid';
        $film_package->save();

        $user_id = $film_package->created_by;
        if ($user_id == Auth::guard('producer')->user()->id) {
            $producer_balance = ProducerBalance::where('producer_id', $user_id)->first();
            if (empty($producer_balance)) {
                $producer_balance = new ProducerBalance;
                $producer_balance->producer_id = $user_id;
                $producer_balance->total_in = $film_package->amount;
                $producer_balance->current_balance = $film_package->amount;
                $producer_balance->created_at = date('Y-m-d H:i:s');
                $producer_balance->updated_at = date('Y-m-d H:i:s');
                // dd($producer_balance);
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








