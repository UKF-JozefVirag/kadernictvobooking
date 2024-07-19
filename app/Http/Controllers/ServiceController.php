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
            'price' => 'required|numeric|between:0,200',
            'duration' => 'required|numeric|between:0,200',
        ]);

        if ($request->has('image') && preg_match('/^data:image\/(\w+);base64,/', $request->image, $type)) {
            $imageData = substr($request->image, strpos($request->image, ',') + 1);
            $imageData = base64_decode($imageData);

            $fileName = uniqid('service_', true) . '.' . $type[1];
            $path = 'services/' . $fileName;

            Storage::disk('public')->put($path, $imageData);

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

    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'desc' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048',
            'price' => 'required|numeric|between:0,500',
            'duration' => 'required|numeric|between:0,500',
        ]);

        $service = Service::find($request->id);
        if (!$service) {
            return response()->json(['error' => 'Service not found'], 404);
        }

        $service->name = $validatedData['name'];
        $service->desc = $validatedData['desc'];
        $service->price = $validatedData['price'];
        $service->duration = $validatedData['duration'];

        if ($request->hasFile('image')) {
            $imageFile = $request->file('image');
            $extension = $imageFile->getClientOriginalExtension();
            $fileName = uniqid('service_', true) . '_' . time() . '.' . $extension;
            $path = $imageFile->storeAs('services', $fileName, 'public');

            if ($service->image && Storage::disk('public')->exists($service->image)) {
                Storage::disk('public')->delete($service->image);
            }

            $service->image = $path;
        }

        $service->save();

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
