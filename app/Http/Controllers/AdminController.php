<?php

namespace App\Http\Controllers;

use DateTime;
use Carbon\Carbon;
use App\Models\Unit;
use App\Models\Admin;
use App\Models\Level;
use App\Models\Finance;
use App\Models\Payment;
use App\Models\Customer;
use App\Models\Property;
use App\Models\Installment;
use App\Models\MainProject;
use App\Models\SubProperty;
use App\Models\Construction;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
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
    public function indexFunction()
    {
        $mainProjects   = MainProject::all();
        $payments       = Payment::all();
        $installments   = Installment::all();
        $current_week   = Payment::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->get();
        $todayPayments  = Payment::whereDate('created_at', date('Y-m-d'))->get();
        $current_month   = Payment::whereMonth('created_at', date('m'))->get();
        $todayInstallments = Installment::whereDate('created_at', date('Y-m-d'))->get();
        $installments_week = Installment::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->get();
        $installments_month = Installment::whereMonth('created_at', date('m'))->get();
        $all_payments  = Payment::sum('payment_value');
        $all_installments = Installment::sum('installment_value');
        $all_funds = $all_payments + $all_installments;
        // dd($all_funds);

        $units_week = Unit::orderBy('updated_at', 'asc')->where('status', '!=', 'خالية')->whereBetween('updated_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->get();

        $units_day = Unit::orderBy('updated_at', 'asc')->where('status', '!=', 'خالية')->whereDate('updated_at', date('Y-m-d'))->get();

        $units_month = Unit::orderBy('updated_at', 'asc')->where('status', '!=', 'خالية')->whereMonth('updated_at', date('m'))->whereYear('updated_at', date('Y'))->get();

        $units_all = Unit::orderBy('updated_at', 'asc')->where('status', '!=', 'خالية')->get();

        // return view('my_dashboard.index',
        //     compact('mainProjects','payments', 'installments', 'current_week', 'todayPayments', 'current_month', 'todayInstallments',
        //     'installments_week', 'installments_month', 'units_day', 'units_week', 'units_month',
        //     'all_payments', 'all_installments', 'units_all'));

        return array(
            'mainProjects'      =>$mainProjects,
            'payments'          =>$payments,
            'installments'      =>$installments,
            'current_week'      =>$current_week,
            'todayPayments'     =>$todayPayments,
            'current_month'     =>$current_month,
            'todayInstallments' =>$todayInstallments,
            'installments_week' =>$installments_week,
            'installments_month'=>$installments_month,
            'units_day'         =>$units_day,
            'units_week'        =>$units_week,
            'units_month'       =>$units_month,
            'all_payments'      =>$all_payments,
            'all_installments'  =>$all_installments,
            'units_all'         =>$units_all,
        );
    }
    
    public function index()
    {
        $index = $this->indexFunction();
        return view('my_dashboard.index', ['index'=>$index]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function new()
    {
        $properties       = Property::all();
        $subProperties    = SubProperty::all();
        $mainProjects     = MainProject::all();

        return view('admins.index.index', compact('properties', 'subProperties', 'mainProjects'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function filter($subPropertyId, $constructionId)
    {
        $properties       = Property::all();
        $subProperties    = SubProperty::all();
        $units = Unit::select()->where([['sub_property_id', $subPropertyId], ['construction_id', $constructionId]])->get();

        return view('admins.index.mainPropertiesFilter', compact('units', 'properties', 'subProperties'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admins.addCustomer');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $customers = new Customer();
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

        $customers->name        = $request->input('name');
        $customers->mid_name    = $request->input('mid_name');
        $customers->last_name   = $request->input('last_name');
        $customers->age         = $request->input('age');
        $customers->gender      = $request->input('gender');
        $customers->phone       = $request->input('phone');
        $customers->email       = $request->input('email');
        $customers->national_id = $request->input('national_id');
        $customers->privilege_id = $request->input('privilege_id');
        $customers->save();
        return redirect('/addCustomer')->with('status', 'Customer added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function show(Admin $admin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function edit(Admin $admin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Admin $admin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin $admin)
    {
        //
    }
}
