<?php

use Illuminate\Support\Carbon;
use App\Http\Controllers\smsmasking;

function datesInput($date){
    $d =  Carbon::createFromFormat('d/m/Y H:i', $date);
    return Carbon::parse($d)->format('Y-m-d H:i:s');
}

function datesOuput($date)
{
    return Carbon::parse($date)->format('d/m/Y H:i');
}

function datesOrder($date){
    return 'TR-' . Carbon::parse($date)->format('YmdHis');
}
