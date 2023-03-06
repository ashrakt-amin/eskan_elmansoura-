<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Prophecy\Prophet;
use App\Models\Property;
use App\Models\MainProject;
use App\Models\Construction;
use Illuminate\Http\Request;

class PropertyController extends Controller
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
        $properties = Property::all();
        return view('admins.propertiesIndex', compact('properties'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return redirect('/propertiesIndex?do=addProperty');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|unique:properties,name',
        ], [
            'name.required' => 'يجب ادخال قيمة',
            'name.unique' => 'القسم موجود من قبل',
        ]);
        $properties = new Property();

        $properties->name            = $request->input('name');
        $properties->save();
        return redirect('/propertiesIndex')->with('success', '"'.'تم اضافة قسم'.'"'.$properties->name);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $constructions = Construction::where('property_id', $id)->get();
        $main_projects = MainProject::where('property_id', $id)->get();

        return view('admins.properties.showProperties', compact('constructions', 'main_projects'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function search($id, $main_project)
    {
        $constructions = Construction::where([['property_id', $id], ['main_project_id', $main_project]])->get();
        $mainProject  = MainProject::find($main_project);
        return view('admins.properties.searchProperties', compact('constructions', 'mainProject'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $property= Property::find($id);
        return view('admins.properties.editProperty', compact('property'));
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
        $request->validate([
            'name' => 'required',
        ], [
            'name.required' => 'يجب ادخال قيمة',
        ]);

        $property = Property::find($id);

        $properties = Property::where('id', '!=', $id)->get();
        foreach ($properties as $property_stored) {
            $stored = $property_stored->name;
            if ($stored == $request->input('name')) {
                return back()->with('none', '"'.' مسجل من قبل  '.'"'.$stored);
            }
        }
        if ($property->name == $request->input('name')) {
            return back()->with('none',  '"'.'لم تكتب اسما جديدا للدفعة  '.'"'.$property->name);
        }

        $property->name        = $request->input('name');
        $property->update();
        return redirect('/propertiesIndex')->with('warning',  '"'.'تم تعديل القسم الى'.'"'.$property->name);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $mainProjectsProIds = MainProject::select('property_id')->where('property_id', $id)->get();
        foreach ($mainProjectsProIds as $mainProjectsProId) {
            if (!is_null($mainProjectsProId) || !empty($mainProjectsProId)) {
                return back()->with('danger', 'يوجد بيانات اخرى تحت هذا القسم ولا يمكن حذفه');
            }
        }

        $properties = Property::find($id);

        $properties->delete();
        return redirect('/propertiesIndex')->with('success', 'تم حذف القسم');
    }
}
