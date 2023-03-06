@extends('layouts.my_dashboard.app')

@section('content')
@if (!isset($_GET['do']))
@include('admins.installments.installmentsTable')

{{-- @elseif ($_GET['do'] == 'addInstallment')
@include('admins.installments.addInstallment') --}}

@else
I don't have any records!

@endif

@endsection
