<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Privilege;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // public function privilegeRedirection()
    // {
    //     if (isset( Auth::user()->privilege_id) && Auth::user()->privilege_id != 1) {
    //         return back()->with('danger', 'ليست من صلاحياتك الدخول هنا');
    //     } elseif (empty(Auth::user()->privilege_id)) {
    //         return redirect()->route('login')->with('warning', 'يرجى التسجيل اولا');
    //     }
    // }

    //* Show all.
    ////////////////////////////////////////////////
    public function index()
    {
        // Session::forget('danger');

        if (isset( Auth::user()->privilege_id) && Auth::user()->privilege_id != 1) {
            return back()->with('danger', 'ليست من صلاحياتك الدخول هنا');
        } elseif (empty(Auth::user()->privilege_id)) {
            return redirect()->route('login')->with('warning', 'يرجى التسجيل اولا');
        }
        $users = User::orderby('id', 'asc')->get();
        return view('users.index', ['users'=>$users]);
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
        $privileges = Privilege::orderby('id', 'asc')->get();
        return view('users.create', ['privileges'=>$privileges]);
    }
    ///////////////////////////////////////////////


    //*  create a new resource.
    ////////////////////////////////////////////////
    public function store(Request  $request)
    {
        if (isset( Auth::user()->privilege_id) && Auth::user()->privilege_id != 1) {
            return back()->with('danger', 'ليست من صلاحياتك الدخول هنا');
        } elseif (empty(Auth::user()->privilege_id)) {
            return redirect()->route('login')->with('warning', 'يرجى التسجيل اولا');
        }

        $request->validate([
            'name'      =>'required',
            'last_name' =>'required',
            'email'     => 'required|unique:users',
            'password'  => 'required|min:6|max:20',
        ],[
            'name.required'      =>'اسم المستخدم مطلوب',
            'last_name.required' =>'اللقب مطلوب',
            'email.required'     =>'البريد الالكتروني مطلوب',
            'email.unique'       =>'البريد الالكتروني موجود من قبل',
            'password.required'  =>'الرقم السري مطلوب',
            'password.min'       =>'الرقم السري لا يقل عن 6',
            'password.max'       =>'الرقم السري لا يزيد عن 20',
        ]);

        $user = new User();

        $user->name            = $request->input('name');
        $user->mid_name        = $request->input('mid_name');
        $user->last_name       = $request->input('last_name');
        $user->age             = $request->input('age');
        $user->phone           = $request->input('phone');
        $user->email           = $request->input('email');
        $user->gender          = $request->input('gender');
        $user->password        = Hash::make($request['password']);
        $user->privilege_id    = $request->input('privilege_id');


        $user->save();

        return redirect()->route('users.index')->with('success', 'تم اضافة مستخدم جديد');
    }
    ///////////////////////////////////////////////


    //* Show the form for updating resource.
    ////////////////////////////////////////////////
    public function edit($user)
    {
        $user = User::find($user);
        return view('users.edit', ['user'=>$user]);
    }
    ///////////////////////////////////////////////


    //* update resource.
    ////////////////////////////////////////////////
    public function update(Request $request, $user)
    {

        // $user = array($request);

        $request->validate([
            'name'      =>'required',
            'last_name' =>'required',
            'email'     => 'required',
            'password'  => 'nullable|min:6|max:20',
        ],[
            'name.required'      =>'اسم المستخدم مطلوب',
            'last_name.required' =>'اللقب مطلوب',
            'email.required'     =>'البريد الالكتروني مطلوب',
            'password.required'  =>'الرقم السري مطلوب',
            'password.min'       =>'الرقم السري لا يقل عن 6',
            'password.max'       =>'الرقم السري لا يزيد عن 20',
        ]);

        $users = User::where('id', '!=', $user)->get();
        foreach ($users as $item) {
            if ($item->email == $request->input('email')) {
                $user = User::find($user);
                return redirect()->route('users.edit',['user'=>$user])->with('none', 'البريد الالكتروني مسجل لستخدم اخر');
            }
        }

        $user = User::find($user);

        $user->name            = $request->input('name');
        $user->mid_name        = $request->input('mid_name');
        $user->last_name       = $request->input('last_name');
        $user->age             = $request->input('age');
        $user->phone           = $request->input('phone');
        $user->email           = $request->input('email');
        $user->gender          = $request->input('gender');
        if (!empty($request->input('password'))) {
            if (empty($request->input('password_confirmation'))) {
                return redirect()->route('users.edit',['user'=>$user->id])->with('danger', 'كلمة المرور غير متطابفة');
            } else {
                if ($request->input('password') !== $request->input('password_confirmation')) {
                    return redirect()->route('users.edit',['user'=>$user->id])->with('danger', 'كلمة المرور غير متطابفة');
                }
            }
            $user->password        = Hash::make($request['password']);;
        }
        if (!empty($request->input('privilege_id'))) {
            $user->privilege_id    = $request->input('privilege_id');
        }

        $user->update();

        if (!empty($request->input('privilege_id'))) {
            return redirect()->route('users.index')->with('warning', 'تم التعديل');
        }
        return redirect()->route('index')->with('warning', 'تم التعديل');
    }
    ///////////////////////////////////////////////


    //* Show resource.
    ////////////////////////////////////////////////
    public function show($user)
    {
        $user = User::find($user);
        return view('users.show', ['user'=>$user]);
    }
    ///////////////////////////////////////////////


    //* Show resource.
    ////////////////////////////////////////////////
    public function destroy($user)
    {

        if (isset( Auth::user()->privilege_id) && Auth::user()->privilege_id != 1) {
            return back()->with('danger', 'ليست من صلاحياتك الدخول هنا');
        } elseif (empty(Auth::user()->privilege_id)) {
            return redirect()->route('login')->with('warning', 'يرجى التسجيل اولا');
        }
    }
    ///////////////////////////////////////////////
}
