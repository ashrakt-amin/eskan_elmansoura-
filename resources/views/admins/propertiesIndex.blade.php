@extends('layouts.my_dashboard.app')

@section('content')
@if (!isset($_GET['do']))
@include('admins.properties.propertiesTable')

@elseif ($_GET['do'] == 'addProperty')
@include('admins.properties.addProperty')

@elseif ($_GET['do'] == 'editProperty')
@include('admins.properties.editProperty')

@elseif ($_GET['do'] == 'allDetails')
@include('admins.allDetails')

@else
I don't have any records!
@endif

@endsection
