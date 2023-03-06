<?php

namespace App\Http\Controllers;

use DateTime;
use App\Models\Unit;
use App\Models\Payment;
use App\Models\Installment;
use App\Models\MainProject;
use App\Models\Construction;
use Illuminate\Http\Request;

class FormFilterController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // ----- CASH SEARCH FUNCTION -----
    public function cashFilter(Request $request)
    {
        $adminController = new AdminController();
        $index           = $adminController->indexFunction();
        $requests = $this->allRequests($request);

        if (is_null($requests['cash_kind']) && is_null($requests['main_project'])) {
            $array_returned = $this->cashMainEmpty_cashFilter($request);
        } elseif (is_null($requests['cash_kind']) && !is_null($requests['main_project'])) {
            $array_returned = $this->cashEmpty_cashFilter($request);
        } elseif (!is_null($requests['cash_kind']) && is_null($requests['main_project'])) {
            $array_returned = $this->mainEmpty_cashFilter($request);
        } elseif (!is_null($requests['cash_kind']) && !is_null($requests['main_project'])) {
            $array_returned = $this->cashMain_cashFilter($request);
        }

        return view('my_dashboard.index',
        ['index'=>$index, 'array_returned'=>$array_returned, 'requests'=>$requests]);
    }
    // ##### CASH SEARCH FUNCTION #####

    // ----- STATUS SEARCH  FUNCTION -----
    public function statusFilter(Request $request)
    {
        $adminController = new AdminController();
        $index           = $adminController->indexFunction();
        $requests = $this->allRequests($request);

        if (is_null($requests['status']) && is_null($requests['main_project'])) {
            $units_returned = $this->statusMainEmpty_statusFilter($request);
        } elseif (is_null($requests['status']) && !is_null($requests['main_project'])) {
            $units_returned = $this->statusEmpty_statuFilter($request);
        } elseif (!is_null($requests['status']) && is_null($requests['main_project'])) {
            $units_returned = $this->mainEmpty_statusFilter($request);
        } elseif (!is_null($requests['status']) && !is_null($requests['main_project'])) {
            $units_returned = $this->statusMain_statuFilter($request);
        }
        // return $units_returned;
        return view('my_dashboard.index',
        ['index'=>$index, 'units_returned'=>$units_returned, 'requests'=>$requests]);
    }
    // ##### STATUS SEARCH FUNCTION #####



    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // ----- allRequests -----
    public function allRequests (Request $request){
        $request_from = $request->get('from');
        $request_to   = $request->get('to');
        $from         = new DateTime(date('Y-m-d 00:00:01', strtotime($request->get('from'))));
        $to           = new DateTime(date('Y-m-d 23:59:59', strtotime($request->get('to'))));
        $from1970     = new DateTime(date('1970-01-01'));
        $today        = date('Y-m-d 23:59:59');
        $main_project = $request->get('main_project');
        $cash_kind    = $request->get('cash_kind');
        $status       = $request->get('status');
        return array(
            'request_from'=>$request_from,
            'request_to'  =>$request_to,
            'from'        =>$from,
            'to'          =>$to,
            'from1970'    =>$from1970,
            'today'       =>$today,
            'main_project'=>$main_project,
            'cash_kind'   =>$cash_kind,
            'status'      =>$status
        );
    }
    // ##### allRequests #####
