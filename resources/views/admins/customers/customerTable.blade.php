<div class="card-header">
    <a href="?do=addCustomer" class="primary " href="">اضافة عميل </a>
    <span><strong class="danger">{{ "(".count($customers). ")" }}</strong> <span>عدد العملاء</span></span>
</div>
<form action="{{ route('customers.search') }}" method="POST" class="d-flex">
    @csrf
    <div class="select-box">
        <select data-show-subtext="true" data-live-search="true" class="selectpicker btn btn-primary w-100" name="customer_id" id="search-select">
                <option selected value="0" class="">عميل</option>
                @foreach ( $customers as $customer)
                <option data-subtext="{{ $customer->national_id }}" value="{{ $customer->id }}" >{{ $customer->name.' '.$customer->mid_name.' '.$customer->last_name  }}</option>
                @endforeach
        </select>
    </div>
    <input type="submit" value="ذهاب" class="btn btn-primary w-25 ml-1">
</form>
<div class="card-body">
    <div class="table-responsive">
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
        <table width="100%">
            <thead>
                <tr>
                    <td></td>
                    <td>الاسم</td>
                    <td>id</td>
                    @foreach (\App\Models\MainProject::all() as $Main_project)
                        <td>{{ $Main_project->name }}</td>
                    @endforeach
                    <td>Age</td>
                    <td>Gender</td>
                    <td>Phone</td>
                    <td>Action</td>
                </tr>
            </thead>
            <tbody>
                @php
                    $id = 0;
                @endphp
                @foreach ($customers as $item)

                <tr>
                    <td>{{ ++$id }}</td>
                    <td class=""><a href="{{ url('customerShow/'.$item->id) }}"> {{ $item->name.' '.$item->mid_name.' '.$item->last_name }} </a></td>
                    <td>{{ $item->id }}</td>
                    @foreach (\App\Models\MainProject::all() as $main_project)
                    <td>{{ count(\App\Models\Unit::where([['main_project_id', $main_project->id], ['customer_id', $item->id]])->get()) }}</td>
                    @endforeach
                    <td class="">{{ $item->age }}</td>
                    <td>{{ $item->gender }}</td>
                    <td><a href="tel:{{ $item->phone }}">{{ $item->phone }}</a></td>
                    <td>
                        <a class="btn btn-primary" href="{{ url('editCustomer/'.$item->id) }}">تعديل</a>
                    </td>

                </tr>
                @endforeach
            </tbody>
            <tbody id="content">
                <tr>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
