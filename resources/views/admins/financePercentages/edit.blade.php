@extends('layouts.my_dashboard.app')

@section('content')

<div class="form-body">
    <div class="form-container">
        <form action="{{ route('financePercentages/update', ['id'=>$finance_percentage->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="user-details">

                <div class="input-box" >
                    <span class="details">الدفعة</span>
                    <div class="select-box">
                        <select class="" name="payment_kind_id" class="form-control @error('payment_kind_id') is-invalid @enderror" value="{{ $finance_percentage->unit->name }}" >
                            <option value="{{ $finance_percentage->payment_kind_id }}">{{ $finance_percentage->paymentKind->name }}</option>
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
                    <input type="text" value="{{ $finance_percentage->payment_kind_percentage }}" class="" name="payment_kind_percentage" >

                    @error('customer_id')
                    <span class="invalid-feedback" role="alert">
                        <stron>{{ $message }}</stron>
                    </span>
                    @enderror
                </div>

                <div class="input-box" >
                    <span class="details">قيمة الدفعة</span>
                    <input type="text" value="{{ $finance_percentage->payment_kind_value }}" class="" name="payment_kind_value" >

                    @error('customer_id')
                    <span class="invalid-feedback" role="alert">
                        <stron>{{ $message }}</stron>
                    </span>
                    @enderror
                </div>


                <div class="input-box" >
                    <span class="details">تاريخ الاستحقاق</span>
                    <input type="date" name="due_date" placeholder="{{ $finance_percentage->due_date }}">


                    @if ($finance_percentage->due_date)
                    <input type="text" value="{{ $finance_percentage->due_date }}" disabled>
                    <input type="hidden" value="{{ $finance_percentage->due_date }}" name="finance_percentage_due_date">
                    @endif


                    @error('customer_id')
                    <span class="invalid-feedback" role="alert">
                        <stron>{{ $message }}</stron>
                    </span>
                    @enderror
                </div>

                <div class="input-box" >
                    <input type="hidden" value="{{ $unit->id }}" class="" name="unit_id" required>
                    <input type="hidden" value="{{ $unit->unit_price }}" class="" name="unit_price" required>
                </div>
            </div>

            <!------------------------------------- Submit ------------------------------------->
            <div class="form-button">
                <input type="submit" value="تعديل">
            </div>
            <!--################################### Submit ###################################-->
        </form>
    </div>
</div>

@endsection
