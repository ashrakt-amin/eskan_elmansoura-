<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Privilege;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PrivilegeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    //* Show all.
    ////////////////////////////////////////////////
    public function index()
    {
        if (isset( Auth::user()->privilege_id) && Auth::user()->privilege_id != 1) {
            return back()->with('danger', 'ليست من صلاحياتك الدخول هنا');
        } elseif (empty(Auth::user()->privilege_id)) {
            return redirect()->route('login')->with('warning', 'يرجى التسجيل اولا');
        }

        $privileges = Privilege::orderby('id', 'asc')->get();
        return view('admins.privileges.index', ['privileges'=>$privileges]);
    }
    ///////////////////////////////////////////////


    //* Show the form for creating a new resource.
    ////////////////////////////////////////////////
    public function create()
    {
        if (isset( Auth::user()->privilege_id) && Auth::user()->privilege_id != 1) {
            return back()->with('danger', 'ليست من صلاحياتك الدخول هنا');
        } elseif (empty(Auth::user()->privilege_id)) {
            return redirect()->route('login')->with('warning', 'يرجى التسجيل اولا');
        }
        return view('admins.privileges.create');
    }
    ///////////////////////////////////////////////


    //*  create a new resource.
    ////////////////////////////////////////////////
    public function store(Request  $request)
    {
        $request->validate([
            'name' =>'required|unique:privileges|max:14|min:3',
            'code' => 'required|integer|max:20|min:0|unique:privileges',
        ],[
            'name.required'=>'اسم الصلاحية مطلوب',
            'name.unique'=>'الصلاحية موجودة من قبل',
            'name.max'=>'الاسم طويل للغاية',
            'name.min'=>'الاسم غير منطقي',
            'code.required'=>'كود الصلاحية مطلوب',
            'code.unique'=>'كود الصلاحية موجود من قبل',
        ]);

        $privilege = new Privilege();

        $privilege->name = $request->input('name');
        $privilege->code = $request->input('code');


        $privilege->save();
        return redirect('privileges/')->with('success', 'تم اضافة صلاحية ');
    }
    ///////////////////////////////////////////////


    //* Show the form for updating resource.
    ////////////////////////////////////////////////
    public function edit($privilege)
    {
        $privilege = Privilege::find($privilege);

        return view('admins.privileges.edit', ['privilege'=>$privilege]);
    }
    ///////////////////////////////////////////////


    //* update resource.
    ////////////////////////////////////////////////
    public function update(Request $request, $privilege)
    {
        $privileges = Privilege::where('id', '!=', $privilege)->get();

        foreach ($privileges as $privilegefor) {
            if ($privilegefor->name == $request->input('name')) {
                return back()->with('none', 'اسم الصلاحية موجود من قبل ');
            }
            if ($privilegefor->code == $request->input('code')) {
                return back()->with('none', $privilegefor->name.' '.'كود الصلاحية موجود تحت اسم');
            }
        }

        $privilege = Privilege::find($privilege);

        $privilege->name = $request->input('name');
        $privilege->code = $request->input('code');

        $privilege->update();
        return redirect('privileges/')->with('warning', 'تم تعديل الصلاحية ');
    }
    ///////////////////////////////////////////////


    //* Show resource.
    ////////////////////////////////////////////////
    // public function show($privilege)
    // {
    //     $privilege = Privilege::find($privilege);

    //     return view('admins.privileges.show', ['privilege'=>$privilege]);
    // }
    ///////////////////////////////////////////////


    //* Show resource.
    ////////////////////////////////////////////////
    public function destroy($privilege)
    {

        $users     = User::where('privilege_id', $privilege)->get();

        if (count($users) > 0 ) {
            return back()->with('danger', "يوجد مستخدمين تحت الصلاحية");
        }

        $privilege = Privilege::find($privilege);

        $privilege->delete();
        return back()->with('success', 'تم حذف العنصر');
    }
    ///////////////////////////////////////////////
}
