<?php

namespace App\Http\Controllers\Api\Dashboard\Admin;

use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\Service; // Assuming you have a Service model

class ServiceController extends Controller
{
    // List all services
    public function index()
    {
        $services = Service::all();
        return response()->json($services);
    }

    // Show a specific service
    public function show($id)
    {
        $service = Service::findOrFail($id);
        return response()->json($service);
    }

    // Create a new service
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $service = Service::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return response()->json($service, 201);
    }

    // Update a service
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $service = Service::findOrFail($id);
        $service->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return response()->json($service);
    }

    // Delete a service
    public function destroy($id)
    {
        $service = Service::findOrFail($id);
        $service->delete();

        return response()->json(['message' => 'Service deleted successfully']);
    }

    public function publicIndex()
{
    return response()->json(Service::all()); // Return all services
}

    public function uploadDocx(Request $request, $id)
    {
        Log::info('Received file upload request:', $request->all());

        $service = Service::find($id);
        if (!$service) {
            Log::error("Service with ID $id not found.");
            return response()->json(['error' => 'Service not found'], 404);
        }

        if ($request->hasFile('docx')) {
            $file = $request->file('docx');
            Log::info('File detected:', ['name' => $file->getClientOriginalName()]);

            // Store in storage/app/public/docx
            $path = $file->store('docx', 'public');

            // Save only relative path in DB
            $service->docx = $path;
            $service->save();

            Log::info('File saved successfully:', ['docx' => $service->docx]);

            return response()->json([
                'message' => 'File uploaded successfully!',
                'docx' => asset("storage/" . $service->docx) // Return URL for frontend
            ]);
        }

        Log::error('No file uploaded.');
        return response()->json(['error' => 'No file uploaded'], 400);
    }

    public function viewDocx($id)
    {
        $service = Service::findOrFail($id);
    
        if (!$service->docx) {
            return response()->json(['message' => 'No DOCX file found'], 404);
        }
    
        // Get full storage path
        $path = storage_path("app/public/{$service->docx}");
    
        if (!file_exists($path)) {
            return response()->json(['message' => 'File not found'], 404);
        }
    
        // Load DOCX file and convert to HTML
        $phpWord = IOFactory::load($path);
        $htmlWriter = IOFactory::createWriter($phpWord, 'HTML');
    
        ob_start();
        $htmlWriter->save('php://output');
        $htmlContent = ob_get_clean();
    
        return response()->json(['html' => $htmlContent]);
    }
    

    public function saveDocx(Request $request, $id)
    {
        $service = Service::findOrFail($id);
        $htmlContent = $request->input('html');

        $phpWord = new PhpWord();
        $section = $phpWord->addSection();
        \PhpOffice\PhpWord\Shared\Html::addHtml($section, $htmlContent);

        // Ensure directory exists
        Storage::makeDirectory('public/docx');

        $path = "docx/service_{$id}.docx";
        $fullPath = storage_path("app/public/$path");

        $writer = IOFactory::createWriter($phpWord, 'Word2007');
        $writer->save($fullPath);

        // Save the relative path in DB
        $service->docx = $path;
        $service->save();

        return response()->json([
            'message' => 'Document updated successfully',
            'docx' => asset("storage/" . $path) // Return public URL
        ]);
    }

}
