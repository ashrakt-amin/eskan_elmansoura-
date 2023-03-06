@extends('layouts.my_dashboard.app')

@section('content')
@if (!isset($_GET['do']))
@include('admins.manager.managerFundsTable')


@else
I don't have any records!
@endif

@endsection
