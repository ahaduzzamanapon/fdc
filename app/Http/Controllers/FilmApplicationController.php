<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateFilmApplicationRequest;
use App\Http\Requests\UpdateFilmApplicationRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\FilmApplication;
use App\Models\Package;
use App\Models\FilmPackage;
use Illuminate\Http\Request;
use Flash;
use Response;
use Auth;

class FilmApplicationController extends AppBaseController
{
    /**
     * Display a listing of the FilmApplication.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {

        if (!Auth::guard('producer')->check()) {
            $filmApplications = FilmApplication::latest();
        } else {
            $filmApplications = FilmApplication::latest()
                ->where('producer_id', Auth::guard('producer')->user()->id);
        }



        $filmApplications = $filmApplications->get();

        return view('film_applications.index')->with('filmApplications', $filmApplications);
    }
    public function forward_table(Request $request)
    {
        $my_all_permissions=my_all_permissions();
        $filmApplications = FilmApplication::latest()
        ->where('state', 'forward')
        ->whereIn('desk', $my_all_permissions)
        ->get();
        return view('film_applications.index')
            ->with('filmApplications', $filmApplications);
    }
    public function backward_table(Request $request)
    {
        $my_all_permissions=my_all_permissions();
        $filmApplications = FilmApplication::latest()
            ->where('state', 'back')
            ->whereIn('desk', $my_all_permissions)
            ->where('desk', '!=', 'All Desks Completed')
            ->get();
        return view('film_applications.index')
            ->with('filmApplications', $filmApplications);
    }


     public function forward(FilmApplication $filmApplication, $desk)
    {
        if ($desk == 'assistant_production') {
            $filmApplication->update(['desk' => $desk, 'state' => 'back']);
        }else {
            $filmApplication->update(['desk' => $desk]);
        }
        return redirect()->route('filmApplications.index')->with('success', 'Film application forwarded successfully!');
    }

    public function back(FilmApplication $filmApplication, $desk)
    {
        // Ensure the current desk and state match before backing
        $filmApplication->update(['desk' => $desk]);
        return redirect()->route('filmApplications.index')->with('success', 'Film application forwarded successfully!');
    }

    public function finalForwardToMD(FilmApplication $filmApplication, $desk)
    {
        $filmApplication->update(['desk' => 'All Desks Completed Waiting for MD Approval']); // Final desk, MD
        return redirect()->route('filmApplications.index')->with('success', 'Film application forwarded to MD!');
    }
    public function approve_md(FilmApplication $filmApplication, $desk)
    {
        $filmApplication->update(['desk' => 'MD Approved']); // Final desk, MD
        return redirect()->route('filmApplications.index')->with('success', 'Film application forwarded to MD!');
    }






    /**
     * Show the form for creating a new FilmApplication.
     *
     * @return Response
     */
    public function create()
    {
        return view('film_applications.create');
    }

    /**
     * Store a newly created FilmApplication in storage.
     *
     * @param CreateFilmApplicationRequest $request
     *
     * @return Response
     */
    public function store(CreateFilmApplicationRequest $request)
    {
        $input = $request->all();
        $input['producer_id'] = Auth::guard('producer')->user()->id;

        /** @var FilmApplication $filmApplication */
        $filmApplication = FilmApplication::create($input);

        Flash::success('Film Application saved successfully.');

        return redirect(route('filmApplications.index'));
    }

    /**
     * Display the specified FilmApplication.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var FilmApplication $filmApplication */
        $filmApplication = FilmApplication::find($id);

        if (empty($filmApplication)) {
            Flash::error('Film Application not found');

            return redirect(route('filmApplications.index'));
        }

        return view('film_applications.show')->with('filmApplication', $filmApplication);
    }

    /**
     * Show the form for editing the specified FilmApplication.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        /** @var FilmApplication $filmApplication */
        $filmApplication = FilmApplication::find($id);

        if (empty($filmApplication)) {
            Flash::error('Film Application not found');

            return redirect(route('filmApplications.index'));
        }

        return view('film_applications.edit')->with('filmApplication', $filmApplication);
    }

    /**
     * Update the specified FilmApplication in storage.
     *
     * @param int $id
     * @param UpdateFilmApplicationRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateFilmApplicationRequest $request)
    {
        /** @var FilmApplication $filmApplication */
        $filmApplication = FilmApplication::find($id);

        if (empty($filmApplication)) {
            Flash::error('Film Application not found');

            return redirect(route('filmApplications.index'));
        }

        $filmApplication->fill($request->all());
        $filmApplication->save();

        Flash::success('Film Application updated successfully.');

        return redirect(route('filmApplications.index'));
    }

    /**
     * Remove the specified FilmApplication from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var FilmApplication $filmApplication */
        $filmApplication = FilmApplication::find($id);

        if (empty($filmApplication)) {
            Flash::error('Film Application not found');

            return redirect(route('filmApplications.index'));
        }

        $filmApplication->delete();

        Flash::success('Film Application deleted successfully.');

        return redirect(route('filmApplications.index'));
    }

    public function make_payment(FilmApplication $filmApplication, $package_id) {

        $transaction_id = 'TRN-' . time().rand(1000,9999);
        $package = Package::find($package_id);
        if (!$package) {
            Flash::error('Payment Failed');
            return redirect()->route('filmApplications.index');
        }

        $film_package = new FilmPackage;
        $film_package->film_id = $filmApplication->id;
        $film_package->package_id = $package_id;
        $film_package->amount = $package->amount;
        $film_package->trn_id = $transaction_id;
        $film_package->status = 'pending';
        $film_package->save();
        return redirect()->route('innitiate_payment', ['transaction_id' => $transaction_id]);

    }

    public function payment_data(FilmApplication $filmApplication)
    {

        $filmPackage = FilmPackage::where('film_id', $filmApplication->id)
            ->join('packages', 'film_packages.package_id', '=', 'packages.id')
            ->select('film_packages.*', 'packages.name as package_name')
            ->get();




        return view('film_applications.payment_data', compact('filmPackage', 'filmApplication'));
    }
}
