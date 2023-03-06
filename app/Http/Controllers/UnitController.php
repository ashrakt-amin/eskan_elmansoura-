<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Site;
use App\Models\Unit;
use App\Models\Level;
use App\Models\Balance;
use App\Models\Finance;
use App\Models\Payment;
use App\Models\Customer;
use App\Models\OverMuchUnit;
use App\Models\Property;
use App\Models\Residual;
use App\Models\Installment;
use App\Models\MainProject;
use App\Models\PaymentKind;
use App\Models\SubProperty;
use App\Models\Construction;
use Illuminate\Http\Request;
use App\Models\FinancePercentage;
use Illuminate\Support\Facades\Auth;

class UnitController extends Controller
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

            // if (!isset(Auth::user()->privilege_id)) {
            //     return redirect('login')->with('warning', 'يرجى اعادة تسجيل الدخول');
            // }

            $units = Unit::orderby('construction_id', 'asc')->get();

            return view('admins.unitsIndex', compact('units'));
        }
        ///////////////////////////////////////////////
    //* Show the form for creating a new resource.
    ////////////////////////////////////////////////
    public function create()
    {

        $units         = Unit::all();
        $customers     = Customer::all();
        $properties    = Property::all();
        $main_projects = MainProject::all();
        $constructions = Construction::all();
        $levels        = Level::all();
        $sites          = Site::all();
        return view('admins.units.addUnit', compact('units','customers' , 'properties', 'main_projects', 'constructions', 'levels', 'sites'));
    }

    ////////////////////////////////////////////////
    //* Show the form for creating a new resource.
    ////////////////////////////////////////////////

    //* Show the form for creating a new resource.
    ////////////////////////////////////////////////
    public function createUnitCustom(Request $request)
    {
        $property_id     = $request->input('property_id');
        $subProperty_id  = $request->input('sub_property_id');
        $main_project_id = $request->input('main_project_id');
        $construction_id = $request->input('construction_id');
        $level_id        = $request->input('level_id');
        $site_id         = $request->input('site_id');
        $level           = Level::find($level_id);
        $space           = $request->input('space');
        $price_m         = $request->input('price_m');
        $unit_price      = $space * $price_m;
        $rows            = $request->input('rows');
        $units        = Unit::all();
        $customers    = Customer::all();
        $allLevels        = Level::all();
        $sites          = Site::all();
        $site    = Site::find($site_id);

        $getId =[$property_id, $main_project_id, $construction_id];
        if (count($getId) < 3 ) {
            return back()->with('none', 'القسم و المشروع و المنشأة لا يجب ان تكون فارغة');
        }

        $subProperty  = SubProperty::find($subProperty_id);
        $subProperties= SubProperty::all();
        $property     = Property::find($property_id);
        $properties   = Property::all();
        $main_project = MainProject::find($main_project_id);
        $main_projects= MainProject::all();
        $construction = Construction::find($construction_id);
        $constructions= Construction::all();

        return view('admins.units.createUnitCustom', compact('units','customers' , 'property', 'properties' , 'subProperties', 'subProperty', 'main_project', 'main_projects', 'construction', 'constructions', 'level', 'allLevels', 'space', 'price_m', 'unit_price', 'rows', 'sites', 'site'));
    }
    ////////////////////////////////////////////////
    //* Store a newly created resource in storage.
    ////////////////////////////////////////////////
    public function store(Request $request)
    {
        $units = new Unit();

        $units->property_id     = $request->input('property_id');
        $units->sub_property_id = $request->input('sub_property_id');
        $units->main_project_id = $request->input('main_project_id');
        $units->construction_id = $request->input('construction_id');
        //------------- start If total units == count units  --------------//
            $constructiontotalUnits = Construction::select()->where('id' ,$units->construction_id)->get();
            foreach ($constructiontotalUnits as $constructiontotalUnit) {

            }
            $constructionUnitsCount  = Unit::select()->where('construction_id' ,$units->construction_id)->count('id');
            if ($constructiontotalUnit->total_units == $constructionUnitsCount) {
                return back()->with('none', 'عدد الوحدات سيتخطى العدد الفعلي');
            }
        // dd($constructiontotalUnit->total_units, $constructionUnitsCount);
        //------------- End If total units == count units  --------------//
        $units->level_id        = $request->input('level_id');
        //---------- Start prevent entering more 4 units in 1 level  && arrange levels ascending even if empty level input---------//
            if (isset($units) && is_null($units->level_id) || empty($units->level_id)) {
                $units->level_id = 1 ;
            }
            $last_level_id     = Unit::orderBy('level_id', 'desc')->where('construction_id' ,$units->construction_id)->first();
            if (!is_null( $last_level_id)) {
                if ($units->level_id == $last_level_id->level_id) {
                    $level_id_units = Unit::select('level_id')->where([['construction_id' ,$units->construction_id], ['level_id', $units->level_id]])->get();
                    foreach ($level_id_units as $level_id_unit) {
                    }
                    if (count($level_id_units) == 4 && $last_level_id->level_id == $level_id_unit->level_id) {
                        $units->level_id        = ++$units->level_id;
                    } elseif (count($level_id_units) < 4 && $last_level_id->level_id == $level_id_unit->level_id) {
                        $units->level_id        = $units->level_id;
                    } elseif (count($level_id_units) < 4 && $last_level_id->level_id > $level_id_unit->level_id) {
                        $units->level_id        = $last_level_id->level_id;
                    }
                } elseif ($units->level_id !== $last_level_id->level_id) {
                    $last_level_ids    = Unit::select('level_id')->where([['construction_id' ,$units->construction_id], ['level_id', $last_level_id->level_id]])->get();
                        if (count($last_level_ids) < 4) {
                            $units->level_id        = $last_level_id->level_id;
                        } elseif (count($last_level_ids) == 4) {
                            $units->level_id        = ++$last_level_id->level_id;
                        }
                }
            }
        //---------- End prevent entering more 4 units in 1 level  && arrange levels ascending even if empty level input---------//
        $units->name            = $request->input('name');
        //---------- Start unique name in one level ---------//
        $units->name            = $request->input('name');
        $unitNames = Unit::select('name')->where([['construction_id' ,$units->construction_id], ['level_id', $units->level_id]])->get();
        if (!is_null( $unitNames ) || !empty( $unitNames )) {
            foreach ($unitNames as $unitName) {
                $namesArray[] = $unitName->name;
                if (in_array($units->name, $namesArray)) {
                    return back()->with('none', 'اسم الوحدة موجود من قبل في هذا الطابق');
                }
            }
        }
        //---------- End unique name in one level ---------//
        ////////////////////////////////////////////////////////////////////////////
        //---------- Start unique site in one level ---------//
        $units->site_id            = $request->input('site_id');
            $unitSites = Unit::select('site_id')->where([['construction_id' ,$units->construction_id], ['level_id', $units->level_id]])->get();
            if (!is_null( $unitSites ) || !empty( $unitSites )) {
                foreach ($unitSites as $unitSite) {
                    $sitsArray[] = $unitSite->site_id;
                    if (in_array($units->site_id, $sitsArray)) {
                        // dd('duplicated site');
                        return back()->with('none', 'يوجد وحدة اخرى في هذا الموقع');
                    }
                }
            }
        //---------- End unique site in one level ---------//
        $units->space           = $request->input('space');
        $units->price_m         = $request->input('price_m');
        $units->unit_price      = $units->space * $units->price_m;
        $units->unitDescription = 'وحدات';
        $units->status          = $request->input('status');
        $units->customer_id     = $request->input('customer_id');
        $units->save();

            //---- start Update Construction Coast ----//
            //---- start Update Construction Coast ----//
            //---- start Update Construction Coast ----//

            $constructionId = $request->input('construction_id');
            $units        = Unit::select()->where('construction_id', $constructionId)->get();
            $construction = Construction::find($constructionId);

            $construction->coast            = $units->sum('unit_price');
            $construction->update();
            //---- End Update Construction Coast ----//
            //---- End Update Construction Coast ----//
            //---- End Update Construction Coast ----//


        return redirect('/unitsIndex')->with('none', 'Unit added successfully');
    }

    ////////////////////////////////////////////////

    //* Multiple Store a newly created resource in storage.
    ////////////////////////////////////////////////
    public function unitMultipleStore(Request $request)
    {
        foreach ($request->name as $key => $value) {
            $units = new Unit();
            $units->name            = $value;
            $units->property_id     = $request->property_id[$key];
            $units->sub_property_id = $request->sub_property_id[$key];
            $units->main_project_id = $request->main_project_id[$key];
            $units->construction_id = $request->construction_id[$key];
            $units->level_id        = $request->level_id[$key];
            $units->site_id         = $request->site_id[$key];
            $units->space           = $request->space[$key];
            $units->price_m         = $request->price_m[$key];
            $units->unit_price      = $units->space * $units->price_m;
            $units->unitDescription = 'وحدات';
            $units->status          = $request->status[$key];
            $units->customer_id     = $request->customer_id[$key];

                $units->unit_price  = intval($units->unit_price, 0);

                $unSelectedArray = array($units->sub_property_id, $units->site_id, $units->level_id);

                if (in_array(0, $unSelectedArray)) {

                    return back()->with('none', 'لم يتم اختيار القسم او الموقع او الطابق او الكل');
                }
            $units->save();
        }
            $subProperty = SubProperty::find($units->sub_property_id);
            $subProperty->properties()->attach([$units->property_id]);


            //---- start Update Construction Coast ----//
            //---- start Update Construction Coast ----//
            //---- start Update Construction Coast ----//

            $constructionId = $request->construction_id[$key];

            $units        = Unit::select()->where('construction_id', $constructionId)->get();
            $construction = Construction::find($constructionId);

            $construction->coast            = $units->sum('unit_price');
            $construction->update();
            //---- End Update Construction Coast ----//
            //---- End Update Construction Coast ----//
            //---- End Update Construction Coast ----//
            $construction = Construction::find($constructionId);
            $units        = Unit::where('construction_id', $constructionId)->orderby('id', 'asc')->get();
        return redirect()->route('showConstruction', ['id'=>$constructionId])->with('success', 'تم اضافة الوحدة بنجاح');
    }
    ////////////////////////////////////////////////
    //* Display the specified resource.
    ////////////////////////////////////////////////
    public function show($id)
    {

        $unit         = Unit::find($id);
        // $payments    = Payment::select()->where([['unit_id', $id], ['cancellation_code', 0 ]])->get();
        // dd($payments);
        // if ($payments->isNotEmpty() && !is_null($payments)) {
        //     foreach ($payments as $payment) {
        //         $financeId = $payment->finance_id;
        //         if ($financeId) {
        //             if (!empty($financeId) || !is_null($financeId)) {
        //                 $financePercentages = FinancePercentage::select()->where('finance_id', $financeId)->get();
        //             }
        //         }
        //     }
        // } else {
        //     $financePercentages = FinancePercentage::all();
        // }

        // $installment  = Installment::with('customers', 'unit', 'constructions', 'property','mainProjects')->find($id);
        // $installments = Installment::select()->where([['unit_id', $id], ['cancellation_code', 0 ]])->get();
        // $residuals  = Residual::select()->where([['customer_id', $unit->customer_id], ['unit_id', $id], ['cancellation_code', 0 ]])->get();
        // if (count($residuals) > 0 ) {
        //     foreach ($residuals as $item) {
        //     }
        //     $residual = $item->residual;
        // } else {
        //     $residual = '';
        // }

        return view('admins.units.unitShow', compact('unit'));

    }
    ////////////////////////////////////////////////
    //* Show the form for editing the specified resource.
    ////////////////////////////////////////////////
    public function edit($id)
    {
        $unit = Unit::find($id);
        $subProperties = SubProperty::all();
        $sites         = Site::all();
        $levels        = Level::all();
        return view('admins.units.editUnit', compact('unit', 'subProperties', 'sites', 'levels'));
    }
    ////////////////////////////////////////////////
    //* Update the specified resource in storage.
    ////////////////////////////////////////////////
    public function update(Request $request, $id)
    {
        $unit = Unit::find($id);
        $created_at = $unit->created_at;
        // dd($updated_at, $request->input('updated_at' ));
        $units = Unit::where([['id', '!=', $id], ['construction_id', $unit->construction_id],['level_id', $request->input('level_id')]])->get();
        foreach ($units as $unit_stored) {
            $stored = $unit_stored->name;
            if ($stored == $request->input('name')) {
                return back()->with('none', '"'.' مسجل من قبل في الدور'.$unit_stored->level->name.'  '.'وحدة رقم"'.$request->input('name'));
            }
        }

        // $unit->status          = $request->input('status');
        $unit->unit_price  = intval($unit->unit_price, 0);

        $payments = Payment::where([['unit_id', $id], ['customer_id', $unit->customer_id]])->get();
        if ($unit->customer_id > 0 && count($payments) > 0) {
            $unit->name            = $request->input('name');
            $unit->sub_property_id = $request->input('sub_property_id');
            $unit->level_id        = $request->input('level_id');
            $unit->site_id         = $request->input('site_id');
            $unit->unitDescription = 'وحدات';
            if (empty($request->input('created_at' )) || is_null($request->input('created_at'))) {
                $unit->created_at      = $created_at;
            } else {
                $unit->created_at      = $request->input('created_at' )." ".date("H:i:s");
            }
            $unit->update();
            return redirect('unitShow/'.$id)->with('none', 'تم تعديل بينات الوحدة ولكن لا يمكن تغيير سعر الوحدة او مساحتها بعد استلام دفعات');
        } else {
            $unit->name            = $request->input('name');
            $unit->sub_property_id = $request->input('sub_property_id');
            $unit->level_id        = $request->input('level_id');
            $unit->site_id         = $request->input('site_id');
            $unit->space           = $request->input('space');
            $unit->price_m         = $request->input('price_m');
            $unit->unit_price      = $unit->space * $unit->price_m;
            $unit->unitDescription = 'وحدات';
            $unit->customer_id     = $request->input('customer_id');
            if (empty($request->input('created_at' )) || is_null($request->input('created_at'))) {
                $unit->created_at      = $created_at;
            } else {
                $unit->created_at      = $request->input('created_at')." ".date("H:i:s");
            }
        }

        $unit->update();

            //---- start Update Construction Coast ----//
            //---- start Update Construction Coast ----//
            //---- start Update Construction Coast ----//

            $constructionId = $request->input('construction_id');
            $unitsWhere        = Unit::where('construction_id', $constructionId)->get();
            $construction      = Construction::find($constructionId);

            $construction->coast            = $unitsWhere->sum('unit_price');
            $construction->update();
            //---- End Update Construction Coast ----//
            //---- End Update Construction Coast ----//
            //---- End Update Construction Coast ----//

        return redirect('unitShow/'.$id)->with('success', 'تم تعديل الوحدة');
    }
    ////////////////////////////////////////////////
    //* Show the form for editing the specified resource.
    ////////////////////////////////////////////////
    public function editUnitStatus($id)
    {
        if (isset( Auth::user()->privilege_id) && Auth::user()->privilege_id != (1 ||  2)) {
            return back()->with('danger', 'ليست من صلاحياتك الدخول هنا');
        }
        $unit = Unit::find($id);
            if ($unit->status !== 'خالية'  && $unit->status !== 'ملغاة') {
                return view('admins.units.editUnitStatus', compact('unit'));
            }
        $customers  = Customer::all();
        return view('admins.units.editUnitStatus', compact('unit', 'customers'));
    }
    ////////////////////////////////////////////////
    ////////////////////////////////////////////////


    //* Update the specified resource in storage.
    ////////////////////////////////////////////////
    public function updateUnitStatus(Request $request, $id)
    {
        if (isset( Auth::user()->privilege_id) && Auth::user()->privilege_id != (1 ||  2)) {
            return back()->with('danger', 'ليست من صلاحياتك الدخول هنا');
        }
        $unit = Unit::find($id);

        $unit->status          = $request->input('status');
        $unit->customer_id     = $request->input('customer_id');
        $unit->created_at      = date('Y-m-d H:i:s');
        if ($unit->customer_id == 0) {
            return back()->with('none', 'لم يتم اختيار العميل');
        }
        //----- Start cancellation && restore unite booking -----//
        //----- Start cancellation && restore unite booking -----//
        //----- Start cancellation && restore unite booking -----//
        if ($unit->status == 'ملغاة') {
            $customerPayments = Payment::where([['unit_id', $id], ['customer_id', $unit->customer_id]])->get();
            $customerInstalls = Installment::where([['unit_id', $id], ['customer_id', $unit->customer_id]])->get();
            if (count($customerPayments) > 0 ) {
                // return back()->with('none', 'نحن نعمل على تفعيل هذه الميزة الان');
                foreach ($customerPayments as $customerPayment) {
                    $payment  = Payment::find($customerPayment->id);
                    $payment->cancellation_code = 1;
                    $payment->update();
                }
            } else {
                $unit->status = 'خالية';
            }
            if (count($customerInstalls) > 0 ) {
                foreach ($customerInstalls as $customerInstall) {
                    $installment  = Installment::find($customerInstall->id);
                    $installment->cancellation_code = 1;
                    $installment->update();
                }
            }

            $unit->customer_id     = 0;
        } elseif ($unit->status == 'تعاقد') {
            $customerPayments = Payment::select()->where([['unit_id', $id], ['customer_id', $unit->customer_id]])->get();
            $customerInstalls = Installment::select()->where([['unit_id', $id], ['customer_id', $unit->customer_id]])->get();
            if (count($customerPayments) > 0 ) {
                foreach ($customerPayments as $customerPayment) {
                    $payment  = Payment::find($customerPayment->id);
                    $payment->cancellation_code = 0;
                    $payment->update();
                }
            }
            if (count($customerInstalls) > 0 ) {
                foreach ($customerInstalls as $customerInstall) {
                    $installment  = Installment::find($customerInstall->id);
                    $installment->cancellation_code = 0;
                    $installment->update();
                }
            }
        }
        //----- End cancellation && restore unit booking -----//
        //----- End cancellation && restore unit booking -----//
        //----- End cancellation && restore unit booking -----//

        //----- Start cancellation finance && finance percentage -----//
        //----- Start cancellation finance && finance percentage -----//
        //----- Start cancellation finance && finance percentage -----//
                if ($unit->finance_id > 0 ) {
                    $unit->finance_id = 0;
                    $finance_precentages = FinancePercentage::where('unit_id', $unit->id)->get();
                    foreach ($finance_precentages as $finance_precentage) {
                        $financePrecentage = FinancePercentage::find($finance_precentage->id);
                        $financePrecentage->delete();
                    }
                }
        //----- End cancellation finance && finance percentage -----//
        //----- End cancellation finance && finance percentage -----//
        //----- End cancellation finance && finance percentage -----//

        $unit->update();

        //----- Start Pivot  inserting -----//
        //----- Start Pivot s inserting -----//
        //----- Start Pivot  inserting -----//
        if ($unit->customer_id > 0) {
            $construction = Construction::find($unit->construction_id);
            $construction->customers()->attach([$unit->customer_id], ['unit_id'=> $unit->id]);
            $mainproject  = MainProject::find($unit->main_project_id);
            $mainproject->customers()->attach([$unit->customer_id], ['unit_id'=> $unit->id]);
        }


        // $main_projects = MainProject::all();
        // foreach ($main_projects as $main_project) {
        //     $units = Unit::where('main_project_id', $main_project->id)->get();
        //     foreach ($units as $unit) {
        //         if ($unit->customer_id !== 0 ) {
        //             $main_project->customers()->attach($main_project->id, ['customer_id'=>$unit->customer_id]);
        //         }
        //     }
        // }

        // $constructions = Construction::all();
        // foreach ($constructions as $construction) {
        //     $units = Unit::where('construction_id', $construction->id)->get();
        //     foreach ($units as $unit) {
        //         if ($unit->customer_id !== 0 ) {
        //             $construction->customers()->attach($construction->id, ['customer_id'=>$unit->customer_id]);
        //         }
        //     }
        // }
        //----- End Pivot  inserting -----//
        //----- End Pivot  inserting -----//
        //----- End Pivot  inserting -----//

        if ($unit->customer_id > 0 ) {
            return redirect('unitShow/'.$id)->with('success', 'تم حجز الوحدة رقم '.$unit->name.' للعميل '.$unit->customers->last_name);
        } else {
            return redirect('unitShow/'.$id)->with('success', 'تم الغاء تعاقد الوحدة رقم '.$unit->name);
        }
    }
    ////////////////////////////////////////////////
    //*     editing the addFinanceIdOrInstallments .
    ////////////////////////////////////////////////
    public function addFinanceIdOrInstallments(Request $request, $id)
    {
        if (isset( Auth::user()->privilege_id) && Auth::user()->privilege_id != (1 ||  2)) {
            return back()->with('danger', 'ليست من صلاحياتك الدخول هنا');
        }
        $unit = Unit::find($id);
        if (!empty($request->input('finance_id'))) {
            $unit->finance_id = $request->input('finance_id');
            $unit->update();
            return back()->with('success', 'تم اختيار نظام دفع للوحدة');
        } elseif (!empty($request->input('installments_count'))) {
            $installment = Installment::where([['unit_id', $id], ['customer_id', $unit->customer_id]])->first();
            // dd($installment);
            if ($installment) {
                return back()->with('success', 'تم دفع اقساط للوحدة ولا يمكن التغيير مؤقتا');

                $unit->installments_count = $request->input('installments_count');
                $unit->update();
                $installment = Installment::where([['unit_id', $id], ['customer_id', $unit->customer_id]])->first();
                $installment->residual_installments = $request->input('installments_count') - 1;
                $installment->update();
                $id = 1;
                $installments = Installment::where([['id', '>', $installment->id], ['unit_id', $unit->id], ['customer_id', $unit->customer_id]])->get();
                foreach ($installments as $singleInstallment) {
                    $id = $id+1;
                    $singleInstallment->residual_installments = $request->input('installments_count') - $id;
                    $singleInstallment->update();
                }
            } else {
                $unit->installments_count = $request->input('installments_count');
                $unit->update();
                return back()->with('success', 'تم اضافة عدد الاقساط للوحدة');
            }
        }

    }
    ////////////////////////////////////////////////

    //*     editing the addFinanceId .
    ////////////////////////////////////////////////
    public function addOverMuchPrice(Request $request)
    {
        $units        = Unit::where('main_project_id', $request->main_project_id)->get();
        foreach ($units as $unit) {
            $payments[]     = Payment::select('payment_value')->where('unit_id', $unit->id)->sum('payment_value');
            $installments[] = Installment::select('installment_value')->where('unit_id', $unit->id)->sum('installment_value');
        }
        if (!empty($payments)) {
            $payments     = array_sum($payments);
        } else {
            $payments     = 0;
        }
        if (!empty($installments)) {
            $installments = array_sum($installments);
        } else {
            $installments = 0;
        }

        $units_status_empty = Unit::where(['status'=>'خالية', 'main_project_id'=>$request->main_project_id])->get();
        foreach ($units_status_empty as $unit) {
            // $unit = Unit::find($unit->id);
            // $unit->over_much = $request->get('over_much');
            // $unit->update();
            $over_muche_unit = OverMuchUnit::orderBy('id', 'DESC')->where('unit_id', $unit->id)->first();
            $over_much = new OverMuchUnit();
            $over_much->unit_id         = $unit->id;
            $over_much->unit_name       = $unit->name;
            $over_much->main_project_id = $unit->main_project_id;
            $over_much->price_m         = !empty($over_muche_unit) ? $over_muche_unit->new_price_m : $unit->price_m;
            $over_much->over_much       = $request->get('over_much');
            $over_much->new_price_m     = $over_much->price_m + ($over_much->price_m * $over_much->over_much / 100);
            $over_much->unit_price      = $over_much->unit_price ? $over_much->unit_price : $unit->unit_price;
            $over_much->new_unit_price  = $over_much->new_price_m * $unit->space;
            $over_much->save();
        }
        $empty_units_prices        = OverMuchUnit::where(['main_project_id'=>$request->main_project_id])->sum('new_unit_price');

        $empty_over_much = $empty_units_prices * ($request->get('over_much') / 100);
        $units_prices = Unit::where('main_project_id', $request->main_project_id)->sum('unit_price');
        $balance = Balance::orderBy('id', 'DESC')->where(['main_project_id'=>$request->input('main_project_id')])->first();
        if (!$balance) {
            return back()->with('none', 'ادخل الميزانية المبدئية اولا');
        }
        $newBalance = new Balance();
        $newBalance->starting_balance = $balance->starting_balance;
        $newBalance->excepted_balance = $balance->excepted_balance;
        $newBalance->actual_balance   = $payments + $installments;
        $newBalance->current_balance  = $units_prices + $empty_units_prices * ($request->get('over_much') / 100);
        $newBalance->main_project_id  = $request->input('main_project_id');
        $newBalance->balance_code     = $balance->balance_code + 1 ;
        $newBalance->save();
        return back()->with('success', 'تم');
    }
    ////////////////////////////////////////////////


    //* Cancellation units
    ////////////////////////////////////////////////
    public function cancel($id)
    {

        $payments = Payment::select()->where('cancellation_code', $id)->get();// X

        return view('admins/units/cancellationUnits', compact('payments'));

    }
    ////////////////////////////////////////////////

    //* Remove the specified resource from storage
    ////////////////////////////////////////////////
    public function destroy($id)
    {

        $unit = Unit::find($id);
        $construction = Construction::find($unit->construction_id);
        $units        = Unit::where('construction_id', $unit->construction_id)->orderby('id', 'asc')->get();
        $lastUnit = Unit::all()->last();
        if ($unit->id !== $lastUnit->id) {
            return back()->with('none', 'يمكنك فقط حذف اخر واحدة و يجب الا تحوي بيانات اساسية');
        } else {
            if ($lastUnit->status !== 'خالية' && $lastUnit->status !== 'ملغاة') {
                return back()->with('none', 'الوحدة بها بيانات اساسية و لا يمكن حذفها');
            } else {
                $unit->delete();
            }
        }
        return redirect()->route('showConstruction', ['construction'=>$construction, 'units'=>$units])->with('success', 'تم حذف الوحدة بنجاح');
    }
    ////////////////////////////////////////////////

    //* Searching the specified resource from storage
    ////////////////////////////////////////////////
    public function search($id)
    {
        if ($id == 'week') {
            $units = Unit::orderBy('updated_at', 'asc')->where('status', '!=', 'خالية')->whereBetween('updated_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->get();
        } elseif ($id == date('Y-m-d')) {
            $units = Unit::orderBy('updated_at', 'asc')->where('status', '!=', 'خالية')->whereDate('updated_at', $id)->get();
        } else {
            $units = Unit::orderBy('updated_at', 'asc')->where('status', '!=', 'خالية')->whereMonth('updated_at', $id)->whereYear('updated_at', date('Y'))->get();
        }
        return view('admins.units.search', ['units'=>$units]);
    }
    ////////////////////////////////////////////////
}
