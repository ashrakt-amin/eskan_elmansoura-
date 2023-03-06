
<div class="col-lg-12">
    <a href="{{ url('addManagerFund') }}" class="mb-2 btn btn-warning text-light text-bold myText-tr">حركة مالية</a>
    <a href="{{ url('managerFundIndex') }}" class="mb-2 btn btn-primary text-light text-bold myText-tr">كل الحركات</a>
    <a href="{{ url('searchManagerFund/'.'0') }}" class="mb-2 btn btn-danger text-light text-bold myText-tr">حركات شخصية</a>
    <a href="{{ url('searchManagerFund/'.'1') }}" class="mb-2 btn btn-success text-light text-bold myText-tr">حركات المؤسسة</a>

    @include('admins.manager.fundsSearchForm')
    <table class="table table-light table-bordered">
        <thead>
        <tr>
            <th class="text-xl-center">id</th>
            <th class="text-xl-center">نوع الحركة</th>
            <th class="text-xl-center">نوع الحساب</th>
            <th class="text-xl-center">المبلغ</th>
            <th class="text-xl-center">تعليق</th>
            <th class="text-xl-center">وقت التحرير</th>
            <th class="text-xl-center">وقت التعديل</th>
            <th class="text-xl-center">امر</th>
        </tr>
        </thead>
        <tbody>
@foreach ($managerFunds as $item)

        <tr @if ($item->kind == 0 && $item->category == 0) class="text-xl-center myText-tr bg-primary bg-opacity-50" @elseif($item->kind == 1 && $item->category == 0) class="text-xl-center bg-info bg-opacity-50 myText-tr" @elseif ($item->category == 1) class="text-xl-center text-danger myText-tr" @else class="text-xl-center text-dark myText-tr" @endif>
            <th class="text-xl-center">{{ $item->id }}</th>
            <td 
            @if ($item->category == 0) class="text-xl-center text-light" @else class="text-xl-center text-dark" @endif  >
                {{ $item->kind == 0 ? 'وارد' : 'منصرف' }}
            </td>
            <td @if ($item->category == 0) class="text-xl-center text-light" @else class="text-xl-center text-dark" @endif>
                {{-- @if ($item->category == 0) class="text-xl-center text-white bg-primary" @else class="text-xl-center" @endif> --}}
                    {{ $item->category == 0 ? 'شخصي' : 'مؤسسة'  }}
            </td>
            <td 
                @if ($item->category == 0) class="text-xl-center text-light" @else class="text-xl-center text-dark" @endif >
               {{ $item->value }}
            </td>
            <td @if ($item->category == 0) class="text-xl-center text-light" @else class="text-xl-center text-dark" @endif >{{ $item->comment }}</td>
            <td @if ($item->category == 0) class="text-xl-center text-light" @else class="text-xl-center text-dark" @endif >{{ $item->created_at }}</td>
            <td @if ($item->category == 0) class="text-xl-center text-light" @else class="text-xl-center text-dark" @endif >{{ $item->updated_at }}</td>

            <td class="text-xl-center bg-light">
                <a class="btn btn-primary btn-sm d-inline-block" href="{{ url('editManagerFund/'.$item->id) }}">تعديل الحركة</a>    
            </td>

        </tr>
@endforeach
@if (isset($sumManagerFunds))
        <tr>
            <td class="myText-button" colspan="2">In = {{ $in }}</td>
            <td class="myText-button" colspan="2">Out = {{ $sumManagerFunds - $in }}</td>
            <td class="myText-button" colspan="2">Difference = {{ $sumManagerFunds }}</td>
        </tr>
@endif
@if (isset($outgoingFunds))
        <tr>
            <td class="myText-button" colspan="2">Out  =  {{ $outgoingFunds }}</td>
            <td class="myText-button" colspan="2"></td>
            <td class="myText-button" colspan="2">In  =  {{ $incomingFunds }}</td>
            <td class="myText-button" colspan="2">difference = {{ $incomingFunds - $outgoingFunds }}</td>
        </tr>
@endif        
        </tbody>
    </table>
</div>
@if (isset($outgoingFunds))
<div class="col-lg-8">
    <table class="table table-light table-bordered">
        <thead>
        <tr>
            <th scope="col" class="text-xl-center bg-danger">مصروف شخصي</th>
            <th scope="col" class="text-xl-center bg-danger">مصروف مؤسسة</th>
            <th scope="col" class="text-xl-center bg-success">دخل شخصي</th>
            <th scope="col" class="text-xl-center bg-success">دخل مؤسسة</th>
            <th class="text-xl-center bg-danger">اجمالي مصروفات</th>
            <th class="text-xl-center bg-success">اجمالي دخل</th>
            <th class="text-xl-center bg-warning text-dark">الفرق</th>
        </tr>
        </thead>
        <tbody>
            <tr>
                <td class="text-xl-center bg-primary">{{ $outgoingPersonal}}</td>
                <td class="text-xl-center">{{ $outgoingCompany}}</td>
                <td class="text-xl-center bg-primary">{{ $incomingPersonal}}</td>
                <td class="text-xl-center ">{{ $incomingCompany}}</td>
                <td class="text-xl-center bg-danger">{{ $outgoingFunds}}</td>
                <td class="text-xl-center bg-success">{{ $incomingFunds }}</td>
                <td class="text-xl-center bg-warning text-dark">{{ $incomingFunds - $outgoingFunds }}</td>
            </tr>
            <tr>
                
            </tr>
        </tbody>
    </table>
</div>

@endif 