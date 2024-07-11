<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Service;
use App\Models\Employee;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::with('employee', 'services')->get();
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
        $validatedData = $request->validate([
            'datetime_from' => 'required|date|after_or_equal:now',
            'datetime_to' => 'required|date|after:datetime_from',
            'employee_id' => 'nullable|exists:employees,id',
            'services' => 'required|array',
            'services.*' => 'exists:services,id',
            'email' => 'required|email',
            'phone_number' => [
                'required',
                'regex:/^09\d{2} \d{3} \d{3}$|^09\d{8}$/'
            ],
        ]);

        $services = Service::whereIn('id', $validatedData['services'])->get();
        $totalPrice = $services->sum('price');

        $order = Order::create([
            'datetime_from' => $validatedData['datetime_from'],
            'datetime_to' => $validatedData['datetime_to'],
            'total_price' => $totalPrice,
            'employee_id' => $validatedData['employee_id']
        ]);

        if ($request->has('services')) {
            $order->services()->attach($validatedData['services']);
        }

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
        $validatedData = $request->validate([
            'datetime_from' => 'required|date|after_or_equal:now',
            'datetime_to' => 'required|date|after:datetime_from',
            'employee_id' => 'nullable|exists:employees,id',
            'services' => 'required|array',
            'services.*' => 'exists:services,id',
        ]);

        $services = Service::whereIn('id', $validatedData['services'])->get();
        $totalPrice = $services->sum('price');

        $order->update([
            'datetime_from' => $validatedData['datetime_from'],
            'datetime_to' => $validatedData['datetime_to'],
            'total_price' => $totalPrice,
            'employee_id' => $validatedData['employee_id']
        ]);

        if ($request->has('services')) {
            $order->services()->sync($validatedData['services']);
        }

        return response()->json($order->load('services'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        $order->delete();
        return response()->json(null, 204);
    }

    public function getOrdersByDate(Request $request)
    {
        $validatedData = $request->validate([
            'date' => 'required|date',
        ]);

        $date = $validatedData['date'];
        $orders = Order::with('employee', 'services')
            ->whereDate('datetime_from', $date)
            ->get();

        return response()->json($orders);
    }
}
