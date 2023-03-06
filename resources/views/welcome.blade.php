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
    <div class="cards">
        {{-- <a class="primary" href="{{ url('index') }}">الرئيسية</a> --}}
        {{-- <a class="primary" href="{{ url('managerFundIndex') }}">Manger</a> --}}
        <a class="success" href="{{ route('propertiesIndex') }}">1---الاقسام</a>
        <a class="success" href="{{ route('main_projectsIndex') }}">2---المشاريع الرئيسية</a>
        <a class="warning" href="{{ route('subProperties.index') }}">3---الاقسام الفرعية</a>
        <a class="success" href="{{ route('levelsIndex') }}">4---الطوابق</a>
        <a class="success" href="{{ route('sites.index') }}">5---الموقع</a>
        <a class="success" href="{{ route('constructionsIndex') }}">6---المباني</a>
        <a class="warning" href="{{ route('unitsIndex') }}">7---الوحدات</a>
        <a class="success" href="{{ route('financesIndex') }}">8---انظمة السداد</a>
        <a class="success" href="{{ route('paymentKindsIndex') }}">9-(الدفعات)</a>
        <a class="warning" href="{{ route('financePercentages.index') }}">10---مواعيد الاستحقاق </a>
        <a class="warning" href="{{ route('customerIndex') }}">11--العملاء </a>
        <a class="primary" href="{{ route('paymentsIndex') }}">12--جدول المدفوعات</a>
        <a class="primary" href="{{ route('installmentsIndex') }}">13--جدول الاقساط</a>
    </div>

@endsection
