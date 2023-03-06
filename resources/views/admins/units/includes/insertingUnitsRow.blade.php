
<!----------------------- new form ----------------------->
<!----------------------- new form ----------------------->
<!----------------------- new form ----------------------->

<div class="user-details">
    <!--------------------------------- Name -------------------------------->
    <div class="input-box">
        <span class="details">رقم الوحدة</span>
        <input type="text" name="name[]" class="form-control @error('name') is-invalid @enderror" placeholder="رقم الوحدة" value="{{ old('name') }}" >
        @error('name')
        <span class="invalid-feedback" role="alert">
            <stron>{{ $message }}</stron>
        </span>
        @enderror
    </div>
    <!--############################### Name ###############################-->

    <!----------------------------- subProperty ------------------------------->

    <div class="input-box">
        <span class="details">قسم الوحدة</span>
        @if (!$subProperty)
        <div class="select-box">
            <select class="" name="sub_property_id[]" class="form-control @error('sub_property_id') is-invalid @enderror" required>
                <option value="0" selected>قسم الوحدة</option>
                @foreach ( $subProperties as $foreachSubProperty)
                <option value="{{ $foreachSubProperty->id }}">{{ $foreachSubProperty->name }}</option>
                @endforeach
            </select>

            @error('sub_property_id')
            <span class="invalid-feedback" role="alert">
                <stron>{{ $message }}</stron>
            </span>
            @enderror
        </div>

        @else

        <div class="select-box">
            <select class="" name="sub_property_id[]" class="form-control @error('sub_property_id') is-invalid @enderror" required>
                <option value="0" selected>قسم الوحدة</option>
                @foreach ( $subProperties as $foreachSubProperty)
                <option {{ $foreachSubProperty->id == $subProperty->id ? 'selected' : '' }}   value="{{ $foreachSubProperty->id }}">{{ $foreachSubProperty->name }}</option>
                @endforeach
            </select>

            @error('sub_property_id')
            <span class="invalid-feedback" role="alert">
                <stron>{{ $message }}</stron>
            </span>
            @enderror
        </div>
        {{-- <input type="text" value="{{ $subProperty->name }}" class="@error('sub_property_id') is-invalid @enderror" placeholder="القسم" required> --}}
        {{-- <input type="hidden" name="sub_property_id[]" value="{{ $subProperty->id }}"> --}}

        @error('sub_property_id')
        <span class="invalid-feedback" role="alert">
            <stron>{{ $message }}</stron>
        </span>
        @enderror
        @endif

    </div>
    <!--############################ subProperty ############################-->

    <!-------------------------------- level --------------------------------->
    <div class="input-box">
        <span class="details">رقم الطابق</span>
        @if (!$level)
        <div class="select-box">
            <select name="level_id[]" class="form-control @error('level_id') is-invalid @enderror" required>
                <option value="0" selected>الطابق</option>
                @foreach ($allLevels as $foreachLevel)
                <option value="{{ $foreachLevel->id }}">{{ $foreachLevel->name}}</option>
                @endforeach
            </select>

            @error('level_id')
            <span class="invalid-feedback" role="alert">
                <stron>{{ $message }}</stron>
            </span>
            @enderror
        </div>
        @else
        <div class="select-box">
            <select name="level_id[]" class="form-control @error('level_id') is-invalid @enderror" required>
                <option value="0" selected>الطابق</option>
                @foreach ($allLevels as $foreachLevel)
                <option {{ $foreachLevel->id == $level->id ? 'selected' : '' }} value="{{ $foreachLevel->id }}">{{ $foreachLevel->name}}</option>
                @endforeach
            </select>

            @error('level_id')
            <span class="invalid-feedback" role="alert">
                <stron>{{ $message }}</stron>
            </span>
            @enderror
        </div>
        @endif

    </div>
    <!--############################## level ##############################-->

    <!--------------------------------- space --------------------------------->
    <div class="input-box">
        <span class="details">المساحة</span>
        <input type="text" value="{{$space }}"  class="form-control @error('space') is-invalid @enderror" name="space[]" placeholder="مساحة الوحدة" required>

        @error('space')
        <span class="invalid-feedback" role="alert">
            <stron>{{ $message }}</stron>
        </span>
        @enderror
    </div>
    <!--############################### space ###############################-->

    <!--------------------------------- Name --------------------------------->
    <div class="input-box">
        <span class="details">سعر المتر</span>
        <input type="text" value="{{ $price_m }}" name="price_m[]" class="form-control @error('price_m') is-invalid @enderror" placeholder="سعر المتر" required>

        @error('price_m')
        <span class="invalid-feedback" role="alert">
            <stron>{{ $message }}</stron>
        </span>
        @enderror
    </div>
    <!--############################### Name ###############################-->

    <!--------------------------------- Site --------------------------------->
    <div class="input-box">
        <span class="details">الموقع</span>
        @if (!$site)
        <div class="select-box">
            <select name="site_id[]" class="form-control @error('site_id') is-invalid @enderror" required>
                <option value="0" selected>الموقع</option>
                @foreach ($sites as $foreachSite)
                <option value="{{ $foreachSite->id }}">{{ $foreachSite->name }}</option>
                @endforeach
            </select>

            @error('site_id')
            <span class="invalid-feedback" role="alert">
                <stron>{{ $message }}</stron>
            </span>
            @enderror
        </div>
        @else
        <div class="select-box">
            <select name="site_id[]" class="form-control @error('site_id') is-invalid @enderror" required>
                <option value="0" selected>الموقع</option>
                @foreach ($sites as $foreachSite)
                <option value="{{ $foreachSite->id }}" {{ $foreachSite->id == $site->id ? 'selected' : '' }}>{{ $foreachSite->name }}</option>
                @endforeach
            </select>

            @error('site_id')
            <span class="invalid-feedback" role="alert">
                <stron>{{ $message }}</stron>
            </span>
            @enderror
        </div>
        @endif
    </div>

    <!--############################### Site ###############################-->

    <!--------------------------------- Property --------------------------------->
    <div class="input-box">
        {{-- <span class="details">القسم</span> --}}
        @if (!$property)
        <div class="select-box">
            <select class="" name="property_id[]" class="form-control @error('property_id') is-invalid @enderror" value="{{ old('property_id') }}" required>
                <option selected>القسم</option>
                @foreach ( $properties as $property)
                <option value="{{ $property->id }}">{{ $property->name }}</option>
                @endforeach
            </select>

            @error('property_id')
            <span class="invalid-feedback" role="alert">
                <stron>{{ $message }}</stron>
            </span>
            @enderror
        </div>
        @else
        <input type="hidden" value="{{ $property->id }}" name="property_id[]" placeholder="قسم المبنى" required>
        @endif
    </div>
    <!--############################### Property ###############################-->

    <!--------------------------------- Main Project --------------------------------->
    <div class="input-box">
        @if (!$main_project)
        <div class="select-box">
            <select class="form-control @error('main_project_id') is-invalid @enderror" name="main_project_id[]" >
                <option selected>المشروع</option>
                @foreach ( $main_projects as $main_project)
                <option value="{{ $main_project->id }}">{{ $main_project->id }}{{ $main_project->name }}</option>
                @endforeach
            </select>

            @error('main_project_id')
            <span class="invalid-feedback" role="alert">
                <stron>{{ $message }}</stron>
            </span>
            @enderror
        </div>
        @else
        <input type="hidden" value="{{ $main_project->id }}" name="main_project_id[]" placeholder="Enter some data" required>
        @endif
    </div>
    <!--############################### Main Project ###############################-->

    <!--------------------------------- Construction --------------------------------->
    <div class="input-box">
        @if (!$construction)
        <div class="select-box">
            <select class=""  name="construction_id[]" class="form-control @error('construction_id') is-invalid @enderror">
                <option selected>المنشأة</option>
                @foreach ( $constructions as $construction)
                <option value="{{ $construction->id }}">{{ $construction->name }}</option>
                @endforeach
            </select>

            @error('construction_id')
            <span class="invalid-feedback" role="alert">
                <stron>{{ $message }}</stron>
            </span>
            @enderror
        </div>
        @else
        <input type="hidden" value="{{ $construction->id }}" name="construction_id[]" placeholder="Enter some data" required>
        @endif
    </div>
    <!--############################### Construction ###############################-->

    <!--------------------------------- Status --------------------------------->
    <div class="input-box">
        <input type="hidden" value="خالية" name="status[]" placeholder="Enter some data" required>
        <input type="hidden" value="0" name="customer_id[]" placeholder="Enter some data" required>
    </div>
    <!--############################### Status ###############################-->


</div>


