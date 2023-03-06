<?php

namespace App\Http\Controllers;

use App\Models\Site;
use App\Models\Unit;
use App\Models\Level;
use App\Models\Customer;
use App\Models\Property;
use App\Models\MainProject;
use App\Models\SubProperty;
use App\Models\Construction;
use Illuminate\Http\Request;

class ConstructionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $constructions = Construction::orderBy('main_project_id', 'asc')->get();
        return view('admins.constructionsIndex', compact('constructions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $properties   = Property::all();
        $main_projects = MainProject::all();
        return view('admins.constructions.addConstruction', compact('properties', 'main_projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @return \Illuminate\Http\Response
     */
    public function createConstructionsRows(Request $request)
    {
        $property_id     = $request->input('property_id');
        $main_project_id = $request->input('main_project_id');
        $levels          = $request->input('levels_count');
        $level_units     = $request->input('level_units');
        $rows            = $request->input('rows');
        if (empty($total_units)) {
            $total_units     = $request->input('total_units');

        } else {
            $total_units     = $level_units * $levels;
        }
        $properties   = Property::all();
        $property     = Property::find($property_id);
        $main_projects= MainProject::all();
        $main_project = MainProject::find($main_project_id);
        return view('admins.constructions.addConstructions', compact('properties', 'property', 'main_projects', 'main_project', 'levels', 'level_units', 'total_units', 'rows'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $constructions = new Construction();

        $constructions->name            = $request->input('name');
        $constructions->property_id     = $request->input('property_id');
        $constructions->main_project_id = $request->input('main_project_id');
        $constructions->levels_count    = $request->input('levels_count');
        $constructions->level_units     = $request->input('level_units');
        if (!empty($request->input('total_units'))) {
            $constructions->total_units     = $request->input('total_units');
        } else {
            $constructions->total_units     = $constructions->level_units * $constructions->levels_count;
        }
        $constructions->coast           = $request->input('coast');
        $constructions->save();
        return redirect('/constructionsIndex?addConstruction')->with('status', 'Construction added successfully');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeMultipleConstructions(Request $request)
    {

        foreach ($request->name as $key => $value) {

            $constructions = new Construction();
            // if ($request->hasFile('image'))
        // {
        //     $file            = $request->file('image');
        //     $ext             = $file->getClientOriginalExtension();
        //     $filename        = time().'.'.$ext;
        //     $file->move('assets/images/uploads/customer/',$filename);
        //     $customers->image = $filename;
        // }
        // if ($request->input('email')->exists())
        // {
            //     alert('email exists');
            // }

            $constructions->name            = $value;
            $constructions->property_id     = $request->property_id[$key];
            $constructions->main_project_id = $request->main_project_id[$key];
            $constructions->levels_count    = $request->levels_count[$key];
            $constructions->level_units     = $request->level_units[$key];
            $constructions->total_units     = $request->total_units[$key];
            $constructions->coast           = $request->coast[$key];
            $constructions->coast           = $request->coast[$key];
            $constructions->save();
        }
            return redirect('/constructionsIndex?addConstruction')->with('status', 'Constructions added successfully');
        }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $construction = Construction::with('customers', 'mainProject', 'units')->find($id);
        $units        = Unit::where('construction_id', $id)->orderby('id', 'asc')->get();
        foreach ($units as $unit) {
            $payments[]     = $unit->payments->sum('payment_value');
            $installments[] = $unit->installments->sum('installment_value');
            $array = array_sum($payments) + array_sum($installments);
            if ($unit->payments->sum('payment_value') == 0) {
                $array = 0;
            }
        }
        $construction_id = $construction->id;
        $allLevels = Level::all();
        $sites      = Site::all();
        $subProperties   = SubProperty::all();

        if (count($units) == 0) {
            $array = 0;
        }
        return view('admins.constructions.showConstruction', compact('construction', 'allLevels', 'subProperties', 'sites', 'units', 'array'));
    }

    public function search(Request $request, $id)
    {
        $status = $request->input('status');
        $construction = Construction::find($id);
        $levels     = Level::all();
        $units = Unit::where([['construction_id', '=', $id],['status', '=' , $status]])->orderby('id', 'asc')->get();
        if ($status == 'الكل') {
            $units = Unit::where('construction_id', $id)->orderby('id', 'asc')->get();
            return view('admins.constructions.showConstruction', compact('construction', 'units', 'levels'));
        }
        return view('admins.constructions.searchConstruction', compact('construction', 'units', 'levels'));
    }

    public function showConstructionLevels($id)
    {
        $constructions = Construction::with('customers', 'mainProjects')->find($id);
        $construction_id = $constructions->id;
        $units = Unit::select()->where('construction_id', '=', $construction_id)->get();

        return view('admins.constructions.levelsTable', compact('constructions', 'units'));
    }

    public function showConstructionUnits($id)
    {
        $constructions = Construction::with('customers', 'mainProject')->find($id);
        $construction_id = $constructions->id;
        $units = Unit::select()->where('construction_id', '=', $construction_id)->get();

        return view('admins.constructions.showConstructionUnits', compact('constructions', 'units'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $construction  = Construction::find($id);
        $properties    = Property::all();
        $main_projects  = MainProject::all();
        return view('admins.constructions.editConstruction', compact('construction', 'main_projects', 'properties'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $construction = Construction::find($id);
        $construction->name            = $request->input('name');
        $construction->property_id     = $request->input('property_id');
        $construction->main_project_id = $request->input('main_project_id');
        if (!empty($request->input('levels_count'))) {
            $construction->levels_count    = $request->input('levels_count');
        }
        $construction->level_units     = $request->input('level_units');
        $construction->total_units     = $request->input('total_units');

        $construction->update();
        return redirect('/constructionsIndex')->with('success', 'تم تعديل المبنى');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $unitsConIds    = Unit::select('construction_id')->where('construction_id', $id)->get();
        foreach ($unitsConIds as $unitsConId) {
            if (!is_null($unitsConId) || !empty($unitsConId)) {
                return back()->with('status', 'يوجد وحدات تحت هذه المنشأة ولا يمكن حذفها');
            }
        }
        $constructions = Construction::find($id);

        $constructions->delete();
        return redirect('/constructionsIndex')->with('status', 'constructions deleted successfully');
    }
}
