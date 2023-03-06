<table class="table table-light table-bordered">
    <thead>

    <tr>
        <th scope="col" class="text-xl-center">id</th>
        <th scope="col" class="text-xl-center">قيمة الوحدة</th>
        <th scope="col" class="text-xl-center"> العميل </th>
        <th scope="col" class="text-xl-center"> الوحدة </th>
        <th scope="col" class="text-xl-center">نظام الدفع</th>
        <th scope="col" class="text-xl-center">دفعة ارض</th>
        <th scope="col" class="text-xl-center">دفعة تراخيص</th>
        <th scope="col" class="text-xl-center">دفعة بدأ أعمال</th>
        <th scope="col" class="text-xl-center">دفعة تسليم</th>
        <th scope="col" class="text-xl-center"> ما تم دفعه</th>
        <th scope="col" class="text-xl-center"> المتبقى </th>
        <th scope="col" class="text-xl-center"> خصم النقدي </th>
        <th scope="col" class="text-xl-center"> قيمة النقدي </th>
        <th scope="col" class="text-xl-center">عدد الاقساط</th>
        <th scope="col" class="text-xl-center">قيمة القسط </th>
        {{-- <th scope="col" class="text-xl-center"> الحالة </th>
        <th scope="col" class="text-xl-center"> الحالة </th>
        <th scope="col" class="text-xl-center"> الحالة </th>
        <th scope="col" class="text-xl-center"> الحالة </th> --}}
        <th scope="col" class="text-xl-center">امر</th>
    </tr>
    </thead>
    <tbody>
@foreach ($payments as $item)

    <tr>
        <th scope="row" class="text-xl-center">{{ $item->id }}</th>
        <td class="text-xl-center"><a href="">{{ $item->unit_price }}</a></td>
        <td class="text-xl-center"><a href="{{ url('customerShow/'.$item->unit_id) }}"> {{ $item->customer->name }} </a></td>
        <td class="text-xl-center"><a href="{{ url('customerShow/'.$item->customer_id) }}"> {{ $item->unit->name }} </a></td>
        <td class="text-xl-center"><a href="{{ url('financesTable') }}"> {{ $item->finance->name}} </a></td>
        <td class="text-xl-center">{{ $item->space_payment }}</td>
        <td class="text-xl-center">{{ $item->licences_payment }}</td>
        <td class="text-xl-center"><a href="">{{ $item->start_payment }}</a></td>
        <td class="text-xl-center">{{ $item->recieving_payment }}</td>
        <td class="text-xl-center"><a href="">{{ $item->unit_price - $item->residual }}</a></td>
        <td class="text-xl-center"><a href="">{{ $item->residual }}</a></td>
        <td class="text-xl-center"><a href="">{{ $item->discount }}</a></td>
        <td class="text-xl-center"><a href="">{{ $item->cash_discount }}</a></td>
        <td class="text-xl-center"><a href="">{{ $item->installments }}</a></td>
        <td class="text-xl-center"><a href="">{{ $item->installment_value }}</a></td>
        {{-- <td class="text-xl-center"><a href=""> {{ $item->property_id }} </a></td>
        <td class="text-xl-center"><a href="">{{ $item->main_project_id }}</a></td>
        <td class="text-xl-center"><a href="">{{ $item->construction_id }}</a></td>
        <td class="text-xl-center"><a href="">{{ $item->level_id }}</a></td> --}}
        <td class="text-xl-center">
            <a class="btn btn-primary btn-sm" href="{{ url('editCustomer/'.$item->id) }}">تعديل نظام الدفع</a>
        </td>

    </tr>
@endforeach
    </tbody>
</table>
