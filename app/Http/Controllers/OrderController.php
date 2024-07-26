<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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

    public function getEmployeeOrders(Request $request)
    {
        $validatedData = $request->validate([
            'date' => 'required|date',
            'employee_id' => 'required|exists:employees,id',
        ]);

        $orders = Order::whereDate('datetime_from', $validatedData['date'])
            ->where('employee_id', $validatedData['employee_id'])
            ->with('services', 'employee', 'customer')
            ->get();

        return response()->json($orders, 200);
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

        if ($validatedData['employee_id']) {
            $conflictingOrders = Order::where('employee_id', $validatedData['employee_id'])
                ->where(function ($query) use ($validatedData) {
                    $query->whereBetween('datetime_from', [$validatedData['datetime_from'], $validatedData['datetime_to']])
                        ->orWhereBetween('datetime_to', [$validatedData['datetime_from'], $validatedData['datetime_to']])
                        ->orWhere(function ($query) use ($validatedData) {
                            $query->where('datetime_from', '<', $validatedData['datetime_from'])
                                ->where('datetime_to', '>', $validatedData['datetime_to']);
                        });
                })
                ->exists();

            if ($conflictingOrders) {
                return response()->json(['message' => 'The employee is not available at the selected time.'], 409);
            }
        }

        $customer = Customer::firstOrCreate(
            ['email' => $validatedData['email']],
            [
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'phone_number' => $validatedData['phone_number'],
            ]
        );

        $services = Service::whereIn('id', $validatedData['services'])->get();
        $totalPrice = $services->sum('price');

        $order = Order::create([
            'datetime_from' => $validatedData['datetime_from'],
            'datetime_to' => $validatedData['datetime_to'],
            'total_price' => $totalPrice,
            'employee_id' => $validatedData['employee_id'],
        ]);

        $order->customer()->associate($customer);
        $order->save();

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
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        $validatedData = $request->validate([
            'datetime_from' => 'required|date|after_or_equal:now',
            'datetime_to' => 'required|date|after:datetime_from',
            'employee_id' => 'nullable|exists:employee,id',
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
        try {
            // If your Order model has related services in a pivot table
            $order->services()->detach();

            $order->delete();
            return response()->json(null, 204);
        } catch (\Exception $e) {
            Log::error('Error deleting order: '.$e->getMessage());
            return response()->json(['message' => 'Error deleting order'], 500);
        }
    }

    public function getOrdersByDate(Request $request)
    {
        $validatedData = $request->validate([
            'date' => 'required|date',
        ]);

        $date = $validatedData['date'];
        $orders = Order::with('employees', 'services')
            ->whereDate('datetime_from', $date)
            ->get();

        return response()->json($orders);
    }
}

