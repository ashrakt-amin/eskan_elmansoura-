<div class="card-header">
    <h1 class="text-success font-italic text-center bg-dark font-weight-bold">اضافة وحدة</h1>
</div>
<div class="card-body">
    <form action="{{ url('insertUnit') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">

            <div class="col-md-6 mb-3">
                <label for="">رقم الوحدة</label>
                <input type="text" class="form-control  font-weight-bold text-dark" name="name" required>
            </div>

            <div class="col-md-6 mb-3">
                <div>
                    <label for="">القسم الرئيسي</label>
                </div>
                @foreach ( $properties as $property)
                <div class="form-check d-inline-flex">
                    <label class="form-check-label mr-3" for="exampleRadios2">
                    <input class="form-check-input mr-2" type="radio" name="property_id" id="exampleRadios2" value="{{ $property->id }}">
                        {{ $property->name }}
                    </label>
                </div>
                @endforeach
            </div>

            <div class="col-md-6 mb-3">
                <div>
                    <label for="">قسم الوحدة</label>
                </div>
                @foreach ( $subProperties as $subProperty)
                <div class="form-check d-inline-flex">
                    <label class="form-check-label mr-3" for="exampleRadios2">
                    <input class="form-check-input mr-2" type="radio" name="subProperty_id" id="exampleRadios2" value="{{ $subProperty->id }}">
                        {{ $subProperty->name }}
                    </label>
                </div>
                @endforeach
            </div>

            <div class="col-md-6 mb-3">
                <div>
                    <label for="">المشروع</label>
                </div>
                @foreach ( $main_projects as $main_project)
                <div class="form-check d-inline-flex">
                    <label class="form-check-label mr-3" for="exampleRadios2">
                    <input class="form-check-input mr-2" type="radio" name="main_project_id" id="exampleRadios2" value="{{ $main_project->id }}">
                        {{ $main_project->name }}
                    </label>
                </div>
                @endforeach
            </div>

            <div class="col-md-6 mb-3">
                <div>
                    <label for="">المنشأة</label>
                </div>
                <select class="custom-select form-control  font-weight-bold text-dark" name="construction_id" >
                    <option selected>المنشأة</option>
                    @foreach ( $constructions as $construction)
                    <option value="{{ $construction->id }}">{{ $construction->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label for="">رقم الطابق</label>
                <select class="custom-select form-control  font-weight-bold text-dark" name="level_id"  required>
                    <option selected>الطابق</option>
                    @foreach ($levels as $level)
                    <option value="{{ $level->id }}">{{ $level->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <div>
                    <label for="">الموقع</label>
                </div>
                <select class="custom-select form-control  font-weight-bold text-dark" style="width: 125px"  name="site_id" required>
                    <option selected>الموقع</option>
                    @foreach ($sites as $site)
                    <option value="{{ $site->id }}">{{ $site->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label for="">المساحة</label>
                <input type="text" class="form-control  font-weight-bold text-dark" name="space" required>
            </div>

            <div class="col-md-6 mb-3">
                <label for="">سعر المتر</label>
                <input type="text" class="form-control  font-weight-bold text-dark" name="price_m" required>
            </div>

            <div class="col-md-6 mb-3">
                <label for="">سعر الوحدة</label>
                <input type="text" class="form-control  font-weight-bold text-dark" name="unit_price" >
            </div>

            <div class="col-md-6 mb-3">
                <label for="">الوصف</label>
                <input type="text" class="form-control  font-weight-bold text-dark" name="unitDescription" >
            </div>

            <div class="col-md-6 mb-3">
                <label for="">حالة الوحدة</label>
                <select class="custom-select form-control  font-weight-bold text-dark" name="status" >
                    <option selected value="خالية">خالية</option>
                    <option value="محجوزة">محجوزة</option>
                    <option value="تعاقد">تعاقد</option>
                    <option value="ملغاة">ملغاة</option>
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label for="">العميل</label>
                <select data-show-subtext="true" data-live-search="true" class="selectpicker btn btn-primary w-100" name="customer_id" id="search-select">
                    <option selected value="0">عميل</option>
                    @foreach ( $customers as $customer)
                    <option data-subtext="{{ $customer->phone }}" value="{{ $customer->id }}">{{ $customer->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-12 mb-3">
                <button type="submit" class="btn btn-primary">اضافة</button>
            </div>
        </div>
    </form>
</div>
