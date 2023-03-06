<?php

namespace App\Http\Controllers;

use App\Models\Site;
use App\Models\Unit;
use Illuminate\Http\Request;

class SiteController extends Controller
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
        $sites = Site::all();
        return view('admins.sites.index', compact('sites'));
    }
    ///////////////////////////////////////////////
    //* Show the form for creating a new resource.
    ////////////////////////////////////////////////
    public function create()
    {
        return view('admins.sites.create');
    }
    ////////////////////////////////////////////////
    //* Store a newly created resource in storage.
    ////////////////////////////////////////////////
    public function store(Request $request)
    {
        $site = new Site();

        $site->name = $request->input('name');
        $site->save();
        return redirect('/sites/index')->with('status', 'تم اضافة الموقع');
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
        $site = Site::find($id);
        return view('admins.sites.edit', compact('site'));
    }
    ////////////////////////////////////////////////
    //* Update the specified resource in storage.
    ////////////////////////////////////////////////
    public function update(Request $request, $id)
    {
        $site = Site::find($id);

        $site->name = $request->input('name');

        $site->update();

        return redirect('/sites.index')->with('status', 'تم تعديل الموقع');
    }
    ////////////////////////////////////////////////
    //* Remove the specified resource from storage
    ////////////////////////////////////////////////
    public function destroy($id)
    {
        $units = Unit::select()->where('site_id', $id)->get();
        if (count($units) > 0 ) {
            return back()->with('status', 'الموقع له بيانات اساسية و لا يمكن حذفه');
        }
        $site = Site::find($id);

        $site->delete();
        return redirect('/sites')->with('status', 'MyTempletesIndex deleted successfully');
    }
    ////////////////////////////////////////////////

}
