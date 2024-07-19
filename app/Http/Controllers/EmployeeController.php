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


        if ($request->hasFile('image')) {
            $imageFile = $request->file('image');
            $extension = $imageFile->getClientOriginalExtension();
            $fileName = uniqid('employee_', true) . '_' . time() . '.' . $extension;
            $path = $imageFile->storeAs('employees', $fileName, 'public');

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

    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'email'=>'required|string|email|max:255|unique:users,email,'.$request->id,
            'phone_number' => 'required|string|max:10',
        ]);

        $employee = Employee::find($request->id);
        if (!$employee) {
            return response()->json(['error' => 'Employee not found'], 404);
        }

        $employee->first_name = $validatedData['first_name'];
        $employee->last_name = $validatedData['last_name'];
        $employee->email = $validatedData['email'];
        $employee->phone_number = $validatedData['phone_number'];

        if ($request->hasFile('image')) {
            $imageFile = $request->file('image');
            $extension = $imageFile->getClientOriginalExtension();
            $fileName = uniqid('employee_', true) . '_' . time() . '.' . $extension;
            $path = $imageFile->storeAs('employees', $fileName, 'public');

            if ($employee->image && Storage::disk('public')->exists($employee->image)) {
                Storage::disk('public')->delete($employee->image);
            }

            $employee->image = $path;
        }

        $employee->save();

        return response()->json($employee);
    }




    public function destroy(Employee $employee)
    {
        $employee->delete();
        return response()->json("User successfully deleted", 204);
    }

}
