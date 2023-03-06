<div class="card-header">
    <a href="{{ route('add_main_project') }}" class="primary">اضافة مشروع جديدة</a>
</div>
<div class="card-body">
    <div class="table-responsive">
        <table width="100%">
            <thead>
                <tr>
                    <td>Id</td>
                    <td>المشروع</td>
                    <td>القسم</td>
                    <td>اقسام مباني المشروع</td>
                    <td>امر</td>
                </tr>
            </thead>
            <tbody>
                @forelse ($main_projects as $mainProject)

                <tr>
                    <td>{{ $mainProject->id }}</td>
                    <td><a href="{{ route('show_main_project',['id'=>$mainProject->id]) }}">{{$mainProject->name}}</a></td>
                    <td><a href="{{ url('showProperties/'.$mainProject->property->id) }}">{{ $mainProject->property->name }}</a></td>
                    <td class="d-flex card">
                        <div class="recent-gride">
                            @forelse ($mainProject->constructions->unique('property_id') as $construction_property)
                            <a href="{{ route('searchProperties', ['id'=>$construction_property->property_id, 'main_project'=>$construction_property->main_project_id]) }}" class="btn btn-outline-success m-1">{{ $construction_property->property->name }}</a>
                            @empty
                            <a>لا يوحد وحدات</a>
                            @endforelse
                        </div>
                    </td>
                    <td>
                        <div class="d-flex">
                        <a class="table-buttons btn btn-primary" href="{{ url('edit_main_project/'.$mainProject->id) }}">تعديل  </a>
                        <!-- Button trigger modal -->
                        <a class="table-buttons btn btn-danger" href="" data-toggle="modal" data-target="{{'#exampleModal'.$mainProject->id}}">حذف </a>
                    </div>
                    </td>
                </tr>
                <!-- Modal -->
                <div class="modal fade" id="{{'exampleModal'.$mainProject->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel"> حذف القسم</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>هل تريد حذف     <span>{{ $mainProject->name }}</span></p>
                            </div>
                            <div class="modal-footer">
                                {{-- <button type="button" class="secondary table-buttons" data-dismiss="modal">الغاء</button> --}}
                                <a class="danger table-buttons" href="{{ route('mainProject.delete', ['id'=>$mainProject->id]) }}">تاكيد الحذف</a>
                            </div>
                        </div>
                    </div>
                </div>
                @empty

                <tr>
                    <td>1</td>
                    <td>2</td>
                    <td><span class="status"></span> 3</td>
                </tr>

                @endforelse
            </tbody>
        </table>
    </div>
</div>

