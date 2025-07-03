<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProducerRequest;
use App\Http\Requests\UpdateProducerRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\Producer;
use Illuminate\Http\Request;
use Flash;
use Response;
use Auth;

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
                $folder = 'producers/' . $file_name;
                $customName = 'producers-' . $file_name . '-' . time();
                $input[$file_name] = uploadFile($file, $folder, $customName);
            } else {
                $input[$file_name] = 'no-image.png';
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
    public function producers_register(CreateProducerRequest $request)
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
                $folder = 'producers/' . $file_name;
                $customName = 'producers-' . $file_name . '-' . time();
                $input[$file_name] = uploadFile($file, $folder, $customName);
            } else {
                $input[$file_name] = 'no-image.png';
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

        Flash::success('Producer register successfully.');

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
                $folder = 'producers/'.$file_name;
                $customName = 'producers-'.$file_name.'-' . time();
                $input[$file_name] = uploadFile($file, $folder, $customName);
            } else {
                unset($input[$file_name]);
            }
        }



        if ($request->has('password')) {
            $input['password'] = bcrypt($request->password);
        }else{
            unset($input['password']);
        }

        $input['username'] = $input['phone_number'];

        $producer->fill($request->all());
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
        }else{
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
        dd(Auth::guard('producer')->user());
    }











}
