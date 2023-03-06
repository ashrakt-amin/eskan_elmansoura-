@extends('layouts.my_dashboard.app')

@section('content')

<div class="card-header">
    <div><h2>{{ $main_project->name }}</h2></div>
    <h1 class="">تعديل مشروع</h1>
    <div></div>
</div>
<div class="card">
    <div class="form-body">
        <div class="form-container">
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
            <form action="{{ url('update_main_project/'.$main_project->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="user-details">
                    <div class="input-box" style="width: 100%">
                        <span class="details">اسم المشروع</span>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $main_project->name }}" >

                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <stron>{{ $message }}</stron>
                        </span>
                        @enderror
                    </div>

                    <div class="input-box" style="width: 100%">
                        <span class="details">قسم </span>
                        <div class="input-box w-100">
                            <div class="select-box">
                                <select  name="property_id" id="" class=" form-control @error('property_id') is-invalid @enderror" >
                                    @foreach ($properties as $property)
                                    <option value="{{ $property->id }}" {{ $main_project->property_id == $property->id ? 'selected' : '' }}>{{ $property->name }}</option>
                                    @endforeach
                                </select>

                                @error('property_id')
                                <span class="invalid-feedback" role="alert">
                                    <stron>{{ $message }}</stron>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <!------------------------------------- Submit ------------------------------------->
                <div class="form-button">
                    <input type="submit" value="تعديل">
                </div>
                <!--################################### Submit ###################################-->
            </form>
        </div>
    </div>
</div>

@endsection
