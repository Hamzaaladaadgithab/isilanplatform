<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyUpdateRequest;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\CompanyCreateRequest;



class CompanyController extends Controller
{





public $industries =['Technology', 'Finance','Healthcare','Education','Manufacturing','Ratail','other'];





    /**
     * Display a listing of the resource.
     */


    public function index(Request $request)
    {  //active
        $query = Company::latest();

        //archived

        if($request->input('archived')==true) {
            $query->onlyTrashed();
        }

        $companies = $query->paginate(10)->onEachSide(1);

        return view('company.index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $industries =$this->industries;

        return view('company.create',compact('industries'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CompanyCreateRequest $request)
    {
        $validated = $request->validated();

        //create owner
        $owner = User::create([
            'name' => $validated['owner_name'],
            'email' => $validated['owner_email'],
            'password' => Hash::make($validated['owner_password']),
            'role' => 'company-owner',
        ]);


        //return error if owner creation fails
        if(!$owner){
            return redirect()->route('company.create')->with('error', 'Failed to create owner.');
        }


        //create company
        Company::create([
            'name' => $validated['name'],
            'address' => $validated['address'],
            'industry' => $validated['industry'],
            'website' => $validated['website'],
            'ownerid' => $owner->id,
        ]);

        return redirect()->route('company.index')->with('success', 'Company created successfully.');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $company = Company::findOrFail($id);
        return view('company.show', compact('company'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $company = Company::findOrFail($id);
        $industries =$this->industries;
        return view('company.edit', compact('company','industries'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CompanyUpdateRequest $request, string $id)
    {
        $validated = $request->validated();

        $company = Company::findOrFail($id);

        $company->update([
            'name'=>$validated['name'],
            'address'=>$validated['address'],
            'industry'=>$validated['industry'],
            'website'=>$validated['website'],

        ]);

        //update woner

        $ownerData=[];
        $ownerData['name']=$validated['owner_name'];

        if($validated['owner_password']){
            $ownerData['password']=Hash::make($validated['owner_password']);
        }

        $company->owner->update($ownerData);

        if($request->query('redirectToList')=='false'){

            return redirect()->route('company.show',$id)->with('success', 'Company updated successfully.');

        }

                return redirect()->route('company.index')->with('success', 'Company updated successfully.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $company = Company::findOrFail($id);
        $company->delete();

        return redirect()->route('company.index')->with('success', 'Company archived successfully.');

    }

    public function restore($id)
    {
        $company = Company::withTrashed()->findOrFail($id);
        if ($company->trashed()) {
            $company->restore();
            return redirect()->route('company.index')->with('success', 'Company restored successfully.');
        }
        return redirect()->route('company.index',['archived' =>'true'])->with('info', 'Company is not archived.');
    }


}
