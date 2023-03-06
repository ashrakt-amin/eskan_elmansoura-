
<!-- Add Due Dates Modal -->
<div class="modal fade" id="addDueFinanceModal{{$unit->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">اضافة مواعيد الاستحقاق</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-body">
                        <div class="form-container">
                            <form action="{{ route('financePercentages.insert') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @foreach ($financePercentages as $financePercentage)
                                    @php
                                        $array[] = $financePercentage->payment_kind_id;
                                    @endphp
                                @endforeach
                                @if (count($financePercentages) == 0)
                                    @php

                                        $array[] = null;
                                    @endphp
                                @endif
                                @foreach ($paymentKinds as $payment_kind)
                                @if (!in_array($payment_kind->id, $array))
                                <div class="user-details">
                                    <div class="input-box" >
                                        <span class="details">الدفعة</span>
                                        <div class="select-box">
                                            <select name="payment_kind_id[]" class="form-control @error('payment_kind_id') is-invalid @enderror" value="{{ old('payment_kind_id') }}" >
                                                <option value="{{ $payment_kind->id }}">{{ $payment_kind->name }}</option>
                                            </select>

                                            @error('payment_kind_id')
                                            <span class="invalid-feedback" role="alert">
                                                <stron>{{ $message }}</stron>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="input-box" >
                                        <span class="details">النسبة</span>
                                        <input type="text" value="" class="" name="payment_kind_percentage[]" >

                                        @error('customer_id')
                                        <span class="invalid-feedback" role="alert">
                                            <stron>{{ $message }}</stron>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="input-box" >
                                        <span class="details">قيمة الدفعة</span>
                                        <input type="text" value="" class="" name="payment_kind_value[]" >

                                        @error('customer_id')
                                        <span class="invalid-feedback" role="alert">
                                            <stron>{{ $message }}</stron>
                                        </span>
                                        @enderror
                                    </div>


                                    <div class="input-box" >
                                        <span class="details">تاريخ الاستحقاق</span>
                                        <input type="date" class="datepicker" name="due_date[]" >

                                        @error('customer_id')
                                        <span class="invalid-feedback" role="alert">
                                            <stron>{{ $message }}</stron>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="input-box" >
                                        <input type="hidden" value="{{ $unit->id }}" class="" name="unit_id[]" required>
                                        <input type="hidden" value="{{ $unit->unit_price }}" class="" name="unit_price[]" required>
                                    </div>
                                </div>
                                @endif
                                @endforeach

                                <!------------------------------------- Submit ------------------------------------->
                                <div class="form-button">
                                    <input type="submit" value="اضافة">
                                </div>
                                <!--################################### Submit ###################################-->
                            </form>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="secondary table-buttons" data-dismiss="modal">الغاء</button>

                </div>
        </div>
    </div>
</div>
