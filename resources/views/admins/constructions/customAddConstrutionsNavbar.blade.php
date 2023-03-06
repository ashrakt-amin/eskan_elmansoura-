
<form action="{{ url('addConstructions') }}" method="get">

    <div class="d-flex ">

            <div class="text-center">
                <label for="">القسم</label>
                <input type="hidden" value="{{ $mainProject->property->id }}" class="form-control m-1 text-dark text-center" name="property_id" placeholder="">
                <input type="text" value="{{ $mainProject->property->name }}" class="form-control m-1 text-dark text-center" disabled style="width: 12.2rem">
            </div>
            <div class="text-center">
                <label for="">المشروع</label>
                <input type="hidden" value="{{ $mainProject->id }}" class="form-control m-1 text-dark text-center" name="main_project_id" placeholder="المشروع">
                <input type="text" value="{{ $mainProject->name }}" class="form-control m-1  text-dark text-center" disabled  style="width: 12.2rem">
            </div>
            <div class="text-center">
                <label for="">الطوابق</label>
                <input type="text" class="form-control m-1  text-dark text-center" name="levels_count" placeholder=""  style="width: 4rem">
            </div>
            <div class="text-center">
                <label for="">الوحدات بالطابق</label>
                <input type="text" class="form-control m-1  text-dark text-center" name="level_units"  style="width: 7rem">
            </div>
            <div class="text-center">
                <label for="">اجمالي الوحدات</label>
                <input type="text" class="form-control m-1  text-dark text-center" name="total_units" placeholder=" (تلقائية) "  style="width: 7rem">
            </div>
            <div class="text-center">
                <label for="">عدد الصفوف</label>
                <input type="text" class="form-control m-1  text-dark text-center" name="rows"  style="width: 7rem">
            </div>

        </div>

        <button type="submit" class="info d-block">ملء البيانات</button>

</form>
