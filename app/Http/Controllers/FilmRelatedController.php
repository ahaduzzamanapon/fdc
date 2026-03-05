<?php

namespace App\Http\Controllers;

use App\Models\FilmRelated;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;

class FilmRelatedController extends Controller
{
    public function index()
    {
        $film_related = FilmRelated::all();
        return view('film_related.index', compact('film_related'));
    }

    public function create()
    {
        return view('film_related.create');
    }

    public function store(Request $request)
    {
        $input = $request->all();
        FilmRelated::create($input);
        Flash::success('চলচ্চিত্র সম্পর্কিত saved successfully.');
        return redirect(route('film_related.index'));
    }

    public function edit($id)
    {
        $filmRelated = FilmRelated::find($id);
        if (empty($filmRelated)) {
            Flash::error('চলচ্চিত্র সম্পর্কিত not found');
            return redirect(route('film_related.index'));
        }
        return view('film_related.edit', compact('filmRelated'));
    }

    public function update(Request $request, $id)
    {
        $filmRelated = FilmRelated::find($id);
        if (empty($filmRelated)) {
            Flash::error('চলচ্চিত্র সম্পর্কিত not found');
            return redirect(route('film_related.index'));
        }
        $filmRelated->fill($request->all());
        $filmRelated->save();
        Flash::success('চলচ্চিত্র সম্পর্কিত updated successfully.');
        return redirect(route('film_related.index'));
    }

    public function destroy($id)
    {
        $filmRelated = FilmRelated::find($id);
        if (empty($filmRelated)) {
            Flash::error('চলচ্চিত্র সম্পর্কিত not found');
            return redirect(route('film_related.index'));
        }
        $filmRelated->delete();
        Flash::success('চলচ্চিত্র সম্পর্কিত deleted successfully.');
        return redirect(route('film_related.index'));
    }
}
