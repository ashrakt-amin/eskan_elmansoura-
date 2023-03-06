
   @extends('layouts.my_dashboard.app')

   @section('content')


        <div class="card-header">
            <div></div>
            <h1 >اضافة مبانى</h1>
            <div></div>
        </div>
        <div class="form-body">
            <div class="form-container">
                <div class="title">اضافة مجموعة مباني</div>
                <form action="{{ url('insertMultipleConstructions') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                        @if (!$rows)
                            @php
                                $rows=2
                            @endphp
                        @endif
                        @for ($i = 0; $i < $rows; $i++)
                        @include('admins.constructions.addMultiInsertingRows')
                        @endfor
                    <div class="form-button">
                        <input type="submit" value="اضافة">
                    </div>
                </form>
            </div>
        </div>


    @endsection
