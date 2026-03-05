<?php

namespace App\Http\Controllers;

use App\Models\DecadeFilmList;
use Illuminate\Http\Request;

class DecadeFilmListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // method agnostic access to the inputs
        $year   = $request->input('year');
        $search = $request->input('search');

        // Available years: fixed range from 1960 up to the current calendar year
        // Earlier we pulled distinct years from the database, but now we always want the
        // full span 1960..now regardless of stored records.
        $startYear = 1960;
        $currentYear = (int) now()->format('Y');
        $years = range($startYear, $currentYear);
        rsort($years);

        $query = DecadeFilmList::query();

        // Year filter
        if ($year) {
            $query->whereYear('release_date', $year);
        }

        // Search filter
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('film_name', 'like', "%{$search}%")
                ->orWhere('director_name', 'like', "%{$search}%")
                ->orWhere('producer_name', 'like', "%{$search}%")
                ->orWhere('type', 'like', "%{$search}%");
            });
        }

        $decadeFilmLists = $query->orderBy('release_date', 'desc')
            ->paginate(10)
            ->appends($request->all());

        // If AJAX request
        if ($request->ajax()) {
            // if an ajax handler is still used elsewhere we could render the same list partial,
            // but there was no table_data view – for now return the list table directly.
            return view('decade_film.decade_film_list_table', compact('decadeFilmLists', 'years', 'year', 'search'))->render();
        }

        // include search term so the view can repopulate the input
        return view('decade_film.index', compact(
            'decadeFilmLists',
            'years',
            'year',
            'search'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('decade_film.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'film_name'      => 'required|string|max:255',
            'producer_name'  => 'nullable|string|max:255',
            'director_name'  => 'nullable|string|max:255',
            'acting'         => 'nullable|string|max:255',
            'type'           => 'nullable|string|max:255',
            'release_date'   => 'nullable|date',
            'achivements'    => 'nullable|string',
        ]);

        DecadeFilmList::create($request->only([
            'film_name',
            'producer_name',
            'director_name',
            'acting',
            'type',
            'release_date',
            'achivements',
        ]));

        return redirect()->route('decadeFilms.index')
            ->with('success', 'Decade film record saved successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DecadeFilmList  $decadeFilmList
     * @return \Illuminate\Http\Response
     */
    public function show(DecadeFilmList $decadeFilm)
    {
        return view('decade_film.show')->with('decadeFilmList', $decadeFilm);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DecadeFilmList  $decadeFilmList
     * @return \Illuminate\Http\Response
     */
    public function edit(DecadeFilmList $decadeFilm)
    {
        return view('decade_film.edit')->with('decadeFilmList', $decadeFilm);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DecadeFilmList  $decadeFilmList
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DecadeFilmList $decadeFilm)
    {
        $request->validate([
            'film_name'      => 'required|string|max:255',
            'producer_name'  => 'nullable|string|max:255',
            'director_name'  => 'nullable|string|max:255',
            'acting'         => 'nullable|string|max:255',
            'type'           => 'nullable|string|max:255',
            'release_date'   => 'nullable|date',
            'achivements'    => 'nullable|string',
        ]);

        $decadeFilm->update($request->only([
            'film_name',
            'producer_name',
            'director_name',
            'acting',
            'type',
            'release_date',
            'achivements',
        ]));

        return redirect()->route('decadeFilms.index')
            ->with('success', 'Decade film record updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DecadeFilmList  $decadeFilmList
     * @return \Illuminate\Http\Response
     */
    public function destroy(DecadeFilmList $decadeFilm)
    {
        $decadeFilm->delete();

        return redirect()->route('decadeFilms.index')
            ->with('success', 'Decade film record deleted successfully.');
    }
}
