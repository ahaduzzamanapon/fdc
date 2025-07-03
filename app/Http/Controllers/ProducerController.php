<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProducerRequest;
use App\Http\Requests\UpdateProducerRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\Producer;
use Illuminate\Http\Request;
use Flash;
use Response;

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

        /** @var Producer $producer */
        $producer = Producer::create($input);

        Flash::success('Producer saved successfully.');

        return redirect(route('producers.index'));
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
}
