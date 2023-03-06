@extends('layouts.my_dashboard.app')

@section('content')
@if (!isset($_GET['do']))
@include('admins.payments.paymentKindsTable')
{{-- @elseif ($_GET['do'] == 'addPayment')
@include('admins.payments.addPayment') --}}
@else
I don't have any records!
@endif

@endsection
