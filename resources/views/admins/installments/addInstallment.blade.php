@extends('layouts.my_dashboard.app')

@section('content')

        <div class="card-header">
            <h1 class="text-success font-italic text-center bg-dark font-weight-bold"> اضافة اقساط  </h1>
        </div>
        <div class="card-body">
            <form action="{{ url('insertInstallment') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label for="">نظام الدفع</label>
                        <input type="text" disabled value="" class="form-control  font-weight-bold text-dark" name="" required>
                    </div>

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
                        <label for="">العميل </label>
                        <select data-show-subtext="true" data-live-search="true" id="search-select" class="selectpicker btn btn-primary w-100" name="customer_id" >
                            <option selected value="0">عميل</option>
                            @foreach ( $customers as $customer)
                            <option data-subtext="{{ $customer->phone }}" value="{{ $customer->id }}">{{ $customer->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="">قيمة الوحدة</label>
                        <input type="text" class="form-control  font-weight-bold text-dark" name="unit_price" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="">المتبقى</label>
                        <input type="text" class="form-control  font-weight-bold text-dark" name="residual" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="">عدد الاقساط</label>
                        <input type="text" class="form-control  font-weight-bold text-dark" name="installments" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="">قيمة القسط</label>
                        <input type="text" class="form-control  font-weight-bold text-dark" name="installment_value" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="">شهر </label>
                        <input type="text" class="form-control  font-weight-bold text-dark" name="installment_month" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="">الحالة </label>
                        <input type="text" class="form-control  font-weight-bold text-dark" name="status" required>
                    </div>

                    <div class="col-md-12 mb-3">
                        <button type="submit" class="btn btn-primary">submit</button>
                    </div>
                </div>
            </form>
        </div>

@endsection
