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
            'title'        => 'required|string',
            'date'         => 'required|date',
            'images'       => 'required|array',
            'images.*'     => 'image|max:2048',
            'descriptions' => 'nullable|array',
            'descriptions.*' => 'nullable|string',
        ]);

        $gallery = Gallery::create($request->only(['title', 'date']));

        $files = $request->file('images');
        $descs = $request->input('descriptions', []);

        foreach ($files as $i => $file) {
            $path = $file->store('gallery', 'public');
            $gallery->images()->create([
                'image'       => $path,
                'description' => $descs[$i] ?? null,
            ]);
        }

        $gallery->load('images');
        return response()->json($gallery, 201);
    }

    public function update(Request $request, $id)
    {
        $gallery = Gallery::findOrFail($id);

        $request->validate([
            'title'         => 'sometimes|required|string',
            'date'          => 'sometimes|required|date',
            'images'        => 'nullable|array',
            'images.*'      => 'image|max:2048',
            'descriptions'  => 'nullable|array',
            'descriptions.*'=> 'nullable|string',
        ]);

        $gallery->update($request->only(['title', 'date']));

        if ($request->hasFile('images')) {
            $gallery->images->each(function($img){
                Storage::disk('public')->delete($img->image);
                $img->delete();
            });

            $files = $request->file('images');
            $descs = $request->input('descriptions', []);

            foreach ($files as $i => $file) {
                $path = $file->store('gallery', 'public');
                $gallery->images()->create([
                    'image'       => $path,
                    'description' => $descs[$i] ?? null,
                ]);
            }
        }

        $gallery->load('images');
        return response()->json($gallery);
    }

    public function destroy($id)
    {
        $gallery = Gallery::with('images')->findOrFail($id);

        $gallery->images->each(function($img){
            Storage::disk('public')->delete($img->image);
        });

        $gallery->delete();

        return response()->json(['message' => 'Gallery deleted']);
    }
}
