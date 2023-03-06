@extends('layouts.my_dashboard.app')

@section('content')


        <div class="card-header">
            <h1 class="text-success font-italic text-center bg-dark font-weight-bold">اضافة قسط </h1>
        </div>
        <div class="card-body">
            <form action="{{ url('insertPayment') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label for="">الوحدة </label>
                        <select name="unit_id" id="search-select" data-show-subtext="true" data-live-search="true" class="selectpicker w-100 font-weight-bold text-dark" required>
                            <option value="">الوحدات</option>
                            @foreach ($units as $unit)
                                <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="">قيمة الوحدة</label>
                        <input type="text" value="" class="form-control  font-weight-bold text-dark" name="unit_price" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="">العميل </label>
                        <select data-show-subtext="true" data-live-search="true" class="selectpicker btn btn-primary w-100" name="customer_id" id="search-select">
                            <option selected value="0">عميل</option>
                            @foreach ( $customers as $customer)
                            <option data-subtext="{{ $customer->phone }}" value="{{ $customer->id }}">{{ $customer->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="">نظام الدفع</label>
                        <select name="finance_id" id="" class="custom-select form-control  font-weight-bold text-dark" required>
                            <option value="">نظام الدفع</option>
                            @foreach ($finances as $finance)
                                <option value="{{ $finance->id }}">{{ $finance->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="">نوع الدفعة</label>
                        <input type="text" class="form-control  font-weight-bold text-dark" name="payment_value" >
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for=""> قيمة الدفعة</label>
                        <input type="text" class="form-control  font-weight-bold text-dark" name="payment_value" >
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="">المتبقى</label>
                        <input type="text" class="form-control  font-weight-bold text-dark" name="residual" >
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="">خصم نقدي </label>
                        <input type="text" class="form-control  font-weight-bold text-dark" name="discount" >
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="">عدد الاقساط</label>
                        <input type="text" class="form-control  font-weight-bold text-dark" name="installments" >
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="">قيمة القسط</label>
                        <input type="text" class="form-control  font-weight-bold text-dark" name="installment_value" >
                    </div>

                    <div class="col-md-6 mb-3">
                            {{-- <label for="">القسم</label> --}}
                            <input class="form-check-input mr-2" type="hidden" name="property_id" id="exampleRadios2" value="1">
                    </div>

                    <div class="col-md-6 mb-3">
                            {{-- <label for="">المشروع</label> --}}
                            <input class="form-check-input mr-2" type="hidden" name="main_project_id" id="exampleRadios2" value="1">
                    </div>

                    <div class="col-md-6 mb-3">
                            {{-- <label for="">المنشأة</label> --}}
                            <input class="form-check-input mr-2" type="hidden" name="construction_id" id="exampleRadios2" value="1">
                    </div>

                    <div class="col-md-6 mb-3">
                        {{-- <label for="">رقم الطابق</label> --}}
                        <input type="hidden" class="form-control  font-weight-bold text-dark" name="level_id" value="1" required>
                    </div>


                    <div class="col-md-12 mb-3">
                        <button type="submit" class="btn btn-primary">submit</button>
                    </div>
                </div>
            </form>
        </div>


@endsection
