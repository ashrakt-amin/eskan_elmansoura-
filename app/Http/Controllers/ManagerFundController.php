<?php

namespace App\Http\Controllers;

use App\Models\ManagerFund;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManagerFundController extends Controller
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
        $managerFunds        = ManagerFund::all();
        $incomingPersonal    = ManagerFund::select('value')->where([['kind', 0],['category', 0]])->sum('value');
        $outgoingPersonal    = ManagerFund::select('value')->where([['kind', 1],['category', 0]])->sum('value');
        $incomingCompany     = ManagerFund::select('value')->where([['kind', 0],['category', 1]])->sum('value');
        $outgoingCompany     = ManagerFund::select('value')->where([['kind', 1],['category', 1]])->sum('value');
        $incomingFunds       = $incomingPersonal + $incomingCompany;
        $outgoingFunds       = $outgoingPersonal + $outgoingCompany;

        if (isset( Auth::user()->privilege_id) && Auth::user()->privilege_id != 1) {
            return back()->with('danger', 'ليست من صلاحياتك الدخول هنا');
        } elseif (empty(Auth::user()->privilege_id)) {
            return redirect()->route('login')->with('warning', 'يرجى التسجيل اولا');
        } else {
            return view('admins.managerFundIndex', compact('managerFunds' , 'incomingPersonal', 'outgoingPersonal', 'incomingCompany', 'outgoingCompany', 'incomingFunds', 'outgoingFunds'));
        }
    }
    ///////////////////////////////////////////////
    //* Show the form for creating a new resource.
    ////////////////////////////////////////////////
    public function create()
    {
        return view('admins.manager.addManagerFund');
    }
    ////////////////////////////////////////////////
    //* Store a newly created resource in storage.
    ////////////////////////////////////////////////
    public function store(Request $request)
    {
        $managerFund = new ManagerFund();

        $managerFund->kind       = $request->input('kind');
        $managerFund->category   = $request->input('category');
        $managerFund->value      = $request->input('value');
        $managerFund->comment    = $request->input('comment');
        $date_date  = $request->input('date_date');
        if (isset($date_date) && !empty($request->input('date_date'))) {
            $managerFund->created_at  = $request->input('date_date');
        }
        $managerFund->save();
        return redirect('/managerFundIndex')->with('status', 'Manager Fund added successfully');
    }
    ////////////////////////////////////////////////
    //* Display the specified resource.
    ////////////////////////////////////////////////
    public function show($id)
    {
        //
    }
    ////////////////////////////////////////////////
        //* Search the specified resource.
    ////////////////////////////////////////////////
    public function search($id)
    {

        if ($id == 0) {
            $managerFunds  = ManagerFund::select()->where('category', 0)->get();
            $in    = ManagerFund::select('value')->where([['category', 0], ['kind', 0]])->sum('value');
            $out   = ManagerFund::select('value')->where([['category', 0], ['kind', 1]])->sum('value');
            $sumManagerFunds = $in - $out;
        } elseif ($id == 1) {
            $managerFunds  = ManagerFund::select()->where('category', 1)->get();
            $in    = ManagerFund::select('value')->where([['category', 1], ['kind', 0]])->sum('value');
            $out   = ManagerFund::select('value')->where([['category', 1], ['kind', 1]])->sum('value');
            $sumManagerFunds = $in - $out;
        }

        return view('admins.managerFundIndex', compact('managerFunds', 'sumManagerFunds', 'in'));
    }
    ////////////////////////////////////////////////
    //* Search the specified resource.
    ////////////////////////////////////////////////
    public function searchByAll(Request $request)
    {
        if (isset($_GET)) {
            $day_from = $_GET['day_from'];
            $day_to   = $_GET['day_to'];
            $one_day  = $_GET['one_day'];
            $kind     = $_GET['kind'];
            $category = $_GET['category'];

            $betweenDate = array($day_from, $day_to);
            $cat_kind    = array($kind, $category);

            if (isset($day_from ) && isset($day_to )) {
                if (!empty($day_from) && !empty($day_to)) {


                    if (($kind == 0 || $kind == 1) && ($category == 0 || $category == 1)) {
                        $managerFunds      = ManagerFund::select()->where([['kind', $kind],['category', $category]])->whereBetween('created_at', [$day_from, ++$day_to])->get();
                        $in    = ManagerFund::select('value')->where([['kind', 0],['category', $category]])->whereBetween('created_at', [$day_from, $day_to])->sum('value');
                        $out   = ManagerFund::select('value')->where([['kind', 1],['category', $category]])->whereBetween('created_at', [$day_from, $day_to])->sum('value');
                        $sumManagerFunds = $in - $out;
                    } elseif (empty($kind) && ($category == 0 || $category == 1)) {
                        $managerFunds      = ManagerFund::select()->where('category', $category)->whereBetween('created_at', [$day_from, ++$day_to])->get();
                        $in    = ManagerFund::select('value')->where([['kind', 0],['category', $category]])->whereBetween('created_at', [$day_from, $day_to])->sum('value');
                        $out   = ManagerFund::select('value')->where([['kind', 1],['category', $category]])->whereBetween('created_at', [$day_from, $day_to])->sum('value');
                        $sumManagerFunds = $in - $out;
                    } elseif (empty($category) && ($kind == 0 || $kind == 1)) {
                        $managerFunds      = ManagerFund::select()->where('kind', $kind)->whereBetween('created_at', [$day_from, ++$day_to])->get();
                        $in    = ManagerFund::select('value')->where('kind', 0)->whereBetween('created_at', [$day_from, $day_to])->sum('value');
                        $out   = ManagerFund::select('value')->where('kind', 1)->whereBetween('created_at', [$day_from, $day_to])->sum('value');
                        $sumManagerFunds = $in - $out;
                    } elseif (empty($category) && empty($kind)) {
                        $managerFunds      = ManagerFund::select()->whereBetween('created_at', [$day_from, ++$day_to])->get();
                        $in    = ManagerFund::select('value')->where('kind', 0)->whereBetween('created_at', [$day_from, $day_to])->sum('value');
                        $out   = ManagerFund::select('value')->where('kind', 1)->whereBetween('created_at', [$day_from, $day_to])->sum('value');
                        $sumManagerFunds = $in - $out;
                    } else {
                        dd(0);
                    }
                } elseif (empty($day_from) && empty($day_to) && !empty($one_day)) {
                    if (($kind == 0 || $kind == 1) && ($category == 0 || $category == 1)) {
                        $managerFunds      = ManagerFund::select()->where([['kind', $kind],['category', $category]])->whereDate('created_at', '=', $one_day)->get();
                        $in    = ManagerFund::select('value')->where([['kind', 0],['category', $category]])->whereDate('created_at', '=', $one_day)->sum('value');
                        $out   = ManagerFund::select('value')->where([['kind', 1],['category', $category]])->whereDate('created_at', '=', $one_day)->sum('value');
                        $sumManagerFunds = $in - $out;
                    } elseif (empty($kind) && ($category == 0 || $category == 1)) {
                        $managerFunds      = ManagerFund::select()->where('category', $category)->whereDate('created_at', '=', $one_day)->get();
                        $sumManagerFunds   = ManagerFund::select('value')->where('category', $category)->whereDate('created_at', '=', $one_day)->sum('value');
                        $in    = ManagerFund::select('value')->where([['kind', 0],['category', $category]])->whereDate('created_at', '=', $one_day)->sum('value');
                        $out   = ManagerFund::select('value')->where([['kind', 1],['category', $category]])->whereDate('created_at', '=', $one_day)->sum('value');
                        $sumManagerFunds = $in - $out;
                    } elseif (empty($category) && ($kind == 0 || $kind == 1)) {
                        $managerFunds      = ManagerFund::select()->where('kind', $kind)->whereDate('created_at', '=', $one_day)->get();
                        $sumManagerFunds   = ManagerFund::select('value')->where('kind', $kind)->whereDate('created_at', '=', $one_day)->sum('value');
                        $in    = ManagerFund::select('value')->where('kind', 0)->whereDate('created_at', '=', $one_day)->sum('value');
                        $out   = ManagerFund::select('value')->where('kind', 1)->whereDate('created_at', '=', $one_day)->sum('value');
                        $sumManagerFunds = $in - $out;
                    } elseif (empty($category) && empty($category)) {
                        $managerFunds      = ManagerFund::select()->whereDate('created_at', '=', $one_day)->get();
                        $in    = ManagerFund::select('value')->where('kind', 0)->whereDate('created_at', '=', $one_day)->sum('value');
                        $out   = ManagerFund::select('value')->where('kind', 1)->whereDate('created_at', '=', $one_day)->sum('value');
                        $sumManagerFunds = $in - $out;
                    }
                } elseif (empty($day_from) && empty($day_to) && empty($one_day)) {
                    return redirect('managerFundIndex');
                }


            }
            return view('admins.managerFundIndex', compact('managerFunds', 'sumManagerFunds', 'in'));

        }

    }
    ////////////////////////////////////////////////
    //* Show the form for editing the specified resource.
    ////////////////////////////////////////////////
    public function edit($id)
    {
        $managerFund = ManagerFund::find($id);
        return view('admins.manager.editManagerFund', compact('managerFund'));
    }
    ////////////////////////////////////////////////
    //* Update the specified resource in storage.
    ////////////////////////////////////////////////
    public function update(Request $request, $id)
    {
        $managerFund = ManagerFund::find($id);

        $managerFund->kind     = $request->input('kind');
        $managerFund->category = $request->input('category');
        $managerFund->value    = $request->input('value');
        $managerFund->comment  = $request->input('comment');
        $date_date  = $request->input('date_date');
        if (isset($date_date) && !empty($request->input('date_date'))) {
            $managerFund->created_at  = $request->input('date_date');
        }

        $managerFund->update();
        return redirect('/managerFundIndex')->with('status', 'ManagerFund Updated successfully');
    }
    ////////////////////////////////////////////////
    //* Remove the specified resource from storage
    ////////////////////////////////////////////////
    public function destroy($id)
    {
        $myTempletes = ManagerFund::find($id);

        $myTempletes->delete();
        return redirect('/managerFundIndex')->with('status', 'ManagerFund deleted successfully');
    }
    ////////////////////////////////////////////////

}
