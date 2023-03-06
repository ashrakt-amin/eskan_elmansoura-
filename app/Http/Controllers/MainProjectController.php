<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Property;
use App\Models\MainProject;
use App\Models\Construction;
use Illuminate\Http\Request;

class MainProjectController extends Controller
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
        $main_projects = MainProject::orderby('id', 'asc')->get();
        return view('admins.main_projectsIndex', compact('main_projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $properties  = Property::orderby('id', 'asc')->get();
        return view('admins.main_projects.add_main_project', compact('properties'));
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
            'name'        => 'required|unique:main_projects,name',
            'property_id' => 'required',
        ], [
            'name.required' => 'يجب ادخال قيمة',
            'name.unique' => 'المشروع موجود من قبل',
            'property_id.required' => 'يجب ادخال قيمة',
        ]);

        $main_projects = new MainProject();

        $main_projects->name            = $request->input('name');
        $main_projects->property_id     = $request->input('property_id');
        $main_projects->save();
        return redirect('/main_projectsIndex')->with('success', 'MainProject added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $mainProject   = MainProject::find($id);
        foreach ($mainProject->units as $unit) {
            $payments[]     = $unit->payments->sum('payment_value');
            $installments[] = $unit->installments->sum('installment_value');
            $array = array_sum($payments) + array_sum($installments);
        }
        $main_projects = MainProject::where('property_id', $mainProject->id)->orderby('id', 'asc')->get();
        // $mainProject->customers()->attach($id);
        return view('admins.main_projects.show_main_project', compact('mainProject', 'main_projects', 'array'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $properties  = Property::all();

        $main_project = MainProject::find($id);
        return view('admins.main_projects.edit_main_project', compact('main_project', 'properties'));
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
            'name'        => 'required',
            'property_id' => 'required',
        ], [
            'name.required' => 'يجب ادخال قيمة',
            'property_id.required' => 'يجب ادخال قيمة',
        ]);

        $main_project = MainProject::find($id);

        $main_projects = MainProject::where('id', '!=', $id)->get();
        foreach ($main_projects as $main_project_stored) {
            $stored = $main_project_stored->name;
            if ($stored == $request->input('name')) {
                return back()->with('none', '"'.' مسجل من قبل  '.'"'.$stored);
            }
        }
        if ($main_project->name == $request->input('name')) {
            return back()->with('none',  '"'.'لم تكتب اسما جديدا للمشروع  '.'"'.$main_project_stored->name);
        }

        $main_project->name        = $request->input('name');
        $main_project->property_id     = $request->input('property_id');

        $main_project->update();
        return redirect('/main_projectsIndex')->with('warning',  '"'.'تم تعديل القسم الى'.'"'.$main_project_stored->name);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $constructions    = Construction::select('main_project_id')->where('main_project_id', $id)->get();
        if (count($constructions) > 0 ) {
            return back()->with('none', 'يوجد عمارات تحت هذا المشروع ولا يمكن حذفه');
        }

        $mainProject = MainProject::find($id);

        $mainProject->delete();

        return back()->with('success', 'تم حذف المشروع ');
    }
}