/////////////////////////// --------------- CASH FILTER --------------- ///////////////////////////
/////////////////////////// --------------- CASH FILTER --------------- ///////////////////////////
/////////////////////////// --------------- CASH FILTER --------------- ///////////////////////////
    // ----- cashMainEmpty_cashFilter -----
    public function cashMainEmpty_cashFilter (Request $request){
        $requests = $this->allRequests($request);

        if (empty($requests['request_from']) && empty($requests['request_to'])) {
            $payments     = Payment::sum('payment_value');
            $installments = Installment::sum('installment_value');
        } elseif (!empty($requests['request_from']) && empty($requests['request_to'])) {
            $payments     = Payment::wherebetween('created_at', [$requests['from'], $requests['today']])->sum('payment_value');
            $installments = Installment::wherebetween('created_at', [$requests['from'], $requests['today']])->sum('installment_value');
        } elseif (empty($requests['request_from']) && !empty($requests['request_to'])) {
            $payments     = Payment::wherebetween('created_at', [$requests['from1970'], $requests['to']])->sum('payment_value');
            $installments = Installment::wherebetween('created_at', [$requests['from1970'], $requests['to']])->sum('installment_value');
        } elseif (!empty($requests['request_from']) && !empty($requests['request_to'])) {
            $payments     = Payment::wherebetween('created_at', [$requests['from'], $requests['to']])->sum('payment_value');
            $installments = Installment::wherebetween('created_at', [$requests['from'], $requests['to']])->sum('installment_value');
        }
        return array(
            'payments'     => $payments,
            'installments' => $installments,
        );
    }
    // ##### cashMainEmpty_cashFilter #####

    // ----- cashEmpty_cashFilter -----
    public function cashEmpty_cashFilter (Request $request){
        $requests = $this->allRequests($request);
        $mainProject = MainProject::find($requests['main_project']);
        $units = Unit::where('main_project_id', $requests['main_project'])->get();
        foreach ($units as $unit) {
            if (is_null($requests['request_from']) && is_null($requests['request_to'])) {
                $payments[]     = Payment::select('payment_value')->where('unit_id', $unit->id)->sum('payment_value');
                $installments[] = Installment::select('installment_value')->where('unit_id', $unit->id)->sum('installment_value');
            } elseif (!is_null($requests['request_from']) && is_null($requests['request_to'])) {
                $payments[]     = Payment::select('payment_value')->where('unit_id', $unit->id)->wherebetween('created_at', [$requests['from'], $requests['today']])->sum('payment_value');
                $installments[] = Installment::select('installment_value')->where('unit_id', $unit->id)->wherebetween('created_at', [$requests['from'], $requests['today']])->sum('installment_value');
            } elseif (is_null($requests['request_from']) && !is_null($requests['request_to'])) {
                $payments[]     = Payment::select('payment_value')->where('unit_id', $unit->id)->wherebetween('created_at', [$requests['from1970'], $requests['to']])->sum('payment_value');
                $installments[] = Installment::select('installment_value')->where('unit_id', $unit->id)->wherebetween('created_at', [$requests['from1970'], $requests['to']])->sum('installment_value');
            } elseif (!is_null($requests['request_from']) && !is_null($requests['request_to'])) {
                $payments[]     = Payment::select('payment_value')->where('unit_id', $unit->id)->wherebetween('created_at', [$requests['from'], $requests['to']])->sum('payment_value');
                $installments[] = Installment::select('installment_value')->where('unit_id', $unit->id)->wherebetween('created_at', [$requests['from'], $requests['to']])->sum('installment_value');
            }
        }
        $payments     = array_sum($payments);
        $installments = array_sum($installments);
        return array(
            'payments'     => $payments,
            'installments' => $installments,
            'mainProject'  => $mainProject,
        );
    }
    // ##### cashEmpty_cashFilter #####

    // ----- mainEmpty_cashFilter -----
    public function mainEmpty_cashFilter (Request $request){
        $requests = $this->allRequests($request);
        if (is_null($requests['request_from']) && is_null($requests['request_to'])) {
            if ($requests['cash_kind'] == 0) {
                $payments     = Payment::sum('payment_value');
            } else {
                $installments = Installment::sum('installment_value');
            }
        } elseif (!is_null($requests['request_from']) && is_null($requests['request_to'])) {
            if ($requests['cash_kind'] == 0) {
                $payments     = Payment::wherebetween('created_at', [$requests['from'], $requests['today']])->sum('payment_value');
            } else {
                $installments = Installment::wherebetween('created_at', [$requests['from'], $requests['today']])->sum('installment_value');
            }
        } elseif (is_null($requests['request_from']) && !is_null($requests['request_to'])) {
            if ($requests['cash_kind'] == 0) {
                $payments     = Payment::wherebetween('created_at', [$requests['from1970'], $requests['to']])->sum('payment_value');
            } else {
                $installments = Installment::wherebetween('created_at', [$requests['from1970'], $requests['to']])->sum('installment_value');
            }
        } elseif (!is_null($requests['request_from']) && !is_null($requests['request_to'])) {
            if ($requests['cash_kind'] == 0) {
                $payments     = Payment::wherebetween('created_at', [$requests['from'], $requests['to']])->sum('payment_value');
            } else {
                $installments = Installment::wherebetween('created_at', [$requests['from'], $requests['to']])->sum('installment_value');
            }
        }
        if ($requests['cash_kind'] == 0) {
            return array(
                'payments'     => $payments,
                'installments' => 0,
            );
        } else {
            return array(
                'payments'     => 0,
                'installments' => $installments,
            );
        }
    }
    // ##### mainEmpty_cashFilter #####

    // ----- cashMain_cashFilter -----
    public function cashMain_cashFilter (Request $request){
        $requests = $this->allRequests($request);
        $mainProject = MainProject::find($requests['main_project']);
        $units = Unit::where('main_project_id', $requests['main_project'])->get();
        foreach ($units as $unit) {
            if (is_null($requests['request_from']) && is_null($requests['request_to'])) {
                if ($requests['cash_kind'] == 0) {
                    $payments[]     = Payment::select('payment_value')->where('unit_id', $unit->id)->sum('payment_value');
                } else {
                    $installments[] = Installment::select('installment_value')->where('unit_id', $unit->id)->sum('installment_value');
                }
            } elseif (!is_null($requests['request_from']) && is_null($requests['request_to'])) {
                if ($requests['cash_kind'] == 0) {
                    $payments[]     = Payment::select('payment_value')->where('unit_id', $unit->id)->wherebetween('created_at', [$requests['from'], $requests['today']])->sum('payment_value');
                } else {
                    $installments[] = Installment::select('installment_value')->where('unit_id', $unit->id)->wherebetween('created_at', [$requests['from'], $requests['today']])->sum('installment_value');
                }
            } elseif (is_null($requests['request_from']) && !is_null($requests['request_to'])) {
                if ($requests['cash_kind'] == 0) {
                    $payments[]     = Payment::select('payment_value')->where('unit_id', $unit->id)->wherebetween('created_at', [$requests['from1970'], $requests['to']])->sum('payment_value');
                } else {
                    $installments[] = Installment::select('installment_value')->where('unit_id', $unit->id)->wherebetween('created_at', [$requests['from1970'], $requests['to']])->sum('installment_value');
                }
            } elseif (!is_null($requests['request_from']) && !is_null($requests['request_to'])) {
                if ($requests['cash_kind'] == 0) {
                    $payments[]     = Payment::select('payment_value')->where('unit_id', $unit->id)->wherebetween('created_at', [$requests['from'], $requests['to']])->sum('payment_value');
                } else {
                    $installments[] = Installment::select('installment_value')->where('unit_id', $unit->id)->wherebetween('created_at', [$requests['from'], $requests['to']])->sum('installment_value');
                }
            }
        }
        if ($requests['cash_kind'] == 0) {
            return array(
                'payments'     => array_sum($payments),
                'installments' => null,
                'mainProject'  => $mainProject,
            );
        } else {
            return array(
                'payments'     => null,
                'installments' => array_sum($installments),
                'mainProject'  => $mainProject,
            );
        }
    }

    // ##### cashMain_cashFilter #####

