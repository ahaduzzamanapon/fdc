<?php

namespace App\Http\Controllers;
use App\Models\Noc;
use App\Models\NocSetting;
use App\Models\ApprovalFlowMaster;
use App\Models\ApprovalFlowSteps;
use App\Models\ApprovalRequests;
use App\Models\ApprovalLogs;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Flash;
use Response;
use Auth;

class NocController extends Controller
{

    private function getPayStationConfig()
    {
        return [
            'base_url' => env('PAYSTATION_BASE_URL', 'https://sandbox.paystation.com.bd'),
            'merchant_id' => env('PAYSTATION_MERCHANT_ID'),
            'password' => env('PAYSTATION_PASSWORD'),
        ];
    }

    public function make_noc_payment($noc_id) {
        $noc = Noc::where('token', $noc_id)->first();
        if (empty($noc)) {
            Flash::error('Payment Failed');
            return redirect()->route('home');
        }
        if (!empty($noc) && $noc->status != 'approved') {
            Flash::error('Payment Failed');
            return redirect()->route('home');
        }

        $amount = NocSetting::first();
        $config = $this->getPayStationConfig();
        // নতুন transaction id generate
        $tnx_id = 'TRN-' . time().rand(1000,9999);
        $BackUrl = url('');
        $postData = [
            'invoice_number' => $noc_id,
            'currency' => 'BDT',
            'payment_amount' => $amount->total ? $amount->total : 0,
            'reference' => $noc_id,
            'cust_name' => $noc->organization,
            'cust_phone' => $noc->mobile_no,
            'cust_email' => $noc->email ?? '',
            'cust_address' => $noc->address ?? 'Dhaka, Bangladesh (default)',
            'callback_url' => $BackUrl . '/noc/payment/success?transId=' . $tnx_id,
            'checkout_items' => 'NOC Application Fee',
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

    public function ekPayCmSuccess(Request $request)
    {
        // Verify transaction with PayStation API
        $trxId = $request->query('transId');
        if ($request->status === 'Successful') {
            DB::beginTransaction();
            try {
                $data = array(
                    'trx_id' => $request->trx_id,
                    'status' => 'paid',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                );
                $invoice_id = $request->invoice_number;
                $insert = Noc::where('token', $invoice_id)->update($data);
                $get = Noc::where('token', $invoice_id)->firstOrFail();
                $data1 = array(
                    'master_id' => $get->id,
                    'request_id' => null,
                    'request_type' => 'NOC Pay',
                    'flow_id' => '0',
                    'action_by' => '0',
                    'action_role_id' => '0',
                    'next_role_id' => '0',
                    'status' => 'success',
                    'remarks' => 'New Payment Success and Tnx ID: ' . $request->trx_id,
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
            return redirect()->route('home');
        } elseif ($request->status === 'Canceled') {
            Flash::error('Payment Cancelled');
            return redirect('/');
        } elseif ($request->status === 'Failed') {
            Flash::error('Payment Failed');
            return redirect('/');
        } else {
            Flash::error('Unknown Payment Status');
            return redirect('/');
        }
        return redirect()->route('home');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $noc = NocSetting::latest()->get();
        return view('noc.index', compact('noc'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('noc.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        // $flow = ApprovalFlowMaster::where('name', 'like', '%Drama Application%')->first();
        // $step = ApprovalFlowSteps::where('from_role_id', $role_id)->where('flow_id', $flow->id)->first();
        // $next = ApprovalFlowSteps::where('from_role_id', $step->to_role_id)->where('flow_id', $flow->id)->first();

        /** @var Noc $Noc */

        try {
            \DB::beginTransaction();
            $input['token'] = 'NOC-' . strtotime(date('Y-m-d H:i:s'));
            $input['current_role_id'] = 1;
            $input['status'] = 'pending';
            $input['created_at'] = date('Y-m-d H:i:s');
            $input['updated_at'] = date('Y-m-d H:i:s');
            $noc = Noc::create($input);
            $data = array(
                'flow_id' => 0,
                'request_type' => 'NOC Application',
                'application_id' => $noc->id,
                'prev_role_id' => 0,
                'current_role_id' => 16,
                'next_role_id' => 16,
                'status' => 'on process',
                'created_by' => 0,
                'updated_by' =>0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            );
            $insert = ApprovalRequests::create($data);

            $data1 = array(
                'request_id' => $insert->id,
                'request_type' => 'NOC Application',
                'flow_id' => 0,
                'action_by' => 0,
                'action_role_id' => 0,
                'next_role_id' => 16,
                'status' => 'forward',
                'remarks' => 'New Application',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            );
            $insert1 = ApprovalLogs::create($data1);
            \DB::commit();

            Flash::success('Application saved successfully. Note: Please save the Registration No. ' . $noc->token . ' and wait for approval. Thank you.');
            return redirect(route('noc.show', $noc->id));
        } catch (\Exception $e) {
            \DB::rollBack();
            Flash::error($e->getMessage());
            return redirect(route('noc.create'));
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $noc = Noc::find($id);
        return view('noc.show')->with('noc', $noc);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $noc = NocSetting::findOrFail($id);
        return view('noc.edit', compact('noc'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $noc = NocSetting::findOrFail($id);
        $input = $request->all();
        $input['total'] = $input['amount'] + $input['charge'];
        $input['updated_at'] = date('Y-m-d H:i:s');
        $input['updated_by'] = Auth::user()->id;
        $noc->update($input);
        Flash::success('Noc updated successfully.');
        return redirect(route('noc.index'));
    }

    public function showSearchList()
    {
        return view('noc.searchForm');
    }

    public function ajaxSearch(Request $request)
    {
        $token = $request->token_number;
        $noc = Noc::where('token', $token)->first();

        if (!$noc) {
            return response()->json(['status' => 'fail', 'result' => "<p class='text-danger center'> ⚠  কোনো তথ্য পাওয়া যায়নি </p>"]);
        }
        return response()->json(['status' => 'success', 'result' => $noc]);
    }

    public function downloadNoc($token)
    {
        $noc = Noc::where('token', $token)->first();
        return view('noc.downloadNoc')->with('noc', $noc);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
