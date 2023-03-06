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
        <a class="primary" href="{{ route('managerFundIndex') }}">1- محفظة المدير</a>
        <a class="success" href="{{ route('privileges.index') }}">2-الصلاحيات</a>
        <a class="success" href="{{ route('users.index') }}">3-المستخدمين</a>
    </div>

@endsection
