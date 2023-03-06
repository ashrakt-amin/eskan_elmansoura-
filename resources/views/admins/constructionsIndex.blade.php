@extends('layouts.my_dashboard.app')

@section('content')
@if (!isset($_GET['do']))
@include('admins.constructions.constructionTable')

@elseif ($_GET['do'] == 'addConstruction')
@include('admins.constructions.addConstruction')

@elseif ($_GET['do'] == 'editConstruction')
@include('admins.constructions.editConstruction')

@else
I don't have any records!
@endif

@endsection
