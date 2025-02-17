<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gallery;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::all();
        return response()->json($galleries);
    }

    public function show($id)
    {
        $gallery = Gallery::findOrFail($id);
        return response()->json($gallery);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'date'  => 'required|date',
            'image' => 'required|image|max:2048'
        ]);

        $data = $request->only(['title', 'date']);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('gallery', 'public');
            $data['image'] = $path;
        }

        $gallery = Gallery::create($data);
        return response()->json($gallery, 201);
    }

    public function update(Request $request, $id)
    {
        $gallery = Gallery::findOrFail($id);

        $request->validate([
            'title' => 'sometimes|required|string',
            'date'  => 'sometimes|required|date',
            'image' => 'nullable|image|max:2048'
        ]);

        $data = $request->only(['title', 'date']);

        if ($request->hasFile('image')) {
            if ($gallery->image) {
                Storage::disk('public')->delete($gallery->image);
            }
            $path = $request->file('image')->store('gallery', 'public');
            $data['image'] = $path;
        }

        $gallery->update($data);
        return response()->json($gallery);
    }

    public function destroy($id)
    {
        $gallery = Gallery::findOrFail($id);
        if ($gallery->image) {
            Storage::disk('public')->delete($gallery->image);
        }
        $gallery->delete();
        return response()->json(['message' => 'Gallery deleted']);
    }
}