/////////////////////////// ################ CASH FILTER ################ ///////////////////////////
/////////////////////////// ################ CASH FILTER ################ ///////////////////////////
/////////////////////////// ################ CASH FILTER ################ ///////////////////////////

/////////////////////////// --------------- STATUS FILTER --------------- ///////////////////////////
/////////////////////////// --------------- STATUS FILTER --------------- ///////////////////////////
/////////////////////////// --------------- STATUS FILTER --------------- ///////////////////////////
    // ----- statusMainEmpty_statusFilter -----
    public function statusMainEmpty_statusFilter (Request $request){
        $requests = $this->allRequests($request);
        $mainProjects = MainProject::all();
        foreach ($mainProjects as $mainProject) {
            $constructions = $mainProject->constructions;
            foreach ($constructions as $construction) {
                if (empty($requests['request_from']) && empty($requests['request_to'])) {
                    $units = Unit::orderBy('level_id', 'ASC')->where('construction_id', $construction->id)->get();
                    // foreach ($units as $unit) {
                    //     $levels[] = array('levels'=>$unit->level_id);
                    //     foreach ($levels as $level_id) {
                    //         $units = Unit::where(['construction_id'=> $construction->id, 'level_id'=>$level_id])->get();
                    //         dd($units, $levels);
                    //     }
                    // }
                } elseif (!empty($requests['request_from']) && empty($requests['request_to'])) {
                    $units = Unit::where('construction_id', $construction->id)->wherebetween('created_at', [$requests['from'], $requests['today']])->get();
                } elseif (empty($requests['request_from']) && !empty($requests['request_to'])) {
                    $units = Unit::where('construction_id', $construction->id)->wherebetween('created_at', [$requests['from1970'], $requests['to']])->get();
                } elseif (!empty($requests['request_from']) && !empty($requests['request_to'])) {
                    $units = Unit::where('construction_id', $construction->id)->wherebetween('created_at', [$requests['from'], $requests['to']])->get();
                }
                $array[] = [
                    'units'        => $units,
                    'construction' => $construction,
                    'mainProject' => $construction->mainProject,
                ];
            }
        }
        return array(
            'array'     => $array,
        );
    }
    // ##### statusMainEmpty_statusFilter #####

    // ----- statusEmpty_statuFilter -----
    public function statusEmpty_statuFilter (Request $request){
        $requests = $this->allRequests($request);
        $constructions = Construction::where('main_project_id', $requests['main_project'])->get();
        foreach ($constructions as $construction) {
            if (empty($requests['request_from']) && empty($requests['request_to'])) {
                $units = Unit::where('construction_id', $construction->id)->get();
            } elseif (!empty($requests['request_from']) && empty($requests['request_to'])) {
                $units = Unit::where('construction_id', $construction->id)->wherebetween('created_at', [$requests['from'], $requests['today']])->get();
            } elseif (empty($requests['request_from']) && !empty($requests['request_to'])) {
                $units = Unit::where('construction_id', $construction->id)->wherebetween('created_at', [$requests['from1970'], $requests['to']])->get();
            } elseif (!empty($requests['request_from']) && !empty($requests['request_to'])) {
                $units = Unit::where('construction_id', $construction->id)->wherebetween('created_at', [$requests['from'], $requests['to']])->get();
            }
            $array[] = [
                'units'        => $units,
                'construction' => $construction,
                'mainProject' => $construction->mainProject,
            ];
        }
        return array(
            'array'     => $array,
        );
    }
    // ##### statusEmpty_statuFilter #####

    // ----- mainEmpty_statusFilter -----
    public function mainEmpty_statusFilter (Request $request){
        $requests = $this->allRequests($request);
        $mainProjects = MainProject::all();
        foreach ($mainProjects as $mainProject) {
            $constructions = $mainProject->constructions;
            foreach ($constructions as $construction) {
                if (is_null($requests['request_from']) && is_null($requests['request_to'])) {
                    $units = Unit::where(['status'=> $requests['status'], 'construction_id'=>$construction->id])->get();
                } elseif (!is_null($requests['request_from']) && is_null($requests['request_to'])) {
                        $units = Unit::where(['status'=> $requests['status'], 'construction_id'=>$construction->id])->wherebetween('created_at', [$requests['from'], $requests['today']])->get();
                } elseif (is_null($requests['request_from']) && !is_null($requests['request_to'])) {
                        $units = Unit::where(['status'=> $requests['status'], 'construction_id'=>$construction->id])->wherebetween('created_at', [$requests['from1970'], $requests['to']])->get();
                } elseif (!is_null($requests['request_from']) && !is_null($requests['request_to'])) {
                    $units = Unit::where(['status'=> $requests['status'], 'construction_id'=>$construction->id])->wherebetween('created_at', [$requests['from'], $requests['to']])->get();
                }
                $array[] = [
                    'units'        => $units,
                    'construction' => $construction,
                    'mainProject' => $construction->mainProject,
                ];
            }
        }
        return array(
            'array' => $array,
        );
    }
    // ##### mainEmpty_statusFilter #####

    // ----- statusMain_statuFilter -----
    public function statusMain_statuFilter (Request $request){
        $requests = $this->allRequests($request);
        $constructions = Construction::where('main_project_id', $requests['main_project'])->get();
        foreach ($constructions as $construction) {
            if (is_null($requests['request_from']) && is_null($requests['request_to'])) {
                $units = Unit::where([['status', $requests['status']], ['construction_id', $construction->id]])->get();
            } elseif (!is_null($requests['request_from']) && is_null($requests['request_to'])) {
                $units = Unit::where([['status', $requests['status']], ['construction_id', $construction->id]])->wherebetween('created_at', [$requests['from'], $requests['today']])->get();
            } elseif (is_null($requests['request_from']) && !is_null($requests['request_to'])) {
                $units = Unit::where([['status', $requests['status']], ['construction_id', $construction->id]])->wherebetween('created_at', [$requests['from1970'], $requests['to']])->get();
            } elseif (!is_null($requests['request_from']) && !is_null($requests['request_to'])) {
                $units = Unit::where([['status', $requests['status']], ['construction_id', $construction->id]])->wherebetween('created_at', [$requests['from'], $requests['to']])->get();
            }
            $array[] = [
                'units'        => $units,
                'construction' => $construction,
                'mainProject' => $construction->mainProject,
            ];
        }
        return array(
            'array' => $array,
        );
    }
    // ##### statusMain_statuFilter #####

/////////////////////////// ################ STATUS FILTER ################ ///////////////////////////
/////////////////////////// ################ STATUS FILTER ################ ///////////////////////////
/////////////////////////// ################ STATUS FILTER ################ ///////////////////////////
}
