<div class="">



        <form action="{{ url('addUnitPayment/'.$unit->id) }}" method="get">
            <div class="cards3 bordered">
                <div class="text-center">
                    <input type="text" name="payment_kind_percentage" class="form-control mt-1 text-center" placeholder="النسبة">
                </div>
                <div class="select-box">
                    <select class="form-select mt-1" name="payment_kind_id">
                    @if (count(\App\Models\Payment::where('unit_id', $unit->id)->get()) > 0)
                        @foreach (\App\Models\PaymentKind::where([['main_project_id', $unit->main_project_id], ['code', 0]])->get() as $payment_kind)
                            @foreach (\App\Models\Payment::where([['unit_id', $unit->id], ['payment_kind_id', $payment_kind->id]])->get() as $payment)
                            @php
                                $array[] = $payment->payment_kind_id;
                            @endphp
                            @endforeach
                            {{-- {{dd($payment->payment_kind_id, $unit)}} --}}
                            {{-- @if (!in_array($payment_kind->id, $array) ) --}}
                            <option value="{{ $payment_kind->id }}" class="text-center">{{$payment_kind->name}}{{'/'}}{{$payment_kind->mainProject->name}}</option>
                            {{-- @endif --}}
                            @endforeach
                    @else
                        @foreach (\App\Models\PaymentKind::where([['main_project_id', $unit->main_project_id], ['code', 0]])->get() as $payment_kind)
                        <option value="{{ $payment_kind->id }}" class="text-center">{{$payment_kind->name}}{{'/'}}{{$payment_kind->mainProject->name}}</option>
                        @endforeach
                    @endif
                        @foreach (\App\Models\PaymentKind::where([['main_project_id', $unit->main_project_id], ['code', 1]])->get() as $payment_kind)
                        <option value="{{ $payment_kind->id }}" class="text-center">{{$payment_kind->name}}{{'/'}}{{$payment_kind->mainProject->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="text-center">
                    <button class="success table-buttons m-1" type="submit" style="height: 2.4rem">دفعة جديدة</button>
                </div>
            </div>
        </form>
</div>


