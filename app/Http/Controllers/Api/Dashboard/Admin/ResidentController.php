<?php

namespace App\Http\Controllers\Api\Dashboard\Admin;

use App\Http\Controllers\Controller;
use App\Models\Resident;
use Illuminate\Http\Request;

class ResidentController extends Controller
{
    // Get all resident
    public function index()
    {
        $resident = Resident::all();  // Fetch all resident
        return response()->json($resident);
    }

    // Get a specific resident by ID
    public function show($id)
    {
        $resident = Resident::findOrFail($id);  // Find resident by ID
        return response()->json($resident);
    }

    // Create a new resident
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'dob' => 'required|date',
            'gender' => 'required|string|max:50',
            'address' => 'nullable|string|max:255',
            'contact_number' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
        ]);

        $resident = Resident::create($request->all());  // Create new resident
        return response()->json($resident, 201);
    }

    // Update an existing resident
    public function update(Request $request, $id)
    {
        $resident = Resident::findOrFail($id);  // Find resident by ID

        // Validate input
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'dob' => 'required|date',
            'gender' => 'required|string|max:50',
            'address' => 'nullable|string|max:255',
            'contact_number' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
        ]);

        $resident->update($request->all());  // Update resident data
        return response()->json($resident);
    }

    // Delete a resident
    public function destroy($id)
    {
        $resident = Resident::findOrFail($id);  // Find resident by ID
        $resident->delete();  // Delete the resident
        return response()->json(null, 204);  // Return a successful response
    }
}
