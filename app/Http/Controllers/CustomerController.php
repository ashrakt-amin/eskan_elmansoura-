<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\Payment;
use App\Models\Customer;
use App\Models\Installment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class CustomerController extends Controller
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
        $customers = Customer::orderBy('name', 'asc')->get();
        // return response()->json([
        //     'customers' => $customers
        // ]);
        return view('admins.customerIndex', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admins.customers.addCustomer');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cutoms  = Customer::where('national_id', $request->input('national_id'))->get();
        foreach ($cutoms as $cutom) {
            $nat_id_name = $cutom->name.' '.$cutom->mid_name.' '.$cutom->last_name;
        }
        if (count($cutoms) > 0 ) {
            $request->validate([
                'national_id' => 'required|unique:customers|max:14|min:14',
            ], [
                'national_id.required' => 'مطلوب',
                'national_id.unique'   => $cutom->id,
                'national_id.max'      => 'الرقم القومي لا يزيد عن 14 رقما',
                'national_id.min'      => 'الرقم القومي لا يقل عن 14 رقما',
                // 'age.max'      => 'Age is more than eligible.',
                // 'age.min'      => 'Age is less than eligible.',
            ]);
        } else {
            $request->validate([
                // 'national_id' => 'max:14|min:14',
                'national_id' => 'required|unique:customers|max:14|min:14',
                // 'age'         => 'max:2|min:2',
                // 'phone'       => 'required|regex:/^(01)[0-9]{9}$/',
                // 'phone'       => 'unique:customers|regex:/^(01)[0-9]{9}$/',
                // 'phone'       => 'required',
            ], [
                'national_id.required' => 'مطلوب',
                'national_id.unique'   => 'مطلوب',
                'national_id.max'      => 'الرقم القومي لا يزيد عن 14 رقما',
                'national_id.min'      => 'الرقم القومي لا يقل عن 14 رقما',
                // 'age.max'      => 'Age is more than eligible.',
                // 'age.min'      => 'Age is less than eligible.',
            ]);
        }

        $customers = new Customer();

        if ($request->hasFile('image'))
        {
            $file            = $request->file('image');
            $ext             = $file->getClientOriginalExtension();
            $filename        = time().'.'.$ext;
            $file->move('assets/images/uploads/customer/',$filename);
            $customers->image = $filename;
        }

        $customers->name            = $request->input('name');
        $customers->mid_name        = $request->input('mid_name');
        $customers->last_name       = $request->input('last_name');
        $customers->age             = $request->input('age');
        $customers->gender          = $request->input('gender');
        $customers->phone           = $request->input('phone');
        $customers->national_id     = $request->input('national_id');
        $customers->privilege_id    = $request->input('privilege_id');
        $customers->additional_info = $request->input('additional_info');
        $customers->email           = $request->input('email');

        if ($customers->email == null || empty($request->input('email'))) {
            $customers->email = $customers->national_id.'لم يدخل بريد الكتروني';
        }

        $allCustomers = Customer::all();
        foreach ($allCustomers as $customer) {
            $customersEmails[] = $customer->email;
            $customersPhones[] = $customer->phone;
            $customersNational_id[] = $customer->national_id;

            // dd($customersEmails,$customersPhones,$customersNational_id,$customers->email,$request);
            if (in_array($customers->email, $customersEmails))
            // {
            //     return back()->with('status', ' البريد الالكتروني مسجل من قبل'.$customers->email);
            // }
            // if (in_array($customers->phone, $customersPhones)) {
            //     return back()->with('status', ' الهاتف مسجل من قبل');
            // }
            if (in_array($customers->national_id, $customersNational_id)) {
                return back()->with('status', ' الرقم القومي مسجل من قبل');
            }
        }
        // if ($customers->age < 21) {
        //     return back()->with('status', 'السن  اقل من 21');
        // }
        // if (strlen($customers->national_id) !== 14) {
        //     return back()->with('status', 'الرقم القومي غير قانوني');
        // }

        if (empty($customers->mid_name)) {
            $customers->mid_name = '-';
        }

        $customers->save();
        $last_customer = Customer::all()->last();
        if ($request->input('unit_id')) {
            return redirect()->route('editUnitStatus', ['id'=>$request->input('unit_id')])->with('success', 'تم اضافة'.($last_customer->name.' '.$last_customer->mid_name.' '.$last_customer->last_name).'بنجاح');
        }

        return redirect('/customerIndex')->with('status', 'تم اضافة'.($last_customer->name.' '.$last_customer->mid_name.' '.$last_customer->last_name).'بنجاح');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $customer = Customer::find($id);
        $units     = Customer::with('units')->find($id)->units;
        foreach ($units as $unit) {
            $unit_id = $unit->id;
        }
        $installment = Installment::find($id);
        $installments = Installment::select()->where('customer_id', $id)->get();

        $payments = Payment::select()->where('customer_id', $id)->get();
        foreach ($payments as $payment) {

        }

        foreach ($installments as $installment) {
            if (!empty($installment) || !is_null($installment)) {

                $months_array = [];
                $months_array[] = $installment->installment_month;
            } else {
                $months_array[] = ['hi', 'hi'];
            }
        }
        return view('admins.customers.customerShow', compact('customer', 'units', 'installments', 'payments'));
    }


    public function search(Request $request)
    {
        $customer_id  = $request->input('customer_id');
        $customer = Customer::find($customer_id);
        // dd($customer );
        return view('admins.customers.search', )->with('customer', $customer);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $customers = Customer::find($id);
        return view('admins.customers.editCustomer', compact('customers'));
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
        $customers = Customer::find($id);

        if ($request->hasFile('image'))
        {
            $path = 'assets/images/uploads/customer/'.$customers->image;
            if (File::exists($path))
            {
                File::delete($path);
            }
            $file            = $request->file('image');
            $ext             = $file->getClientOriginalExtension();
            $filename        = time().'.'.$ext;
            $file->move('assets/images/uploads/customer/',$filename);
            $customers->image = $filename;
        }

        // if ($request->input('email')->exists())
        // {
        //     alert('email exists');
        // }

        $customers->id          = $id;
        $customers->name        = $request->input('name');
        $customers->mid_name    = $request->input('mid_name');
        $customers->last_name   = $request->input('last_name');
        $customers->age         = $request->input('age');
        $customers->gender      = $request->input('gender');
        $customers->phone       = $request->input('phone');
        $customers->email       = $request->input('email');
        $customers->national_id = $request->input('national_id');
        $customers->additional_info = $request->input('additional_info');

        if ($customers->email == null) {
            $customers->email = $customers->phone.'لم يدخل بريد الكتروني';
        }

        $allCustomers = Customer::where('id', '!=', $id)->get();

        foreach ($allCustomers as $customer) {
            $customersEmails[] = $customer->email;
            $customersPhones[] = $customer->phone;
            $customersNational_id[] = $customer->national_id;

            // if (in_array($customers->email, $customersEmails))
            // {
            //     return back()->with('status', ' البريد الالكتروني مسجل من قبل'.$customers->email);
            // }
            // if (in_array($customers->phone, $customersPhones)) {
            //     return back()->with('status', ' الهاتف مسجل من قبل');
            // }
            if (in_array($customers->national_id, $customersNational_id)) {
                return back()->with('status', ' الرقم القومي مسجل من قبل');
            }

        }
        // if ($customers->age < 21) {
        //     return back()->with('status', 'السن  اقل من 21');
        // }
        if (strlen($customers->national_id) !== 14) {
            return back()->with('status', 'الرقم القومي غير قانوني');
        }

        $customers->update();
        return redirect('/customerIndex')->with('status', 'Customer updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
