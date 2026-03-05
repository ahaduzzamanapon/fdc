<?php

namespace App\Http\Controllers;

use App\Models\PhotoGallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PhotoGalleryController extends Controller
{
    public function index(Request $request)
    {
        $year   = $request->input('year');
        $search = $request->input('search');

        $startYear   = 1960;
        $currentYear = (int) now()->format('Y');
        $years       = range($startYear, $currentYear);
        rsort($years);

        $query = PhotoGallery::query();

        if ($year) {
            $query->whereYear('release_date', $year);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('film_name', 'like', "%{$search}%")
                ->orWhere('type', 'like', "%{$search}%");
            });
        }

        $galleries = $query->orderBy('release_date', 'desc')
            ->paginate(10)
            ->appends($request->all());

        return view('decade_films_photos.index', compact('galleries', 'years', 'year', 'search'));
    }

    public function create()
    {
        return view('decade_films_photos.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'film_name'    => 'required|string|max:255',
            'type'         => 'nullable|string|max:255',
            'release_date' => 'nullable|date',
            'image'        => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data['image'] = $request->file('image')->store('photo_galleries', 'public');

        PhotoGallery::create($data);

        return redirect()->route('decadeFilmsPhotos.index')
            ->with('success', 'Photo saved successfully.');
    }

    public function show(PhotoGallery $decadeFilmsPhoto)
    {
        return view('decade_films_photos.show', ['photo' => $decadeFilmsPhoto]);
    }

    public function edit(PhotoGallery $decadeFilmsPhoto)
    {
        return view('decade_films_photos.edit', ['photo' => $decadeFilmsPhoto]);
    }

    public function update(Request $request, PhotoGallery $decadeFilmsPhoto)
    {
        $data = $request->validate([
            'film_name'    => 'required|string|max:255',
            'type'         => 'nullable|string|max:255',
            'release_date' => 'nullable|date',
            'image'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($decadeFilmsPhoto->image && Storage::disk('public')->exists($decadeFilmsPhoto->image)) {
                Storage::disk('public')->delete($decadeFilmsPhoto->image);
            }
            $data['image'] = $request->file('image')->store('photo_galleries', 'public');
        }

        $decadeFilmsPhoto->update($data);

        return redirect()->route('decadeFilmsPhotos.index')
            ->with('success', 'Photo updated successfully.');
    }

    public function destroy(PhotoGallery $decadeFilmsPhoto)
    {
        if ($decadeFilmsPhoto->image && Storage::disk('public')->exists($decadeFilmsPhoto->image)) {
            Storage::disk('public')->delete($decadeFilmsPhoto->image);
        }

        $decadeFilmsPhoto->delete();

        return redirect()->route('decadeFilmsPhotos.index')
            ->with('success', 'Photo deleted successfully.');
    }
}
