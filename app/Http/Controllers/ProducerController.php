<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProducerRequest;
use App\Http\Requests\UpdateProducerRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\Producer;
use App\Models\Item;
use App\Models\ItemCategory;
use Illuminate\Http\Request;
use Flash;
use Response;
use Auth;
use DateTime;
use DateTimeZone;

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

        return view('producers.index')
            ->with('producers', $producers);
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



        if ($request->has('password')) {
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

        return view('producers.mainView.dashboard');
    }
    public function booking()
    {
        if (!Auth::guard('producer')->check()) {
            Flash::error('First Login');
            return redirect(url('/login'));
        }

        return view('producers.mainView.booking');
    }
    public function create_page()
    {
        if (!Auth::guard('producer')->check()) {
            Flash::error('First Login');
            return redirect(url('/login'));
        }
        return view('producers.mainView.create_page');
    }
    public function get_items_by_category(Request $request)
    {

        $cat_id = $request->category_id;
        $items = Item::where('cat_id', $cat_id)->get();
        return response()->json($items);
    }
    public function get_booking_date_by_item(Request $request)
    {

        $item_id = $request->item_id;
        $dates = [];
        $dates[] = [
            'from' => date('Y-m-d', strtotime('2025-07-13')),
            'to' => date('Y-m-d', strtotime('2025-07-15')),
        ];
        $dates[] = [
            'from' => date('Y-m-d', strtotime('2025-07-20')),
            'to' => date('Y-m-d', strtotime('2025-07-25')),
        ];

        return response()->json($dates);
    }

    public function add_to_cart(Request $request)
    {
        $item_id = $request->item_id;
        $category_id = $request->category_id;
        $booking_start_date = $request->booking_start_date;
        $booking_end_date = $request->booking_end_date;
        $start_date = new DateTime($booking_start_date);
        $end_date = new DateTime($booking_end_date);
        $interval = $start_date->diff($end_date);
        $total_day = $interval->format('%d')+1;
        $item = Item::where('id', $item_id)->first();
        $item_category = ItemCategory::where('id', $category_id)->first();
        $data = [
            'item_id' => $item->id,
            'item_name' => $item->name_bn,
            'category_id' => $item_category->id,
            'item_category_name' => $item_category->name_bn,
            'booking_start_date' => $booking_start_date,
            'booking_end_date' => $booking_end_date,
            'total_day' => $total_day,
            'total_price' => $item->amount * $total_day
        ];
        return response()->json($data);
    }











}
