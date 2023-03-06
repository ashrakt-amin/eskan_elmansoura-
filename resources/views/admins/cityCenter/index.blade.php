<div class="row">
    @foreach ($construction->units as $unit)

    <div @if ($unit->status == "تعاقد")
        class="col-12 bg-danger text-lg-center border border-primary" style="width :10rem;height :3rem"
        @elseif($unit->status == "خالية")
        class="col-12 bg-success text-lg-center border border-primary" style="width :10rem;height :3rem"
        @elseif($unit->status == "محجوزة")
        class="col-12 bg-warning text-lg-center border border-primary" style="width :10rem;height :3rem"
        @else
        class="col-12 text-lg-center border border-primary" style="width :10rem;height :3rem"
        @endif
        >
        <h5 class="">
            <a class="text-dark p-2" href="{{ url('unitShow/'.$unit->id) }}">
            {{$unit->name}}
            </a>
        </h5>


    </div>
        @endforeach
</div>