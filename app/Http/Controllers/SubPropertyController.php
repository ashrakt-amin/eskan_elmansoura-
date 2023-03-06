<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\MainProject;
use App\Models\SubProperty;
use App\Models\Construction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubPropertyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {

        if (!isset(Auth::user()->privilege_id)) {
            return view('auth.login');
        }

        $subProperties = SubProperty::all();

        return view('admins.subProperties.index', compact('subProperties'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admins.subProperties.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $subProperty = new SubProperty();

        $subProperty->name            = $request->input('name');
        $subProperty->save();
        return redirect('/subProperties')->with('status', 'Category added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($subProperty)
    {
        $sub_property = SubProperty::with('units')->find($subProperty);

        $units = Unit::where('sub_property_id', $subProperty)->get();

        return view('admins.subProperties.show', compact('sub_property', 'units'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $sub_property = SubProperty::with('units')->find($request->input('subProperty'));

        $units = Unit::where([['construction_id', $request->input('construction_id')], ['sub_property_id', $request->input('subProperty')]])->get();

        return view('admins.subProperties.search', compact('sub_property', 'units'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($subProperty)
    {
        $subProperty = SubProperty::find($subProperty);
        return view('admins.subProperties.edit', compact('subProperty'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $subProperty)
    {
        $subProperty = SubProperty::find($subProperty);

        $subProperty->name        = $request->input('name');
        $subProperty->update();
        return redirect('/subProperties')->with('status', 'Property updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($subProperty)
    {
        $unitProIds = Unit::select('sub_property_id')->where('sub_property_id', $subProperty)->get();
            if (count($unitProIds)) {
                return back()->with('none', 'يوجد بيانات اخرى تحت هذا القسم ولا يمكن حذفه');
            }


        $subProperty = SubProperty::find($subProperty);

        $subProperty->delete();
        return redirect('/subProperties')->with('success', 'Property deleted successfully');
    }
}
