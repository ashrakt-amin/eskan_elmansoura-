@extends('layouts.my_dashboard.app')

@section('content')
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

                    {{-- Start If restore payment --}}
                    {{-- Start If restore payment --}}
                    {{-- Start If restore payment --}}
<div class="card">
    @if ($payment->cancellation_code == 1)
    {{ 'restore' }}
    <div class="form-body">
        <div class="form-container">

            <div class="card-header">
                <div class="text-warning"> {{ $payment->customer->name.' '.$payment->customer->last_name }} </div>
                <div class="text-warning"> {{ $payment->unit->mainProject->name }} </div>
                <div class="text-warning"> {{ $payment->unit->construction->name }} </div>
            </div>
            <div class="title">{{ __('استرداد دفعة').' '.$payment->paymentKind->name }}</div>
            <form action="{{ route('insertUnitPayment') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="user-details">

                    <!------------------------------------- unit->name ------------------------------------->
                    <div class="input-box">
                        <span class="details">الوحدة</span>
                        <a href="{{ route('unitShow', ['id'=>$payment->unit->id]) }}"><input type="text" placeholder="Enter some data" value="{{$payment->unit->name}}" disabled></a>
                        <input type="hidden"  name="unit_id" value="{{$payment->unit->id}}" required>
                    </div>
                    <!--################################### unit->name ###################################-->

                    <!------------------------------------- unit->unit_price ------------------------------------->
                    <div class="input-box">
                        <span class="details">{{ __('اجمالي مستحقات العميل') }}</span>

                        <input type="text"
                        value="{{
                        (\App\Models\Payment::where([['unit_id', $payment->unit_id], ['customer_id', $payment->customer_id]])->sum('payment_value')) -
                        (\App\Models\Payment::where([['unit_id', $payment->unit_id], ['customer_id', $payment->customer_id]])->sum('payment_recovery'))
                        }}" disabled>
                        <input type="hidden" value="{{ $payment->unit->unit_price }}" name="unit_price">
                    </div>
                    <!--################################### unit->unit_price ###################################-->

                    <!------------------------------------- payment->payment_recovery ------------------------------------->
                    <div class="input-box">
                        <span class="details">المبلغ المسترد</span>
                        <input type="text" value=""  name="payment_recovery">
                    </div>
                    <!--################################### payment->payment_recovery ###################################-->

                    <!------------------------------------- customer ------------------------------------->

                    <!--################################### customer ###################################-->

                    <!------------------------------------- Hidden ------------------------------------->

                    <div class="input-box">
                        <label for=""> </label>
                        <input type="hidden" value="{{ $payment->customer_id}}"  name="customer_id" required>
                        <input type="hidden"  value="{{ $payment->cancellation_code }}" name="cancellation_code">
                        <input type="hidden"  value="{{ 999999999 }}" name="payment_kind_id">

                    </div>



                    <!--################################### Hidden ###################################-->

                </div>

                <!------------------------------------- Submit ------------------------------------->
                <div class="form-button">
                    <input type="submit" value="{{ __('دفع') }}">
                </div>
                <!--################################### Submit ###################################-->

            </form>
        </div>
    </div>
                {{-- End If restore payment --}}
                {{-- End If restore payment --}}
                {{-- End If restore payment --}}


                {{-- Start If update payment --}}
                {{-- Start If update payment --}}
                {{-- Start If update payment --}}
    @else
    {{'update'}}

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
            <div class="title">{{ __('تعديل دفعة ال').$payment->paymentKind->name }}</div>
            <form action="{{ route('updatePayment', ['payment'=>$payment->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="user-details">

                    <!--------------------------------- created at  --------------------------------->
                    <div class="input-box">
                        <span class="details">تاريخ الدفع</span>
                        <input type="date" name="created_at" value="">
                    </div>
                    <!--############################### updated at ###############################-->

                    <!------------------------------------- NAME ------------------------------------->
                    <div class="input-box">
                        <span class="details">قيمة الدفعة</span>
                            <input type="text" value="{{$payment->payment_value}}" name="payment_value" required>
                    </div>
                    <!--################################### NAME ###################################-->


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
</div>


                    {{-- End If update payment --}}
                    {{-- End If update payment --}}
                    {{-- End If update payment --}}

        @endif


</div>
@endsection
