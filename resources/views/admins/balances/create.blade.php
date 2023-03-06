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
            <div class="title">تحديث صافي الدخل</div>
            <form action="{{ route('balances.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="user-details">
                    <div class="input-box" style="width: 100%">
                        <span class="details">{{ __('الحساب المبدئي') }}</span>
                        <input type="text" class="form-control @error('starting_balance') is-invalid @enderror" name="starting_balance"
                        value=" @if (!empty($balance)) {{ $balance->starting_balance }} @else {{ $units->sum('unit_price') }} @endif  ">

                        @error('starting_balance')
                        <span class="invalid-feedback" role="alert">
                            <stron>{{ $message }}</stron>
                        </span>
                        @enderror
                    </div>
                    <div class="input-box" style="width: 100%">
                        <span class="details">{{ __('الحساب المتوقع') }}</span>

                        <input type="text" class="form-control @error('excepted_balance') is-invalid @enderror" name="excepted_balance"
                        value=" @if (!empty($balance)) {{ $balance->excepted_balance }} @else {{ 0 }} @endif ">

                        @error('excepted_balance')
                        <span class="invalid-feedback" role="alert">
                            <stron>{{ $message }}</stron>
                        </span>
                        @enderror
                    </div>
                    <div class="input-box" style="width: 100%">
                        <span class="details">{{ __('الحساب الحالي') }}</span>
                        <input type="text" class="form-control @error('current_balance') is-invalid @enderror" name="current_balance"
                        value="{{ $units->sum('unit_price') }}">

                        @error('current_balance')
                        <span class="invalid-feedback" role="alert">
                            <stron>{{ $message }}</stron>
                        </span>
                        @enderror
                    </div>
                    <div class="input-box" style="width: 100%">
                        <span class="details">{{ __('حساب ما تم بيعه') }}</span>
                        <input type="text" class="form-control @error('actual_balance') is-invalid @enderror" name="actual_balance"
                        value="{{ $payments + $installments }}">

                        @error('actual_balance')
                        <span class="invalid-feedback" role="alert">
                            <stron>{{ $message }}</stron>
                        </span>
                        @enderror
                    </div>
                    <div class="input-box" style="width: 100%">
                        <span class="details">{{ __('ترتيب التحديث') }}</span>
                        <input type="text" class="form-control @error('balance_code') is-invalid @enderror" name="balance_code" value="{{ $balance_code + 1 }}">

                        @error('balance_code')
                        <span class="invalid-feedback" role="alert">
                            <stron>{{ $message }}</stron>
                        </span>
                        @enderror
                    </div>
                    <div class="input-box" style="width: 100%">
                        <span class="details">{{ __('المشروع') }}</span>
                        <input type="text" class="form-control @error('main_project_id') is-invalid @enderror"  value="{{ $mainProject->name }}">
                        <input type="hidden" class="form-control @error('main_project_id') is-invalid @enderror" name="main_project_id" value="{{ $mainProject->id }}">

                        @error('main_project_id')
                        <span class="invalid-feedback" role="alert">
                            <stron>{{ $message }}</stron>
                        </span>
                        @enderror
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
@endsection
