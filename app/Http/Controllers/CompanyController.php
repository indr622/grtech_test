<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): \Inertia\Response
    {
        $companies = Company::paginate($request->per_page ?? 10)
            ->withQueryString();
        return Inertia::render('Company/Index', [
            'companies' => $companies,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): \Inertia\Response
    {
        return Inertia::render('Company/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCompanyRequest $request)
    {
        try {
            if ($request->hasFile('logo')) {
                $logo = $request->file('logo');
                $logoPath = $logo->store('logos', 'public');
                $requestData = $request->validated();
                $requestData['logo'] = $logoPath;
                Company::create($requestData);
            } else {
                Company::create($request->validated());
            }
            return Redirect::route('companies.index')->with('success', 'Company created successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Company cannot be created');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company) {}

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCompanyRequest $request, Company $company)
    {
        try {

            $company->update($request->validated());

            return Redirect::route('companies.index');
        } catch (\Exception $e) {
            return back()->with('error', 'Company cannot be updated');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        $company->delete();
        return  Redirect::route('companies.index')->with('message', 'Company deleted successfully');
    }
}
