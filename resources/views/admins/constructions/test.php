@extends('layouts.my_dashboard.app')

@section('content')







<div class="projects">
    <div class="card">
        <div class="card-header">
            <h3>{{ $construction->name }}</h3>
            <button>See All <span class="las la-arrow-right"></span></button>
        </div>

        <div class="card-body">
        @include('admins.units.includes.customAddUnitNavbar')

            <div class="table-responsive">
                <table width="100%">
                    <thead>
                        <tr>
                            <td>الوحدة</td>
                            <td>القسم</td>
                            <td>الدور</td>
                            <td>العميل</td>
                            <td>الموقع</td>
                            <td>المساحة</td>
                            <td>المتر</td>
                            <td>سعر الوحدة</td>
                        </tr>
                    </thead>
                    <tbody>
                    @if (count($construction->units) > 0  )
                        @forelse ($construction->units as $unit)

                        <tr>
                            <td>{{$unit->name}}</td>
                            <td>{{$unit->subProperty->name}}</td>
                            <td>{{$unit->level->name}}</td>
                            <td>{{$unit->customers->name}}</td>
                            <td>{{$unit->site->name}}</td>
                            <td>{{$unit->space}}</td>
                            <td>{{$unit->price_m}}</td>
                            <td>{{$unit->unit_price}}</td>
                        </tr>
                        @empty

                        <tr>
                            <td>1</td>
                            <td>2</td>
                            <td><span class="status"></span> 3</td>
                        </tr>

                        @endforelse
                    @endif
                    <div class="text-lg-left">
                        <p class="card-text">.</p>
                    @foreach ($allLevels as $level)
                        <a href="{{ route('levels.show', ['id'=>$level->id, 'constructionId'=>$construction->id]) }}" class="btn btn-secondary">{{ $level->name }}</a>
                    @endforeach
                    </div>
                        <p class="card-text">.</p>
                        <a href="{{ url('searchConstruction/'.$construction->id.'/?status=خالية') }}" class="btn btn-success">وحدات خالية</a>
                        <a href="{{ url('searchConstruction/'.$construction->id.'/?status=تعاقد') }}" class="btn btn-danger">وحدات تعاقد</a>
                        <a href="{{ url('searchConstruction/'.$construction->id.'/?status=محجوزة') }}" class="btn btn-warning">وحدات محجوزة</a>
                        <a href="{{ url('searchConstruction/'.$construction->id.'/?status=ملغاة') }}" class="btn btn-outline-danger">وحدات ملغاة</a>
                        <a href="{{ url('showConstruction/'.$construction->id) }}" class="btn btn-primary">كل الوحدات</a>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
