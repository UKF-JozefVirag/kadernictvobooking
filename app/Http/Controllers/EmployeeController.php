<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::all();
        return response()->json($employees);
    }

    public function create()
    {

    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'email' => 'required|email|unique:employees,email',
            'phone_number' => 'required|string|max:10',
        ]);
        Log::info($request);
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('employees', 'public');
            $validatedData['image'] = $path;
        }

        $employee = Employee::create($validatedData);
        return response()->json($employee, 201);
    }

    public function show(Employee $employee)
    {
        return response()->json($employee);
    }

    public function edit(Employee $employee)
    {

    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'email' => 'unique:employees,email,' . $id,
            'phone_number' => 'required|string|max:10',
        ]);

        $employee = Employee::find($id);
        if (!$employee) {
            return response()->json(['error' => 'Employee not found'], 404);
        }

        if ($request->hasFile('image')) {
            if ($employee->image && Storage::disk('public')->exists($employee->image)) {
                Storage::disk('public')->delete($employee->image);
            }

            $path = $request->file('image')->store('employees', 'public');
            $employee->image = $path;
        }

        $employee->first_name = $validatedData['first_name'];
        $employee->last_name = $validatedData['last_name'];
        $employee->email = $validatedData['email'];
        $employee->phone_number = $validatedData['phone_number'];
        $employee->save();

        return response()->json($employee);
    }




    public function destroy(Employee $employee)
    {
        $employee->delete();
        return response()->json("User successfully deleted", 204);
    }

}
