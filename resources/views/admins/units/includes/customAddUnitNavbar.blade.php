
<form action="{{ url('createUnitCustom') }}" method="get">
    <div class="card-header">
        <div class="row">
            <div class="m-1">
                <input type="text" value="{{ $construction->property->name }}" disabled class="text-center">
                <input type="hidden" value="{{ $construction->property_id }}"  name="property_id">
            </div>
                <div class="m-1">
                    <input type="text" value="{{ $construction->mainProject->name }}"  disabled class="text-center">
                    <input type="hidden" value="{{ $construction->main_project_id }}" name="main_project_id">
            </div>
            <div class="m-1">
                <input type="text" value="{{ $construction->name }}"  disabled class="text-center">
                <input type="hidden" value="{{ $construction->id }}" name="construction_id">
            </div>


            <div class="m-1">
                <select name="sub_property_id" class="text-center">
                    <option value="0" selected>قسم</option>
                    @foreach ($subProperties as $subProperty)
                    <option value="{{ $subProperty->id }}">{{ $subProperty->name }}</option>
                    @endforeach
                </select>
                <select name="level_id" required class="text-center">
                    <option value="0" selected>الطابق</option>
                    @foreach ($allLevels as $level)
                    <option value="{{ $level->id }}">{{ $level->name }}</option>
                    @endforeach
                </select>
                <select name="site_id" required class="text-center">
                    <option value="0" selected>الموقع</option>
                    @foreach ($sites as $site)
                    <option value="{{ $site->id }}">{{ $site->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="m-1">
                <input type="text" name="space" placeholder="المساحة"  class="text-center">
            </div>
            <div class="m-1">
                <input type="text" name="price_m" placeholder="سعر المتر" class="text-center">
            </div>
            <div class="m-1">
                <input type="text" name="rows" placeholder="عدد الصفوف " class="text-center">
            </div>



        </div>
    </div>
    <div class="card-header">
        <button type="submit" class="info table-buttons">اضافة وحدات</button>
    </div>
</form>
