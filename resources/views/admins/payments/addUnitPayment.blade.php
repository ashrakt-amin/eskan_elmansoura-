@extends('layouts.my_dashboard.app')

@section('content')

<div class="card-header">
        <a href="{{ url('unitShow/'.$unit->id) }}">{{ $unit->name.' '.__('الوحدة') }}</a>
        <h2>{{ $payment_kind->name }}</h2>
    <h3 class="text-success">{{ $unit->customers->name.' '.$unit->customers->mid_name.' '.$unit->customers->last_name }}</h3>
</div>
<div class="form-body">
    <div class="form-container">
        <div class="">
            @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
            @elseif (session('none'))
            <div class="alert alert-primary" role="alert">
                {{ session('none') }}
            </div>
            @elseif (session('warning'))
            <div class="alert alert-warning" role="alert">
                {{ session('warning') }}
            </div>
            @elseif (session('danger'))
            <div class="alert alert-danger" role="alert">
                {{ session('danger') }}
            </div>
            @endif
        </div>
        <div class="title">دفعة جديدة</div>
        <form action="{{ route('insertUnitPayment') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="user-details">

                <!------------------------------------- unit->name ------------------------------------->
                <div class="input-box">
                    <span class="details">الوحدة</span>
                    <input type="text" placeholder="Enter some data" value="{{$unit->name}}" disabled>
                    <input type="hidden"  name="unit_id" value="{{$unit->id}}" required>
                </div>
                <!--################################### unit->name ###################################-->

                <!------------------------------------- unit->unit_price ------------------------------------->
                <div class="input-box">
                    <span class="details">قيمة الوحدة</span>
                    <input type="text" value="{{ $unit->unit_price }}" disabled>
                    <input type="hidden" value="{{ $unit->unit_price }}" name="unit_price">
                </div>
                <!--################################### unit->unit_price ###################################-->

                <!--------------------------------- created at  --------------------------------->
                <div class="input-box">
                    <span class="details">تاريخ التعاقد</span>
                    <input type="date" name="created_at" value="">
                </div>
                <!--############################### updated at ###############################-->

                <!------------------------------------- customer ------------------------------------->

                <!--################################### customer ###################################-->

                <!------------------------------------- paymentKind ------------------------------------->
                <div class="input-box">
                    <span class="details">الدفعة </span>
                        <input type="text" value="{{ $payment_kind->name }}"  disabled>
                        <input type="hidden" value="{{ $payment_kind->id  }}"  name="payment_kind_id" required>
                </div>
                <!--################################### paymentKind ###################################-->

                <!------------------------------------- NAME ------------------------------------->
                <div class="input-box">
                    <span class="details">قيمة الدفعة</span>
                    
                        <input type="text" value="{{$unit->unit_price * ($payment_kind_percentage/100) }}" name="payment_value" required>
                </div>
                <!--################################### NAME ###################################-->

                <!------------------------------------- Hidden ------------------------------------->



                    @php
                        $kind = $_GET['payment_kind_id'];
                    @endphp
                @if (count($payments) > 0)
                @foreach ($payments as $payment)
                @endforeach

                @if (count($payments) == count(\App\Models\PaymentKind::all()) - 1)

                    <div class="col-md-6 mb-3">
                        <label for="">خصم نقدي </label>
                        <input type="text" class="form-control  font-weight-bold text-dark" name="discount" >
                    </div>

                @else

                    <div class="col-md-6 mb-3">
                        {{-- <label for="">عدد الاقساط</label> --}}
                        <input type="hidden" class="form-control  font-weight-bold text-dark" name="installments" >
                    </div>

                    <div class="col-md-6 mb-3">
                        {{-- <label for="">خصم نقدي </label> --}}
                        <input type="hidden" class="form-control  font-weight-bold text-dark" name="discount" >
                    </div>

                @endif
                @endif
                    <div class="input-box">
                        @if ($unit->customers->id)

                        <input type="hidden" value="{{ $unit->customers->id}}"  name="customer_id" required>
                        @else
                        <span class="details">العميل</span>
                            <div class="select-box">
                                <select data-show-subtext="true" data-live-search="true" class="selectpicker" name="customer_id" id="search-select">
                                    <option selected value="0">عميل</option>
                                    @foreach ( $customers as $customer)
                                    <option data-subtext="{{ $customer->phone }}" value="{{ $customer->id }}">{{ $customer->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                    </div>


                <!--################################### Hidden ###################################-->

            </div>

            <!------------------------------------- Submit ------------------------------------->
            <div class="form-button">
                <input type="submit" value="اضافة">
            </div>
            <!--################################### Submit ###################################-->

        </form>
    </div>
</div>
@endsection
