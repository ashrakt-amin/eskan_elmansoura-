@extends('layouts.my_dashboard.app')

@section('content')
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
        <div class="title">تعديل القسط</div>
            <form action="{{ route('updateInstallment', ['id' => $installment->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('Put')
                <div class="user-details">

                    <div class="input-box select-box">
                        <span class="details">شهر القسط</span>
                        <input type="hidden" name="installment_month" value="{{ $installment->installment_month }}">
                            <select class="form-select  mt-1" name="month" id="">
                                <option value="" class="text-center">شهر</option>
                                @php
                                    $months = ['01','02','03','04','05','06','07','08','09','10','11','12']
                                @endphp
                                @foreach ($months as $month)
                                    <option class="text-center" value="{{ $month }}">{{ $month }}</option>
                                @endforeach
                            </select>
                            <select class="form-select mt-1" name="year" id="" >
                                <option class="text-center" value="{{ date('Y')-2 }}">{{ date('Y')-2 }}</option>
                                <option class="text-center" value="{{ date('Y')-1 }}">{{ date('Y')-1 }}</option>
                                <option class="text-center" value="{{ date('Y') }}">{{ date('Y') }}</option>
                            </select>
                    </div>

                    <!--------------------------------- created at  --------------------------------->
                    <div class="input-box">
                        <span class="details">تاريخ الدفع</span>

                        <input type="hidden" name="created_at" value="{{ $installment->created_at->format('Y-m-d H:i:s') }}">
                        <input type="text" name="created_at" value="{{ $installment->created_at->format('Y-m-d H:i:sA') }}" disabled>
                        <input type="date" name="created_at" value="">
                    </div>
                    <!--############################### updated at ###############################-->

                    <div class="input-box">
                        <label for="">قيمة القسط</label>
                        <input type="text" class="form-control  font-weight-bold text-dark" name="installment_value" value="{{ $installment->installment_value }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        {{-- <label for="">الوحدة </label> --}}
                        <input type="hidden" value="{{ $installment->unit_id }}" class="form-control  font-weight-bold text-dark" name="unit_id" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        {{-- <label for="">العميل </label> --}}
                        <input type="hidden" value="{{ $installment->customer_id }}" class="form-control  font-weight-bold text-dark" name="customer_id" required>
                    </div>
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

@endsection
