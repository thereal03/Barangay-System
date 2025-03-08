<?php

namespace App\Http\Controllers\Api\Dashboard\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Announcement;

class AnnouncementController extends Controller
{
    // List all announcements
    public function index()
    {
        $announcements = Announcement::all();
        return response()->json($announcements);
    }

    // Store a new announcement
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date',
            'link' => 'nullable|url'
        ]);

        $announcement = Announcement::create($request->all());
        return response()->json($announcement, 201);
    }

    // Show a specific announcement
    public function show($id)
    {
        $announcement = Announcement::findOrFail($id);
        return response()->json($announcement);
    }

    // Update a specific announcement
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date',
            'link' => 'nullable|url'
        ]);

        $announcement = Announcement::findOrFail($id);
        $announcement->update($request->all());
        return response()->json($announcement);
    }

    // Delete a specific announcement
    public function destroy($id)
    {
        $announcement = Announcement::findOrFail($id);
        $announcement->delete();
        return response()->json(null, 204);
    }
}