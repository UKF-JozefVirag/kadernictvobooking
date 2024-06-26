<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Service;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::all();
        return response()->json($orders);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validácia vstupných údajov
        $validatedData = $request->validate([
            'datetime_from' => 'required|date',
            'datetime_to' => 'required|date',
            'employee_id' => 'nullable|exists:employees,id',
            'services' => 'required|array',
            'services.*' => 'exists:services,id',
        ]);

        // Získanie služieb a výpočet celkovej ceny
        $services = Service::whereIn('id', $validatedData['services'])->get();
        $totalPrice = $services->sum('price');

        // Vytvorenie objednávky
        $order = Order::create([
            'datetime_from' => $validatedData['datetime_from'],
            'datetime_to' => $validatedData['datetime_to'],
            'total_price' => $totalPrice,
            'employee_id' => $validatedData['employee_id'] // Uistite sa, že hodnota je tu správne priradená
        ]);

        // Priradenie služieb k objednávke
        if ($request->has('services')) {
            $order->services()->attach($validatedData['services']);
        }

        // Vrátenie odpovede s objednávkou a službami
        return response()->json($order->load('services'), 201);
    }


    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        return response()->json($order);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        $order->update($request->all());
        return response()->json($order);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        $order->delete();
        return response()->json(null, 204);
    }
}
