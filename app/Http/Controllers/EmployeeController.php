<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Company;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Mail\EmployeeCreated;
use Illuminate\Support\Facades\Mail;
use App\Jobs\SendEmployeeCreatedEmail;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): \Inertia\Response
    {
        $companies = Company::all();
        $employee = Employee::with('company')->paginate($request->per_page ?? 10);
        return Inertia::render('Employee/Index', [
            'employee' => $employee,
            'companies' => $companies,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $companies = Company::all();
        return Inertia::render('Employee/Create', [
            'companies' => $companies,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEmployeeRequest $request)
    {
        try {
            $employee = Employee::create($request->validated());

            //Job Send Email
            SendEmployeeCreatedEmail::dispatch($employee);

            return Redirect::route('employees.index')->with('success', 'Employee created successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Employee cannot be created');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEmployeeRequest $request, Employee $employee)
    {
        try {
            $employee->update($request->validated());
            return Redirect::route('employees.index')->with('success', 'Employee updated successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Employee cannot be updated');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();
        return  Redirect::route('employees.index')->with('message', 'Employee deleted successfully');
    }
}
