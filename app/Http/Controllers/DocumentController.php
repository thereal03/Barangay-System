<?php
namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Service;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function store(Request $request, $serviceId)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $service = Service::findOrFail($serviceId);
        $document = $service->documents()->create([
            'name' => $request->name,
        ]);

        return response()->json($document, 201);
    }

    public function update(Request $request, $serviceId, $documentId)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $document = Document::where('service_id', $serviceId)->findOrFail($documentId);
        $document->update($request->all());

        return response()->json($document);
    }

    public function destroy($serviceId, $documentId)
    {
        $document = Document::where('service_id', $serviceId)->findOrFail($documentId);
        $document->delete();

        return response()->json(null, 204);
    }
}