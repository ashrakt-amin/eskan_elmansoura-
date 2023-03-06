@extends('layouts.my_dashboard.app')

@section('content')
@if (!isset($_GET['do']))
@include('admins.customers.customerTable')
@elseif ($_GET['do'] == 'addCustomer')
@include('admins.customers.addCustomer')
@elseif ($_GET['do'] == 'editCustomer')
@include('admins.customers.editCustomer')
@elseif ($_GET['do'] == 'allDetails')
@include('admins.allDetails')
@elseif ($_GET['do'] == 'projects')
@include('admins.constructions.constructionTable')
@else
I don't have any records!
@endif

@endsection
