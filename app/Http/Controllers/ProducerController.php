<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProducerRequest;
use App\Http\Requests\UpdateProducerRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\Package;
use App\Models\Producer;
use App\Models\Item;
use App\Models\ItemCategory;
use App\Models\FilmApplication as Film;
use App\Models\ProducerBalance;
use App\Models\RealityApplication;
use App\Models\DocufilmApplication;
use App\Models\DramaApplication;
use App\Models\ApprovalFlowMaster;
use App\Models\ApprovalFlowSteps;
use App\Models\ApprovalRequests;
use App\Models\ApprovalLogs;
use Illuminate\Http\Request;
use Flash;
use Response;
use Auth;
use DateTime;
use DateTimeZone;
use App\Models\Booking;
use App\Models\BookingDetail;
use App\Models\Shift;
use Illuminate\Support\Facades\DB;

class ProducerController extends AppBaseController
{
    /**
     * Display a listing of the Producer.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {


        /** @var Producer $producers */
        $producers = Producer::all();

        return view('producers.index')->with('producers', $producers);
    }

    /**
     * Show the form for creating a new Producer.
     *
     * @return Response
     */
    public function create()
    {
        return view('producers.create');
    }

    /**
     * Store a newly created Producer in storage.
     *
     * @param CreateProducerRequest $request
     *
     * @return Response
     */
    public function store(CreateProducerRequest $request)
    {
        $input = $request->all();

        $input_file = [
            'bank_attachment',
            'tin_attachment',
            'vat_attachment',
            'trade_license_attachment',
            'nominee_photo',
            'partnership_agreement',
            'ltd_company_agreement',
            'somobay_agreement',
            'other_attachment',
        ];
        foreach ($input_file as $file_name) {
            if ($request->hasFile($file_name)) {
                $file = $request->file($file_name);
                $folder = 'producers_file/' . $file_name;
                $customName = 'producers_file-' . $file_name . '-' . time();
                $input[$file_name] = uploadFile($file, $folder, $customName);
            } else {
                unset($input[$file_name]);
            }
        }


        if ($request->has('password')) {
            $input['password'] = bcrypt($request->password);
        } else {
            $input['password'] = bcrypt('12345678');
        }

        $input['status'] = 'Inactive';
        $input['username'] = $input['phone_number'];

        /** @var Producer $producer */
        $producer = Producer::create($input);

        Flash::success('Producer saved successfully.');

        return redirect(route('producers.index'));
    }
    public function producers_register(Request $request)
    {
        $input = $request->all();

        // Handle single file uploads
        $input_file = [
            'bank_attachment',
            'tin_attachment',
            'vat_attachment',
            'trade_license_attachment',
            'nominee_photo',
        ];

        foreach ($input_file as $file_name) {
            if ($request->hasFile($file_name)) {
                $file = $request->file($file_name);
                $folder = 'producers_file/' . $file_name;
                $customName = 'producers_file-' . $file_name . '-' . time();
                $input[$file_name] = uploadFile($file, $folder, $customName);
            } else {
                unset($input[$file_name]);
            }
        }

        // Handle multiple file-name pairs as JSON and store in a single string column
        $multi_file_fields = [
            'partnership' => 'partnership_attachment',
            'ltd_company' => 'ltd_company_attachment',
            'somobay' => 'somobay_attachment',
            'other' => 'other_attachment',
        ];

        foreach ($multi_file_fields as $field => $fileField) {
            $nameInput = $request->input($field . '_name', []);
            $fileInput = $request->file($fileField, []);
            $combinedData = [];

            foreach ($nameInput as $index => $name) {
                if (!empty($name) && isset($fileInput[$index])) {
                    $file = $fileInput[$index];
                    $folder = 'producers_file/' . $fileField;
                    $customName = $field . '-' . $index . '-' . time();
                    $filePath = uploadFile($file, $folder, $customName);
                    $combinedData[] = [
                        'name' => $name,
                        'file' => $filePath,
                    ];
                }
            }

            // Save as JSON string into corresponding single column
            $columnName = $field . '_agreement'; // e.g. partnership_agreement
            $input[$columnName] = json_encode($combinedData); // Store as JSON string
        }

        // Handle password
        $input['password'] = bcrypt($request->input('password', '12345678'));
        $input['status'] = 'Inactive';
        $input['username'] = $input['phone_number'];
        $input['other_attachment'] = $input['other_agreement'];
        unset(
            $input['partnership_name'],
            $input['ltd_company_name'],
            $input['somobay_name'],
            $input['other_name'],
            $input['partnership_attachment'],
            $input['ltd_company_attachment'],
            $input['somobay_attachment'],
            $input['other_agreement']
        );

        // Save producer
        $producer = Producer::create($input);

        Flash::success('Producer registered successfully.');
        return redirect(route('login'));

    }


    /**
     * Display the specified Producer.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Producer $producer */
        $producer = Producer::find($id);

        if (empty($producer)) {
            Flash::error('Producer not found');

            return redirect(route('producers.index'));
        }

        return view('producers.show')->with('producer', $producer);
    }

    /**
     * Show the form for editing the specified Producer.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        /** @var Producer $producer */
        $producer = Producer::find($id);

        if (empty($producer)) {
            Flash::error('Producer not found');

            return redirect(route('producers.index'));
        }

        return view('producers.edit')->with('producer', $producer);
    }

    /**
     * Update the specified Producer in storage.
     *
     * @param int $id
     * @param UpdateProducerRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateProducerRequest $request)
    {
        /** @var Producer $producer */
        $producer = Producer::find($id);

        if (empty($producer)) {
            Flash::error('Producer not found');

            return redirect(route('producers.index'));
        }

        $input = $request->all();

        $input_file = [
            'bank_attachment',
            'tin_attachment',
            'vat_attachment',
            'trade_license_attachment',
            'nominee_photo',
            'partnership_agreement',
            'ltd_company_agreement',
            'somobay_agreement',
            'other_attachment',
        ];
        foreach ($input_file as $file_name) {
            if ($request->hasFile($file_name)) {
                $file = $request->file($file_name);
                $folder = 'producers_file/' . $file_name;
                $customName = 'producers_file-' . $file_name . '-' . time();
                $input[$file_name] = uploadFile($file, $folder, $customName);
            } else {
                unset($input[$file_name]);
            }
        }



        if ($request->has('password') && !empty($request->password) && $request->password != '') {
            $input['password'] = bcrypt($request->password);
        } else {
            unset($input['password']);
        }

        $input['username'] = $input['phone_number'];

        $producer->fill($input);
        $producer->save();

        Flash::success('Producer updated successfully.');

        return redirect(route('producers.index'));
    }

    /**
     * Remove the specified Producer from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Producer $producer */
        $producer = Producer::find($id);

        if (empty($producer)) {
            Flash::error('Producer not found');

            return redirect(route('producers.index'));
        }

        $producer->delete();

        Flash::success('Producer deleted successfully.');

        return redirect(route('producers.index'));
    }

    public function producers_login(Request $request)
    {
        $username = $request->username;
        $password = $request->password;
        Auth::guard('producer')->attempt([
            'username' => $username,
            'password' => $password,
        ]);

        if (Auth::guard('producer')->check()) {
            return redirect(url('producer/dashboard'));
        } else {
            Flash::error('Login Failed');
            return redirect(url('/login'));
        }
    }

    public function dashboard()
    {
        if (!Auth::guard('producer')->check()) {
            Flash::error('First Login');
            return redirect(url('/login'));
        }
        $producer_id = Auth::guard('producer')->user()->id;
        $bookings = Booking::where('producer_id', $producer_id)
                ->where('status', '!=', 'reject')
                ->selectRaw("
                    COUNT(*) AS totalRow,
                    SUM(CASE WHEN status = 'on process' THEN 1 ELSE 0 END) AS pendingRow,
                    SUM(CASE WHEN status = 'approved' THEN 1 ELSE 0 END) AS approveRow
                ")
                ->first();
        $films = Film::where('producer_id', $producer_id)
                ->where('status', '!=', 'reject')
                ->selectRaw("
                    COUNT(*) AS totalRow,
                    SUM(CASE WHEN status = 'on process' THEN 1 ELSE 0 END) AS pendingRow,
                    SUM(CASE WHEN status = 'approved' THEN 1 ELSE 0 END) AS approveRow
                ")
                ->first();
        $dramas = DramaApplication::where('producer_id', $producer_id)
                ->where('status', '!=', 'reject')
                ->selectRaw("
                    COUNT(*) AS totalRow,
                    SUM(CASE WHEN status = 'on process' THEN 1 ELSE 0 END) AS pendingRow,
                    SUM(CASE WHEN status = 'approved' THEN 1 ELSE 0 END) AS approveRow
                ")
                ->first();
        $docufilms = DocufilmApplication::where('producer_id', $producer_id)
                ->where('status', '!=', 'reject')
                ->selectRaw("
                    COUNT(*) AS totalRow,
                    SUM(CASE WHEN status = 'on process' THEN 1 ELSE 0 END) AS pendingRow,
                    SUM(CASE WHEN status = 'approved' THEN 1 ELSE 0 END) AS approveRow
                ")
                ->first();
        $reality = RealityApplication::where('producer_id', $producer_id)
                ->where('status', '!=', 'reject')
                ->selectRaw("
                    COUNT(*) AS totalRow,
                    SUM(CASE WHEN status = 'on process' THEN 1 ELSE 0 END) AS pendingRow,
                    SUM(CASE WHEN status = 'approved' THEN 1 ELSE 0 END) AS approveRow
                ")
                ->first();

        return view('producers.mainView.dashboard', compact('bookings', 'films', 'dramas', 'docufilms', 'reality'));
    }
    public function booking()
    {

        if (!Auth::guard('producer')->check()) {
          $booking_requests = Booking::join('producers', 'producers.id', '=', 'bookings.producer_id')
            ->select('bookings.*', 'producers.organization_name as producer_name')
            ->get();
        }else{
            $booking_requests = Booking::join('producers', 'producers.id', '=', 'bookings.producer_id')
            ->where('bookings.producer_id', Auth::guard('producer')->user()->id)
            ->select('bookings.*', 'producers.organization_name as producer_name')
            ->get();
        }

        return view('producers.mainView.booking', compact('booking_requests'));
    }
    public function create_page()
    {
        if (!Auth::guard('producer')->check()) {
            Flash::error('First Login');
            return redirect(url('/login'));
        }
        return view('producers.mainView.create_page');
    }

    public function get_application(Request $request)
    {
        $user = Auth::guard('producer')->user();
        if ($request->filmId == 'drama') {
            $items = DramaApplication::where('producer_id', $user->id)->where('status', 'approved')->get();
        } elseif ($request->filmId == 'realityshow') {
            $items = RealityApplication::where('producer_id', $user->id)->where('status', 'approved')->get();
        } elseif ($request->filmId == 'docufilm') {
            $items = DocufilmApplication::where('producer_id', $user->id)->where('status', 'approved')->get();
        } else {
            $items = Film::where('producer_id', $user->id)->where('status', 'approved')->get();
        }

        return response()->json($items);
    }

    public function get_applicant_balance(Request $request)
    {

        $user_id = Auth::guard('producer')->user()->id;
        $items = ProducerBalance::where('producer_id', $user_id)->first();
        $balance = !empty($items->current_balance) ? $items->current_balance : 0;
        return response()->json($balance);
    }

    public function get_items_by_category(Request $request)
    {

        $cat_id = $request->category_id;
        $items = Item::where('cat_id', $cat_id)->get();
        return response()->json($items);
    }

    public function get_shift_by_item(Request $request)
    {

        $item_id = $request->item_id;
        $Shift = Shift::where('item_id', $item_id)->get();
        return response()->json($Shift);
    }
    public function get_booking_date_by_shift(Request $request)
    {
        $shift_id = $request->shift_id;
        // Get all date ranges where the item is booked
        $bookedDates = BookingDetail::where('shift_id', $shift_id)
            ->select('start_date as from', 'end_date as to')
            ->get();
        return response()->json($bookedDates);
    }

    public function add_to_cart(Request $request)
    {
        $item_id = $request->item_id;
        $shift_id = $request->shift_id;
        $category_id = $request->category_id;
        $booking_start_date = $request->booking_start_date;
        $booking_end_date = $request->booking_end_date;
        $start_date = new DateTime($booking_start_date);
        $end_date = new DateTime($booking_end_date);
        $interval = $start_date->diff($end_date);
        $total_day = $interval->format('%d') + 1;
        $item = Item::join('itemunits', 'items.unit_id', '=', 'itemunits.id')
            ->where('items.id', $item_id)
            ->select('items.*', 'itemunits.name_bn as unit_name_bn')
            ->first();
        $item_category = ItemCategory::where('id', $category_id)->first();
        $shift = Shift::where('id', $shift_id)->first();
        $data = [
            'item_id' => $item->id,
            'shift_id' => $shift->id,
            'shift_name' => $shift->name,
            'item_name' => $item->name_bn,
            'item_unit' => $item->unit_name_bn,
            'item_price' => $item->amount,
            'category_id' => $item_category->id,
            'item_category_name' => $item_category->name_bn,
            'booking_start_date' => $booking_start_date,
            'booking_end_date' => $booking_end_date,
            'total_day' => $total_day,
            'total_price' => $item->amount * $total_day
        ];
        return response()->json($data);
    }

    // Booking item insert by producer
    public function producer_booking_request(Request $request)
    {
        // dd($request->all());
        $producer = Auth::guard('producer')->user();
        $role_id = $producer->group_id;
        $flow = ApprovalFlowMaster::where('name', 'like', '%Booking Flow%')->first();
        $step = ApprovalFlowSteps::where('from_role_id', $role_id)->where('flow_id', $flow->id)->first();
        $next = ApprovalFlowSteps::where('from_role_id', $step->to_role_id)->where('flow_id', $flow->id)->first();

        DB::beginTransaction();
        try {
            // 1. Create Booking
            $booking = Booking::create([
                'book_id' => 'BOOK-' . time() . '-' . Auth::guard('producer')->user()->id . '-' . rand(1000, 9999),
                'status' => 'on process',
                'desk_id' => $step->to_role_id,
                'film_id' => $request->input('film_id'),
                'film_type' => $request->input('film_type'),
                'producer_id' => $producer->id, // or pass producer_id from $request
                'total_price' => $request->input('total_price_input_total'),
            ]);

            // 2. Loop through booking details
            $item_ids = $request->input('item_id');
            $shift_ids = $request->input('shift_id');
            $category_ids = $request->input('category_id');
            $start_dates = $request->input('booking_start_date');
            $end_dates = $request->input('booking_end_date');
            $total_prices = $request->input('total_price');

            foreach ($item_ids as $i => $item_id) {
                $start = \Carbon\Carbon::parse($start_dates[$i]);
                $end = \Carbon\Carbon::parse($end_dates[$i]);
                $total_day = $start->diffInDays($end) + 1;
                BookingDetail::create([
                    'booking_id' => $booking->id,
                    'catagori' => $category_ids[$i],
                    'item_id' => $item_id,
                    'shift_id' => $shift_ids[$i],
                    'amount' => 1,
                    'start_date' => $start_dates[$i],
                    'end_date' => $end_dates[$i],
                    'total_day' => $total_day,
                    'total_amount' => $total_prices[$i],
                ]);
            }

            $data = array(
                'flow_id' => $flow->id,
                'request_type' => $flow->name,
                'application_id' => $booking->id,
                'prev_role_id' => $role_id,
                'current_role_id' => $step->to_role_id,
                'next_role_id' => $next->to_role_id,
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
                'remarks' => 'New Booking Created',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            );
            $insert1 = ApprovalLogs::create($data1);

            DB::commit();
            Flash::success('Booking created successfully!');
            return redirect(route('producer.booking'));
        } catch (\Exception $e) {
            DB::rollBack();
            Flash::error('Failed to create booking: ' . $e->getMessage());
            return back()->with('error', 'Failed to create booking: ' . $e->getMessage());
        }
    }

    public function forward_table(Request $request)
    {
        $user = Auth::user()->user_role;
        $producers = Booking::latest()->where('bookings.status', 'on process')->where('bookings.desk_id', $user)->join('producers', 'producers.id', '=', 'bookings.producer_id')
            ->select('bookings.*', 'producers.organization_name as producer_name')
            ->get();
        return view('producers.mainView.booking')->with('booking_requests', $producers);
    }

    public function forward(Booking $booking, $desk)
    {
        $app_id = $booking->id;
        $role_id = $booking->desk_id;
        $auth_user = ApprovalRequests::where('application_id', $app_id)->where('request_type', 'Booking Flow')->where('current_role_id', $role_id)->first();
        $logs = ApprovalLogs::where('request_id', $auth_user->id)->where('flow_id', $auth_user->flow_id)->get();

        return view('producers.mainView.forward', [
            'booking' => $booking,
            'auth_user' => $auth_user,
            'logs' => $logs,
        ]);
    }

    public function update_status(Request $request)
    {

        $booking = Booking::find($request->booking);
        $steps = ApprovalRequests::find($request->request_id);
        if ($request->status == 'backward') {
            $prev = ApprovalFlowSteps::where('to_role_id', $steps->prev_role_id)->where('flow_id', $steps->flow_id)->first();
            $prev_role_id = !empty($prev->from_role_id) ? $prev->from_role_id : $steps->current_role_id;
            $current_role_id = $steps->prev_role_id;
            $next_role_id = $steps->current_role_id;
            $fstatus = 'backward';
            $status = "on process";
        } else if ($request->status == 'forward') {
            $next = ApprovalFlowSteps::where('from_role_id', $steps->next_role_id)->where('flow_id', $steps->flow_id)->first();
            $prev_role_id = $steps->current_role_id;
            $current_role_id = $steps->next_role_id;
            $next_role_id = !empty($next->to_role_id) ? $next->to_role_id : $steps->current_role_id;
            $fstatus = 'forward';
            $status = "on process";
        } else {
            $prev_role_id = $steps->current_role_id;
            $current_role_id = $steps->current_role_id;
            $next_role_id = $steps->current_role_id;
            $fstatus = $request->status;
            $status = $request->status;
        }

        if (empty(Auth::user())) {
            $users = Auth::guard('producer')->user();
            $user_id = $users->id;
            $user_role = $users->group_id;
        } else {
            $users = Auth::user();
            $user_id = $users->id;
            $user_role = $users->user_role;
        }

        // filmapplications
        $data = array(
            'desk_id' => $current_role_id,
            'status' => $status,
            'updated_by' => $user_id,
            'updated_at' => date('Y-m-d H:i:s'),
        );

        // approval_requests
        $data1 = array(
            'prev_role_id' => $prev_role_id,
            'current_role_id' => $current_role_id,
            'next_role_id' => $next_role_id,
            'status' => $status,
            'updated_by' => $user_id,
            'updated_at' => date('Y-m-d H:i:s'),
        );
        // approval_logs
        $data2 = array(
            'request_id' => $request->request_id,
            'request_type' => $steps->request_type,
            'flow_id' => $steps->flow_id,
            'action_by' => $user_id,
            'action_role_id' => $user_role,
            'next_role_id' => $current_role_id,
            'status' => $fstatus,
            'remarks' => $request->log_remarks,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_by' => $user_id,
            'updated_at' => date('Y-m-d H:i:s'),
        );

        try {
            \DB::beginTransaction();
            RealityApplication::where('id', $request->booking)->update($data);
            ApprovalRequests::where('id', $request->request_id)->update($data1);
            ApprovalLogs::create($data2);
            \DB::commit();
            Flash::success('Reality Application updated successfully.');
        } catch (\Exception $e) {
            \DB::rollBack();
            Flash::error('Reality Application update failed. Please try again later.');
        }

        if (empty(Auth::user())) {
            return redirect(route('realityApplications.index'));
        } else {
            return redirect(route('realityApplications.forward.table'));
        }
    }

    public function approve_booking($id)
    {

        $booking = Booking::find($id);

        if (empty($booking)) {
            Flash::error('Booking not found');
            return redirect(route('producer.booking'));
        }

        $booking->status = 'approved';
        $booking->save();

        Flash::success('Booking approved successfully!');
        return redirect(route('producer.booking_details', $id));
    }

    public function show_booking_details($id)
    {


        $booking = Booking::with(['details.item', 'details.shift', 'film', 'producer'])->find($id);

        if (empty($booking)) {
            Flash::error('Booking not found');
            return redirect(route('producer.booking'));
        }

        return view('producers.mainView.booking_details', compact('booking'));
    }
}

