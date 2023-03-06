<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\Finance;
use App\Models\Payment;
use Illuminate\Http\Request;

class FinanceController extends Controller
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
        $finances = Finance::all();
        return view('admins.financesIndex', compact('finances'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admins.finances.addFinance');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $finance = new Finance();

        $finance->name          = $request->input('name');
        $finance->monthes_count = $request->input('monthes_count');

        $finance->save();
        return redirect('/financesIndex')->with('status', 'Finance added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $finance = Finance::find($id);

        return view('/admins.finances.financeShow', compact('finance'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $finance = Finance::find($id);
        return view('admins.finances.editFinance', compact('finance'));
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
        $finance = Finance::find($id);

        $finance->name               = $request->input('name');
        $finance->monthes_count = $request->input('monthes_count');

        $finance->update();
        return redirect('/financesIndex')->with('success', 'Finance updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $unitFinances    = Unit::select('finance_id')->where('finance_id', $id)->get();
        if (count($unitFinances) > 0 ) {
            return back()->with('none', 'يوجد دفعات تحت هذا النظام ولا يمكن حذفه');
        }

        $finance = Finance::find($id);

        $finance->delete();

        return redirect('/financesIndex')->with('success', 'تم حذف نظام الدفع');
    }
}
