@extends('layouts.my_dashboard.app')

@section('content')
@if (!isset($_GET['do']))
@include('admins.units.unitsTable')

@elseif ($_GET['do'] == 'addUnit')
@include('admins.units.addUnit')

@elseif ($_GET['do'] == 'allDetails')
@include('admins.allDetails')

@else
I don't have any records!
@endif

@endsection
