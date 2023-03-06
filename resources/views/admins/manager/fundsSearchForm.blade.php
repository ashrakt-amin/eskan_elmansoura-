<form method="GET" action="{{ url('searchByAll/') }}" class="d-inline-flex" enctype="multipart/form-data">
    @csrf
    <div class="input-group date" id="datepicker">

        <input  type="date" class="form-control m-1" id="date" type="date" name="day_from" style="width: 200px" placeholder="From date">

        <input  type="date" class="form-control m-1" id="date" type="date" name="day_to" style="width: 200px" placeholder="To date">

        <input  type="date" class="form-control m-1" id="date" type="date" name="one_day" style="width: 200px" placeholder="Single Day">

        <select  name="category" id="" class="custom-select form-control m-1 font-weight-bold text-dark" style="width: 125px">
            <option value="">فئة</option>
            <option value="0">شخصية</option>
            <option value="1">مؤسسة</option>
        </select>

        <select  name="kind" id="" class="custom-select form-control m-1 font-weight-bold text-dark" style="width: 125px">
            <option value="">نوع</option>
            <option value="0">وارد</option>
            <option value="1">منصرف</option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary m-1">Search</button>
</form>
