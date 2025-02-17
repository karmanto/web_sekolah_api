<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Announcement;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::all();
        return response()->json($announcements);
    }

    public function show($id)
    {
        $announcement = Announcement::findOrFail($id);
        return response()->json($announcement);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'    => 'required|string',
            'content'  => 'required',
            'date'     => 'required|date',
            'important'=> 'required|boolean'
        ]);

        $announcement = Announcement::create($request->all());
        return response()->json($announcement, 201);
    }

    public function update(Request $request, $id)
    {
        $announcement = Announcement::findOrFail($id);

        $request->validate([
            'title'    => 'sometimes|required|string',
            'content'  => 'sometimes|required',
            'date'     => 'sometimes|required|date',
            'important'=> 'sometimes|required|boolean'
        ]);

        $announcement->update($request->all());
        return response()->json($announcement);
    }

    public function destroy($id)
    {
        $announcement = Announcement::findOrFail($id);
        $announcement->delete();
        return response()->json(['message' => 'Announcement deleted']);
    }
}
