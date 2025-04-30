<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::with('images')->get();
        return response()->json($galleries);
    }

    public function show($id)
    {
        $gallery = Gallery::with('images')->findOrFail($id);
        return response()->json($gallery);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'      => 'required|string',
            'date'       => 'required|date',
            'images'     => 'required|array',
            'images.*'   => 'image|max:2048',
        ]);

        $gallery = Gallery::create($request->only(['title', 'date']));

        foreach ($request->file('images') as $file) {
            $path = $file->store('gallery', 'public');
            $gallery->images()->create([
                'image' => $path,
            ]);
        }
        
        $gallery->load('images');
        return response()->json($gallery, 201);
    }

    public function update(Request $request, $id)
    {
        $gallery = Gallery::findOrFail($id);

        $request->validate([
            'title'      => 'sometimes|required|string',
            'date'       => 'sometimes|required|date',
            'images'     => 'nullable|array',
            'images.*'   => 'image|max:2048',
        ]);

        $gallery->update($request->only(['title', 'date']));

        if ($request->hasFile('images')) {
            foreach ($gallery->images as $img) {
                Storage::disk('public')->delete($img->image);
                $img->delete();
            }
            foreach ($request->file('images') as $file) {
                $path = $file->store('gallery', 'public');
                $gallery->images()->create([
                    'image' => $path,
                ]);
            }
        }

        $gallery->load('images');
        return response()->json($gallery);
    }

    public function destroy($id)
    {
        $gallery = Gallery::with('images')->findOrFail($id);

        foreach ($gallery->images as $img) {
            Storage::disk('public')->delete($img->image);
        }

        $gallery->delete();

        return response()->json(['message' => 'Gallery deleted']);
    }
}
