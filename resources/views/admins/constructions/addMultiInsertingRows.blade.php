
<!----------------------- new form ----------------------->
<!----------------------- new form ----------------------->
<!----------------------- new form ----------------------->

<div class="user-details">
    <!--------------------------------- Name -------------------------------->
    <div class="input-box">
        <span class="details">اسم المنشأة</span>
        <input type="text" name="name[]" placeholder="Name" value="" style="width: 100%" required>
    </div>
    <!--############################### Name ###############################-->

    <!--------------------------------- Name --------------------------------->
    <div class="input-box">
        <span class="details">عدد الطوابق</span>
        <input type="text" value="{{ $levels }}" name="levels_count[]" placeholder="Enter some data" required>
    </div>
    <!--############################### Name ###############################-->

    <!--------------------------------- Name --------------------------------->
    <div class="input-box">
        <span class="details">وحداته</span>
        <input type="text" value="{{ $level_units }}" name="level_units[]" placeholder="Enter some data" required>
    </div>
    <!--############################### Name ###############################-->

    <!--------------------------------- Site --------------------------------->
    <div class="input-box">
        <span class="details">كل الوحدات</span>
        <input type="text" value="{{ $levels *  $level_units }}" name="total_units[]" placeholder="Enter some data">
    </div>
    <!--############################### Site ###############################-->

    <!--------------------------------- Property --------------------------------->
    <div class="input-box">
        <span class="details">القسم</span>
        @if ($property)
        <div class="select-box">
            <select name="property_id[]">
                <option selected>القسم</option>
                @foreach ( $properties as $foreachProperty)
                <option {{ $foreachProperty->id == $property->id ? 'selected' : '' }} value="{{ $foreachProperty->id }}">{{ $foreachProperty->name }}</option>
                @endforeach
            </select>
        </div>
        @else
        <input type="text" value="{{ $property->name }}" placeholder="Enter some data">
        <input type="hidden" value="{{ $property->id }}" name="property_id[]" placeholder="Enter some data" required>
        @endif
    </div>
    <!--############################### Property ###############################-->

    <!--------------------------------- Main Project --------------------------------->
    <div class="input-box">
        <span class="details">المشروع</span>
        @if (!$main_project)
        <div class="select-box">
            <select class="" name="main_project_id[]" >
                <option selected>المشروع</option>
                @foreach ( $main_projects as $main_project)
                <option value="{{ $main_project->id }}">{{ $main_project->name }}</option>
                @endforeach
            </select>
        </div>
        @else
        <input type="text" value="{{ $main_project->name }}" placeholder="Enter some data">
        <input type="hidden" value="{{ $main_project->id }}" name="main_project_id[]" placeholder="Enter some data" required>
        @endif
    </div>
    <!--############################### Main Project ###############################-->

    <!--------------------------------- Construction --------------------------------->
    <div class="input-box">
        {{-- <span class="details">القيمة</span> --}}
        <input type="hidden" value="" name="coast[]" placeholder="Enter some data">
    </div>
    <!--############################### Construction ###############################-->

    <!--------------------------------- Name --------------------------------->
    <div class="input-box">
        <span class="details">صورة</span>
        <input type="file" name="image[]" placeholder="Enter img">
    </div>
    <!--############################### Name ###############################-->

</div>
