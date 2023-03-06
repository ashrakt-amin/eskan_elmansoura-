<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\UnitStatusDate;

class UnitStatusDateController extends Controller
{

///////////////////////////////////////////////
//* Display a listing of the resource.
///////////////////////////////////////////////    
    public function index()
    {
        $myTempletes = UnitStatusDate::all();
        return view('myTempletesIndex', compact('myTempletes'));
    }
///////////////////////////////////////////////
//* Show the form for creating a new resource.
////////////////////////////////////////////////
    public function create()
    {
        return view('addMyTempletesIndex');
    }
////////////////////////////////////////////////
//* Store a newly created resource in storage.
////////////////////////////////////////////////
    public function store(Request $request)
    {
        $unitStatus = new UnitStatusDate();

        $unitStatus->name = $request->input('name');
        $unitStatus->save();
        return redirect('/addMyTempletesIndex')->with('status', 'Unit Status added successfully');
    }
////////////////////////////////////////////////
//* Display the specified resource.
////////////////////////////////////////////////
    public function show($id)
    {
        //
    }
////////////////////////////////////////////////
//* Show the form for editing the specified resource.
////////////////////////////////////////////////
    public function edit($id)
    {
        $myTempletes = UnitStatusDate::find($id);
        return view('editMyTempletesIndex', compact('myTempletes'));   
    }
////////////////////////////////////////////////

//* Update the specified resource in storage.
////////////////////////////////////////////////
    public function update(Request $request, $id)
    {
        $myTempletes = UnitStatusDate::find($id);

        $myTempletes->name = $request->input('name');

        $myTempletes->update();
        return redirect('/myTempletesIndexIndex')->with('status', 'Unit Status Date Updated successfully'); 
    }
////////////////////////////////////////////////
//* Update the specified resource in storage.
////////////////////////////////////////////////
    public function updateUnitStatus(Request $request, $id)
    {
        $unitStatus = Unit::find($id);

        $unitStatus->name = $request->input('name');

        $unitStatus->update();
        return redirect('/myTempletesIndexIndex')->with('status', 'Unit Status Updated successfully'); 
    }
////////////////////////////////////////////////
//* Remove the specified resource from storage
////////////////////////////////////////////////
    public function destroy($id)
    {
        $myTempletes = UnitStatusDate::find($id);

        $myTempletes->delete();
        return redirect('/myTempletesIndex')->with('status', 'Unit Status Date deleted successfully');   
    }
////////////////////////////////////////////////


    
}
