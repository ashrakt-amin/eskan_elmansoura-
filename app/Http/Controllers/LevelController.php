<?php

namespace App\Http\Controllers;

use App\Models\Construction;
use App\Models\Unit;
use App\Models\Level;
use Illuminate\Http\Request;

class LevelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
///////////////////////////////////////////////
//* Display a listing of the resource.
///////////////////////////////////////////////
    public function index()
    {
        $levels = Level::all();
        return view('admins.levelsIndex', compact('levels'));
    }
///////////////////////////////////////////////
//* Show the form for creating a new resource.
////////////////////////////////////////////////
    public function create()
    {
        return view('admins.constructions.addLevel');
    }
////////////////////////////////////////////////
//* Store a newly created resource in storage.
////////////////////////////////////////////////
    public function store(Request $request)
    {
        $levels = new Level();

        $levels->name = $request->input('name');
        $levels->save();
        return redirect('/levelsIndex')->with('status', 'Level added successfully');
    }
////////////////////////////////////////////////
//* Display the specified resource.
////////////////////////////////////////////////
    public function showLevel($id, $constructions)
    {
        $level = Unit::select()->where('construction_id', '=', $constructions)->offset($id*4)->limit(4)->get();
        $constructions = Construction::find($constructions);
        return view('admins.constructions.showLevel', compact('level', 'constructions'));
    }
////////////////////////////////////////////////
//* Display the specified resource.
////////////////////////////////////////////////
    public function show($id, $constructionId)
    {
        $construction = Construction::find($constructionId);
        $level      = Level::with('units')->find($id);
        $levelUnits = Unit::select()->where([['construction_id', $constructionId], ['level_id', $id]])->orderby('id', 'asc')->get();
        if (isset($_GET['status'])) {
            $status = $_GET['status'];
            $levelUnits = Unit::where([['construction_id', '=', $constructionId], ['level_id', $id], ['status', '=' , $status]])->orderby('id', 'asc')->get();
        }

        if (isset($_GET['subProperty'])) {
            $subProperty = $_GET['subProperty'];
            $levelUnits = Unit::where([['construction_id', $constructionId], ['level_id', $id], ['sub_property_id', $subProperty]])->orderby('id', 'asc')->get();
        }

        return view('admins.constructions.singleLevel', compact('level', 'levelUnits', 'construction'));
    }
////////////////////////////////////////////////
////////////////////////////////////////////////
public function show2(Request $request, $id)
{
    $level        = Level::with('units')->find($id);
    $construction = Construction::find($request->input('construction_id'));
    $levelUnits   = Unit::select()->where([['construction_id', $request->input('construction_id')], ['level_id', $request->input('level_id')]])->orderby('id', 'asc')->get();



    return view('admins.constructions.singleLevel', compact('level', 'levelUnits', 'construction'));
}
////////////////////////////////////////////////
//* Show the form for editing the specified resource.
////////////////////////////////////////////////
    public function search($construction_id)
    {
        $construction = Construction::find($construction_id);
        if (!isset($_GET['subProperty'])) {
            if(isset($_GET['status']) && isset($_GET['level_id'])) {
                $status          = $_GET['status'];
                $level_id        = $_GET['level_id'];
                if ($level_id != 'الكل') {
                    if ($status != 'الكل' ) {
                        $levelUnits = Unit::where([['construction_id', $construction_id], ['level_id', $level_id], ['status', $status]])->orderby('id', 'asc')->get();
                    }  else {
                        $levelUnits = Unit::where([['construction_id', $construction_id], ['level_id', $level_id]])->orderby('id', 'asc')->get();
                    }
                    $level  = Level::find($level_id );
                    return view('admins.constructions.singleLevel', compact('level', 'levelUnits', 'construction'));
                } else {
                    if ($status != 'الكل' ) {
                        $units = Unit::where([['construction_id', $construction_id], ['status', $status]])->orderby('id', 'asc')->get();
                        return view('admins.constructions.searchConstruction', compact('construction', 'units'));
                    }  else {
                        return redirect()->route('showConstruction', ['id'=>$construction_id]);
                    }
                }
            }
        } else {
            // if isset sub property
            $sub_property_id = $_GET['subProperty'];
            $status          = $_GET['status'];
            $level_id        = $_GET['level_id'];
            if ($sub_property_id != 'الكل') {
                if ($level_id != 'الكل') {
                    if ($status != 'الكل' ) {
                        $levelUnits = Unit::where([['construction_id', $construction_id], ['level_id', $level_id], ['status', $status], ['sub_property_id', $sub_property_id]])->orderby('id', 'asc')->get();
                    }  else {
                        $levelUnits = Unit::where([['construction_id', $construction_id], ['level_id', $level_id], ['sub_property_id', $sub_property_id]])->orderby('id', 'asc')->get();
                    }
                    $level  = Level::find($level_id );
                    return view('admins.constructions.singleLevel', compact('level', 'levelUnits', 'construction'));
                } else {
                    if ($status != 'الكل' ) {
                        $units = Unit::where([['construction_id', $construction_id], ['status', $status], ['sub_property_id', $sub_property_id]])->orderby('id', 'asc')->get();
                        return view('admins.constructions.searchConstruction', compact('construction', 'units'));
                    }  else {
                        $units = Unit::where([['construction_id', $construction_id], ['sub_property_id', $sub_property_id]])->orderby('id', 'asc')->get();
                        return view('admins.constructions.searchConstruction', compact('construction', 'units'));
                    }
                }
            } else {
                // if !isset sub property
                if ($level_id != 'الكل') {
                    if ($status != 'الكل' ) {
                        $levelUnits = Unit::where([['construction_id', $construction_id], ['level_id', $level_id], ['status', $status]])->orderby('id', 'asc')->get();
                    }  else {
                        $levelUnits = Unit::where([['construction_id', $construction_id], ['level_id', $level_id]])->orderby('id', 'asc')->get();
                    }
                    $level  = Level::find($level_id );
                    return view('admins.constructions.singleLevel', compact('level', 'levelUnits', 'construction'));
                } else {
                    if ($status != 'الكل' ) {
                        $units = Unit::where([['construction_id', $construction_id], ['status', $status]])->orderby('id', 'asc')->get();
                        return view('admins.constructions.searchConstruction', compact('construction', 'units'));
                    }  else {
                        return redirect()->route('showConstruction', ['id'=>$construction_id]);
                    }
                }
            }
        }

    }
////////////////////////////////////////////////
//* Show the form for editing the specified resource.
////////////////////////////////////////////////
    public function edit($id)
    {
        $levels = Level::find($id);
        return view('admins.constructions.editLevel', compact('levels'));
    }
////////////////////////////////////////////////
//* Update the specified resource in storage.
////////////////////////////////////////////////
    public function update(Request $request, $id)
    {
        $levels = Level::find($id);

        $levels->name        = $request->input('name');

        $levels->update();
        return redirect('/levelsIndex')->with('status', 'Level Updated successfully');
    }
////////////////////////////////////////////////
//* Remove the specified resource from storage
////////////////////////////////////////////////
    public function destroy($id)
    {

        $unitLevels  = Unit::select('level_id')->where('level_id', $id)->get();
        if (count($unitLevels) > 0) {
            return back()->with('danger', 'يوجد وحدات في هذا الطابق يرجى حذفها اولا');
        }
            $levels = Level::find($id);
        $levels->delete();
        return redirect('/levelsIndex')->with('success', 'تم حذف الطابق');
    }
////////////////////////////////////////////////

}
