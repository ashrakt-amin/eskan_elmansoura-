@php
                        
$date = date('m-Y');
$todayMonth = date('m') - 1;
if ($todayMonth > 12) {
    $todayMonth = '01' ;
}
$year = date('y') - 20;
$years =  ($payment->installments/12) + 1 ;
$start = '00';
$months = ['01','02','03','04','05','06','07','08','09','10','11','12']
@endphp

@for ($i = $year; $i < $years+1; $i++)                     
@foreach ($months as $month)                           
    @if ($todayMonth > 11)
        @php
            $todayMonth = '00';
        @endphp
        {{++$todayMonth.'/20'.$year}}{{$i}}
    @else 
     {{++$todayMonth.'/20'.$year}}{{$i}}
    @endif
@endforeach
@endfor