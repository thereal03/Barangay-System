<?php

namespace App\Http\Controllers\Api\Dashboard\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blotter;

class BlotterController extends Controller
{
    public function index()
    {
        return response()->json(Blotter::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'complainant' => 'required|string',
            'respondent' => 'required|string',
            'incident_type' => 'required|string',
            'incident_location' => 'required|string',
            'incident_date' => 'required|date',
            'status' => 'required|in:Pending,Resolved,Dismissed'
        ]);

        $blotter = Blotter::create($request->all());
        return response()->json($blotter, 201);
    }

    public function show($id)
    {
        return response()->json(Blotter::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $blotter = Blotter::findOrFail($id);
        $blotter->update($request->all());
        return response()->json($blotter);
    }

    public function destroy($id)
    {
        Blotter::findOrFail($id)->delete();
        return response()->json(['message' => 'Blotter record deleted']);
    }
}