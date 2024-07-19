<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::all();
        return response()->json($services);
    }

    public function create()
    {

    }

    public function store(Request $request)
{
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'desc' => 'nullable|string|max:255',
        // Adjust validation if necessary. For example, you might remove 'image' validation if you're handling base64 strings
        'price' => 'required|numeric|between:0,200',
        'duration' => 'required|numeric|between:0,200',
    ]);

    // Check if image data is provided and is a base64 string
    if ($request->has('image') && preg_match('/^data:image\/(\w+);base64,/', $request->image, $type)) {
        // Decode the base64 string
        $imageData = substr($request->image, strpos($request->image, ',') + 1);
        $imageData = base64_decode($imageData);

        // Determine file name and path
        $fileName = uniqid('service_', true) . '.' . $type[1]; // Generate unique file name
        $path = 'services/' . $fileName;

        // Save the image to storage
        Storage::disk('public')->put($path, $imageData);

        // Update the validated data array
        $validatedData['image'] = $path;
    }

    $service = Service::create($validatedData);
    return response()->json($service, 201);
}

    public function show(Service $service)
    {
        return response()->json($service);
    }

    public function edit(Service $service)
    {

    }

    public function update(Request $request, Service $service)
    {
        $validatedData = $request->validate([
            'name' => 'nullable|string|max:255',
            'desc' => 'nullable|string|max:255',
            // Remove 'image' validation rule if handling base64 strings
            'price' => 'nullable|numeric|between:0,200',
            'duration' => 'nullable|numeric|between:0,200',
        ]);

        // Check if image data is provided and is a base64 string
        if ($request->has('image') && preg_match('/^data:image\/(\w+);base64,/', $request->image, $type)) {
            // Decode the base64 string
            $imageData = substr($request->image, strpos($request->image, ',') + 1);
            $imageData = base64_decode($imageData);

            // Determine file name and path
            $fileName = uniqid('service_', true) . '.' . $type[1]; // Generate unique file name
            $path = 'services/' . $fileName;

            // Delete the old image if it exists
            if ($service->image && Storage::disk('public')->exists($service->image)) {
                Storage::disk('public')->delete($service->image);
            }

            // Save the new image to storage
            Storage::disk('public')->put($path, $imageData);

            // Update the validated data array
            $validatedData['image'] = $path;
        }

        // Update the service with new data
        $service->update($validatedData);

        return response()->json($service);
    }

    public function destroy(Service $service)
    {
        if ($service->image && Storage::disk('public')->exists($service->image)) {
            Storage::disk('public')->delete($service->image);
        }

        $service->delete();
        return response()->json(null, 204);
    }
}

