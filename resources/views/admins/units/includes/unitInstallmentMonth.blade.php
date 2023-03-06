                    @if ($unit->installments_count == 0)
                    <div class="cards3 bordered">
                        <form action="{{ route('addFinanceIdOrInstallments', ['id'=>$unit->id]) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="d-inline-flex">
                                    <input type="text" name="installments_count" class="form-control m-1 text-center" style="width: 125px" value="">
                                    <button type="submit" class="warning table-buttons m-1">عدد الاقساط</button>
                            </div>
                        </form>
                    </div>
                    @else
                    @php
                        $residual = \App\Models\Residual::where([['unit_id', $unit->id], ['customer_id', $unit->customer_id]])->orderBy('id', 'desc')->first();
                        $firstInstallment = \App\Models\Installment::orderBy('id', 'ASC')->where([['unit_id', $unit->id], ['customer_id', $unit->customer_id]])->first();
                    @endphp
                        @if (count(\App\Models\Installment::where([['unit_id', $unit->id], ['cancellation_code', 0 ], ['customer_id', $unit->customer_id]])->get()) > 0)
                            @foreach (\App\Models\Installment::where([['unit_id', $unit->id], ['cancellation_code', 0 ], ['customer_id', $unit->customer_id]])->get() as $installment)
                                @php
                                    $months_array[] = $installment->installment_month;
                                @endphp
                            @endforeach
                            @if (in_array(date('m-Y'), $months_array))

                                <div class="cards3">
                                    <div class="text-center">
                                        <input  class="form-control mt-2 text-center" disabled value="{{ $installment->installment_value }}{{'------'}}{{'تم دفع شهر'}}{{ date('m-Y') }}">
                                    </div>
                                    <div class="text-center">
                                        <input type="text" class="form-control mt-2 text-center" value="{{ $unit->installments_count }}{{' / '}}{{ 'عدد الاقساط' }}" disabled>
                                    </div>
                                    <div class="text-center">
                                        <input type="text" class="form-control mt-2 text-center" value="{{ $installment->residual_installments }}{{' / '}}{{ 'الاقساط المتبقية' }}" disabled>
                                    </div>
                                </div>

                                <form action="{{ url('insertInstallment') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="cards3 bordered">
                                        <input type="text" name="installment_value" class="form-control text-center mt-1" value="{{ intval(($unit->unit_price - $unit->financePercentages->sum('payment_kind_value')) / $unit->installments_count) }}" placeholder="القسط">
                                        <div class="select-box d-inline-flex">
                                            <select class="form-select m-1" name="month" id="">
                                                <option value="" class="text-center">شهر</option>
                                                @php
                                                    $months = ['01','02','03','04','05','06','07','08','09','10','11','12']
                                                @endphp
                                                @foreach ($months as $month)
                                                    <option class="text-center" value="{{ $month }}">{{ $month }}</option>
                                                @endforeach
                                            </select>
                                            <select class="form-select m-1" name="year" id="">
                                                <option class="text-center" value="{{ date('Y')-2 }}">{{ date('Y')-2 }}</option>
                                                <option class="text-center" value="{{ date('Y')-1 }}">{{ date('Y')-1 }}</option>
                                                <option class="text-center" value="{{ date('Y') }}">{{ date('Y') }}</option>
                                            </select>
                                        </div>
                                        <!--------------------------------- created at  --------------------------------->
                                        <div class="input-box">
                                            <input type="date" name="created_at" value="" class="form-control date formatters mt-1">
                                            <div class="text-center">
                                                <span class="details">تاريخ الدفع</span>
                                            </div>
                                        </div>
                                        <!--############################### updated at ###############################-->
                                        <input type="hidden" name="customer_id" class="form-control" value="{{ $unit->customer_id }}">
                                        <input type="hidden" name="unit_id" class="form-control" value="{{ $unit->id }}">
                                        <div class="text-center">
                                            <button type="submit" class="warning table-buttons m-1 mt-2" >دفع شهر اخر</button>
                                        </div>
                                    </div>
                                </form>

                            @else
                            <input type="text" class="form-control mt-2 text-center" value="{{ $unit->installments_count }}{{' / '}}{{ 'عدد الاقساط' }}" disabled>

                                <form action="{{ url('insertInstallment') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="cards3 bordered">
                                        <input type="text" name="installment_value" class="form-control m-1" style="width: 125px" value="{{ $unit->installments_count }}" placeholder="القسط">
                                        <input type="text" name="installment_month" class="form-control m-1" style="width: 125px" value="{{ date('m-Y') }}">
                                        <input type="hidden" name="customer_id" class="form-control" value="{{ $unit->customer_id }}">
                                        <input type="hidden" name="unit_id" class="form-control" value="{{ $unit->id }}">
                                        <button type="submit" class="warning table-buttons m-1" style="height: 2.4rem">دفع</button>
                                    </div>
                                </form>

                                <form action="{{ url('insertInstallment') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="cards3 bordered">
                                        <input type="text" name="installment_value" class="form-control text-center mt-1" value="{{ intval(($unit->unit_price - $unit->financePercentages->sum('payment_kind_value')) / $unit->installments_count) }}" placeholder="القسط">
                                        <div class="select-box d-inline-flex">
                                            <select class="form-select m-1" name="month" id="">
                                                <option value="" class="text-center">شهر</option>
                                                @php
                                                    $months = ['01','02','03','04','05','06','07','08','09','10','11','12']
                                                @endphp
                                                @foreach ($months as $month)
                                                    <option class="text-center" value="{{ $month }}">{{ $month }}</option>
                                                @endforeach
                                            </select>
                                            <select class="form-select m-1" name="year" id="">
                                                <option class="text-center" value="{{ date('Y')-2 }}">{{ date('Y')-2 }}</option>
                                                <option class="text-center" value="{{ date('Y')-1 }}">{{ date('Y')-1 }}</option>
                                                <option class="text-center" value="{{ date('Y') }}">{{ date('Y') }}</option>
                                            </select>
                                        </div>
                                        <!--------------------------------- created at  --------------------------------->
                                        <div class="input-box">
                                            <input type="date" name="created_at" value="" class="form-control date formatters mt-1">
                                            <div class="text-center">
                                                <span class="details">تاريخ الدفع</span>
                                            </div>
                                        </div>
                                        <!--############################### updated at ###############################-->
                                        <input type="hidden" name="customer_id" class="form-control" value="{{ $unit->customer_id }}">
                                        <input type="hidden" name="unit_id" class="form-control" value="{{ $unit->id }}">
                                        <div class="text-center">
                                            <button type="submit" class="warning table-buttons m-1" style="height: 2.4rem">دفع شهر اخر</button>
                                        </div>
                                    </div>
                                </form>
                            @endif

                        @else
                        <form action="{{ route('addFinanceIdOrInstallments', ['id'=>$unit->id]) }}" method="POST">
                        @csrf
                        @method('PUT')
                            <div class="cards3 bordered">
                                <input type="text" class="form-control mt-2 text-center" value="{{ $unit->installments_count }}{{' / '}}{{ 'عدد الاقساط' }}" disabled>
                                <input type="text" name="installments_count" class="form-control mt-2 text-center" value="" placeholder="{{__('عدد الاقساط الجديد')}}">
                                <div class="text-center">
                                <button type="submit" class="warning table-buttons mt-2" style="height: 2.4rem"> {{__('تعديل')}} </button>
                                </div>
                            </div>
                        </form>

                        <form action="{{ url('insertInstallment') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                            <div class="cards3 bordered">
                                {{-- @if (!empty($firstInstallment))
                                <input type="text" name="installment_value" class="form-control text-center mt-1" value="{{ intval($firstInstallment->installment_value) }}" placeholder="القسط">
                                @else
                                @endif --}}
                                <input type="text" name="installment_value" class="form-control text-center mt-1" value="{{ intval(($unit->unit_price - $unit->financePercentages->sum('payment_kind_value')) / $unit->installments_count) }}" placeholder="القسط">
                                <input type="text" class="form-control text-center mt-1" value="{{ date('m-Y') }}" disabled>
                                <input type="hidden" name="installment_month" class="form-control text-center mt-1" value="{{ date('m-Y') }}">
                                <input type="hidden" name="customer_id" class="form-control" value="{{ $unit->customer_id }}">
                                <input type="hidden" name="unit_id" class="form-control" value="{{ $unit->id }}">
                                <div class="text-center">
                                    <button type="submit" class="warning table-buttons mt-1" style="height: 2.4rem">دفع</button>
                                </div>
                            </div>
                        </form>
                        <form action="{{ url('insertInstallment') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="cards3 bordered">
                                <input type="text" name="installment_value" class="form-control mt-1 text-center"value="{{ intval(($unit->unit_price - $unit->financePercentages->sum('payment_kind_value')) / $unit->installments_count) }}" placeholder="القسط">
                                <div class="d-inline-flex select-box">
                                    <select class="folm-select  mt-1" name="month" id="">
                                        <option value="" class="text-center">شهر</option>
                                        @php
                                            $months = ['01','02','03','04','05','06','07','08','09','10','11','12']
                                        @endphp
                                        @foreach ($months as $month)
                                            <option class="text-center" value="{{ $month }}">{{ $month }}</option>
                                        @endforeach
                                    </select>
                                    <select class="form-select ml-1 mt-1" name="year" id="" >
                                        <option class="text-center" value="{{ date('Y')-2 }}">{{ date('Y')-2 }}</option>
                                        <option class="text-center" value="{{ date('Y')-1 }}">{{ date('Y')-1 }}</option>
                                        <option class="text-center" value="{{ date('Y') }}">{{ date('Y') }}</option>
                                    </select>
                                </div>
                                <!--------------------------------- created at  --------------------------------->
                                <div class="input-box">
                                    <input type="date" name="created_at" value="" class="form-control date formatters mt-1">
                                    <div class="text-center">
                                                <span class="details">تاريخ الدفع</span>
                                            </div>
                                </div>
                                <!--############################### updated at ###############################-->
                                <input type="hidden" name="customer_id" class="form-control" value="{{ $unit->customer_id }}">
                                <input type="hidden" name="unit_id" class="form-control" value="{{ $unit->id }}">
                                <div class="text-center">
                                    <button type="submit" class="warning table-buttons m-1">دفع شهر اخر</button>
                                </div>
                            </div>
                        </form>
                        @endif
                    @endif

