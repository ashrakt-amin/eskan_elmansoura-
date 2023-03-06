
<div class="">
    <div class="card-header">
        <a href="{{ route('constructionsIndex') }}" class="danger">اضغط على المباني لاضافة وحدة</a>
        <a href="{{ url('cancellationUnits/1') }}" class="warning">الوحدات المسترجعة</a>
        @foreach ($units->unique('main_project_id') as $unit)
        <a href="{{ route('show_main_project', ['id'=>$unit->mainProject->id]) }}" class="primary">{{ $unit->mainProject->name }}</a>
    @endforeach
    </div>
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
        @elseif (session('status'))
        <div class="alert alert-primary" role="alert">
            {{ session('status') }}
        </div>
        @endif
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table width="100%">
                <thead>
                    <tr>
                        <td>id</td>
                        <td>رقم الوحدة</td>
                        <td>قسم</td>
                        <td>المبنى</td>
                        <td>المشروع الرئيسي</td>
                        <td>الدور</td>
                        <td>سعر الوحدة</td>
                        <td> امر</td>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($units as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td><a href="{{ url('unitShow/'.$item->id) }}">{{ $item->name }}</a>
                        </td>
                        <td><a href="{{ route('subProperties.show', ['subProperty'=>$item->sub_property_id]) }}">{{ $item->subProperty->name }}</a></td>
                        <td><a href="{{ url('showConstruction/'.$item->construction->id) }}">{{ $item->construction->name }}</a></td>
                        <td><a href="{{ url('show_main_project/'.$item->main_project_id) }}">{{ $item->mainProject->name }}</a></td>
                        <td><a href="{{ route('levels.show', ['id'=>$item->level_id, 'constructionId'=>$item->construction->id]) }}">{{ $item->level->name }}</a></td>
                        <td class="text-xl-center">{{ $item->unit_price }}</td>
                        <td>
                            <a class="btn btn-primary mr-1" href="{{ url('editUnit/'.$item->id) }}">تعديل</a>
                            <!-- Button trigger modal -->
                            <a type="button" class="btn btn-danger mr-1" href="" data-toggle="modal" data-target="#exampleModal{{$item->id}}">حذف </a>
                        </td>
                        </tr>
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel"> حذف الوحدة</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p> هل تريد حذف الوحدة رقم    <strong class="danger">("{{ $item->name }}") </strong><strong>{{$item->subProperty->name}}</strong></p>
                                            <p>الموجودة ب    <strong class="danger">("{{ $item->construction->name }}") </strong><strong>{{$item->property->name}}</strong></p>
                                            <p>من مشروع   <strong class="danger">("{{ $item->mainProject->name }}")</strong></p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="secondary table-buttons" data-dismiss="modal">الغاء</button>
                                            <a class="danger table-buttons" href="{{ route('unit.destroy', ['id'=>$item->id]) }}">تاكيد الحذف</a>
                                        </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
