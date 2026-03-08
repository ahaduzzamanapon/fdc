<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gallery;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $galleries = Gallery::latest()->get();
        return view('galleries.index', compact('galleries'));
    }

    public function create()
    {
        return view('galleries.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $input = $request->all();

        if ($image = $request->file('image')) {
            $destinationPath = 'images/galleries/';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $input['image'] = "$profileImage";
        }

        Gallery::create($input);

        return redirect()->route('galleries.index')
            ->with('success', 'Gallery item created successfully.');
    }

    public function show($id)
    {
        $gallery = Gallery::find($id);
        if (empty($gallery)) {
            return redirect(route('galleries.index'));
        }
        return view('galleries.show', compact('gallery'));
    }

    public function edit($id)
    {
        $gallery = Gallery::find($id);
        if (empty($gallery)) {
            return redirect(route('galleries.index'));
        }
        return view('galleries.edit', compact('gallery'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $gallery = Gallery::find($id);

        if (empty($gallery)) {
            return redirect(route('galleries.index'));
        }

        $input = $request->all();

        if ($image = $request->file('image')) {
            $destinationPath = 'images/galleries/';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $input['image'] = "$profileImage";
        } else {
            unset($input['image']);
        }

        $gallery->update($input);

        return redirect()->route('galleries.index')
            ->with('success', 'Gallery item updated successfully');
    }

    public function destroy($id)
    {
        $gallery = Gallery::find($id);

        if (empty($gallery)) {
            return redirect(route('galleries.index'));
        }

        $gallery->delete();

        return redirect()->route('galleries.index')
            ->with('success', 'Gallery item deleted successfully');
    }
}
