@extends('layouts.my_dashboard.app')

@section('content')
@if (!isset($_GET['do']))
@include('admins.constructions.levelsTable')
@elseif ($_GET['do'] == 'addLevel')
@include('admins.constructions.addLevel')
@elseif ($_GET['do'] == 'editLevel')
@include('admins.constructions.editLevel')

@else
I don't have any records!

@endif

@endsection
