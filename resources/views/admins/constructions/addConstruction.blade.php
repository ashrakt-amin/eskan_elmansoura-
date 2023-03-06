@extends('layouts.my_dashboard.app')

@section('content')
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
        <div class="title">مبنا جديدا</div>
        <form action="{{ route('insertConstruction') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="user-details">
                <!-- --- Name -->
                <div class="input-box">
                    <span class="details">{{ __('اسم المبنى') }}</span>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required>

                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <stron>{{ $message }}</stron>
                    </span>
                    @enderror
                </div>
                <!-- ### Name -->
                <!-- --- Main Project -->
                <div class="input-box">
                    <span class="details">{{ __('المشروع') }}</span>
                    <div class="select-box">
                        <select class="form-control" name="main_project_id" class="form-control @error('main_project_id') is-invalid @enderror" required>
                            <option value="" selected>{{ __('المشروع') }}</option>
                            @if (count($main_projects) > 0 )
                            @foreach ( $main_projects as $main_project)
                            <option value="{{ $main_project->id }}">{{ $main_project->name }}</option>
                            @endforeach
                            @endif
                        </select>

                        @error('main_project_id')
                        <span class="invalid-feedback" role="alert">
                            <stron>{{ $message }}</stron>
                        </span>
                        @enderror
                    </div>
                </div>
                <!-- ### Main Project -->
                <!-- --- Properties -->
                <div class="input-box">
                    <span class="details">{{ __('القسم') }}</span>
                    <div class="select-box">
                        <select class="form-control" name="property_id" class="form-control @error('property_id') is-invalid @enderror" required>
                            <option value="" selected>{{ __('القسم') }}</option>
                            @if (count($properties) > 0 )
                            @foreach ( $properties as $property)
                            <option value="{{ $property->id }}">{{ $property->name }}</option>
                            @endforeach
                            @endif
                        </select>

                        @error('property_id')
                        <span class="invalid-feedback" role="alert">
                            <stron>{{ $message }}</stron>
                        </span>
                        @enderror
                    </div>
                </div>
                <!-- ### Properties -->
                <!-- --- Levels Count -->
                <div class="input-box">
                    <span class="details">{{ __('الطوابق') }}</span>
                    <input type="text" class="form-control @error('levels_count') is-invalid @enderror" name="levels_count" value="{{ old('levels_count') }}" required>

                    @error('levels_count')
                    <span class="invalid-feedback" role="alert">
                        <stron>{{ $message }}</stron>
                    </span>
                    @enderror
                </div>
                <!-- ### Levels Count -->
                <!-- --- Levels Units -->
                <div class="input-box">
                    <span class="details">{{ __('كل الوحدات') }}</span>
                    <input type="text" class="form-control @error('level_units') is-invalid @enderror" name="level_units" value="{{ old('level_units') }}" required>

                    @error('level_units')
                    <span class="invalid-feedback" role="alert">
                        <stron>{{ $message }}</stron>
                    </span>
                    @enderror
                </div>
                <!-- ### Levels Units -->
                <!-- --- Total Units -->
                <div class="input-box">
                    <span class="details">{{ __('الوحدات بالطابق') }}</span>
                    <input type="text" class="form-control @error('total_units') is-invalid @enderror" name="total_units" value="{{ old('total_units') }}" placeholder="ستضاف تلقائيا اذا تركت فارغة">

                    @error('total_units')
                    <span class="invalid-feedback" role="alert">
                        <stron>{{ $message }}</stron>
                    </span>
                    @enderror
                </div>
                <!-- ### Total Units -->
                <!-- --- Total Units -->
                <div class="input-box">
                    <span class="details">{{ __('التكلفة الكلية') }}</span>
                    <input type="text" class="form-control @error('coast') is-invalid @enderror" name="coast" value="{{ old('coast') }}">

                    @error('coast')
                    <span class="invalid-feedback" role="alert">
                        <stron>{{ $message }}</stron>
                    </span>
                    @enderror
                </div>
                <!-- ### Total Units -->
                <!-- --- Image  -->
                <div class="input-box">
                    <span class="details">{{ __('صورة المبنى') }}</span>
                    <input type="file" class="form-control @error('image') is-invalid @enderror" name="image" value="{{ old('image') }}">

                    @error('image')
                    <span class="invalid-feedback" role="alert">
                        <stron>{{ $message }}</stron>
                    </span>
                    @enderror
                </div>
                <!-- ### Image -->
            </div>
            <!------------------------------------- Submit ------------------------------------->
            <div class="form-button">
                <input type="submit" value="اضافة">
            </div>
            <!--################################### Submit ###################################-->
        </form>
    </div>
</div>
@endsection
