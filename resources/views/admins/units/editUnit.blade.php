
@extends('layouts.my_dashboard.app')

@section('content')

<!----------------------- new form ----------------------->
<!----------------------- new form ----------------------->
<!----------------------- new form ----------------------->
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
        <div class="title text-center">تعديل وحدة وحدة رقم <strong class="danger">("{{ $unit->name }}")</strong></div>
        <form action="{{ url('updateUnit/'.$unit->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="user-details">
                <!--------------------------------- Name -------------------------------->
                <div class="input-box">
                    <span class="details">رقم الوحدة</span>
                    <input type="text" name="name" placeholder="رقم الوحدة" value="{{ $unit->name }}" required>
                </div>
                <!--############################### Name ###############################-->

                <!----------------------------- subProperty ------------------------------->

                <div class="input-box">
                    <span class="details">قسم الوحدة</span>

                    <div class="select-box">
                        <select class="" name="sub_property_id" >
                            <option value="0" selected>قسم الوحدة</option>
                            @foreach ( $subProperties as $subProperty)
                            <option {{ $unit->sub_property_id == $subProperty->id ? 'selected' : '' }} value="{{ $subProperty->id }}">{{ $subProperty->name }}</option>
                            @endforeach
                        </select>
                    </div>


                </div>
                <!--############################ subProperty ############################-->

                <!-------------------------------- level --------------------------------->
                <div class="input-box">
                    <span class="details">رقم الطابق</span>

                    <div class="select-box">
                        <select name="level_id" required>
                            <option value="0" selected>الطابق</option>
                            @foreach ($levels as $foreachLevel)
                            <option {{ $foreachLevel->id == $unit->level_id ? 'selected' : '' }} value="{{ $foreachLevel->id }}">{{ $foreachLevel->name}}</option>
                            @endforeach
                        </select>
                    </div>


                </div>
                <!--############################## level ##############################-->

                <!--------------------------------- space --------------------------------->
                <div class="input-box">
                    <span class="details">المساحة</span>
                    <input type="text" value="{{ $unit->space }}" name="space" placeholder="مساحة الوحدة" required>
                </div>
                <!--############################### space ###############################-->

                <!--------------------------------- Name --------------------------------->
                <div class="input-box">
                    <span class="details">سعر المتر</span>
                    <input type="text" name="price_m" placeholder="سعر المتر" value="{{ $unit->price_m }}" required>
                </div>
                <!--############################### Name ###############################-->

                <!--------------------------------- Site --------------------------------->
                <div class="input-box">
                    <span class="details">الموقع</span>

                    <div class="select-box">
                        <select name="site_id" required>
                            <option value="0" selected>الموقع</option>
                            @foreach ($sites as $foreachSite)
                            <option value="{{ $foreachSite->id }}" {{ $foreachSite->id == $unit->site_id ? 'selected' : '' }}>{{ $foreachSite->name }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>

                <!--############################### Site ###############################-->

                <!--------------------------------- updated at  --------------------------------->
                @if ($unit->customer_id != 0)
                <div class="input-box">
                    <span class="details">تاريخ التعاقد</span>
                    <input type="date" name="created_at" placeholder="سعر المتر" value="">
                </div>
                @endif
                <!--############################### updated at ###############################-->


                <!--------------------------------------------------------------- Hidden --------------------------------------------------------------->
                <!--------------------------------------------------------------- Hidden --------------------------------------------------------------->
                <!--------------------------------------------------------------- Hidden --------------------------------------------------------------->


                <!--------------------------------- Property --------------------------------->
                <div class="input-box">

                    <input type="hidden" value="{{ $unit->property_id }}" name="property_id" placeholder="قسم المبنى" required>

                </div>
                <!--############################### Property ###############################-->

                <!--------------------------------- Main Project --------------------------------->
                <div class="input-box">

                    <input type="hidden" value="{{ $unit->main_project_id }}" name="main_project_id" placeholder="Enter some data" required>

                </div>
                <!--############################### Main Project ###############################-->

                <!--------------------------------- Construction --------------------------------->
                <div class="input-box">
                    <input type="hidden" value="{{ $unit->construction_id }}" name="construction_id" placeholder="Enter some data"required>
                </div>
                <!--############################### Construction ###############################-->

                <!--------------------------------- Status && Customer_id --------------------------------->
                <div class="input-box">
                    @if ($unit->status == 'تعاقد' || $unit->status == 'محجوزة' && $unit->customer_id != 0)
                    <input type="hidden" value="{{ $unit->customer_id }}" name="customer_id" placeholder="Enter some data" required>
                    @else
                    <input type="hidden" value="0" name="customer_id" placeholder="Enter some data" required>
                    @endif
                </div>
                <!--############################### Status ###############################-->
            </div>
            <!------------------------------------- Submit ------------------------------------->
            <div class="form-button">
                <input type="submit" value="تعديل">
            </div>
            <!--################################### Submit ###################################-->
        </form>
    </div>
</div>


@endsection
