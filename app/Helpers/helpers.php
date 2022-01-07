<?php

use App\Models\Transaction;
use Illuminate\Support\Facades\DB;


    function convertDate($value){
        return date('d M Y - H:i:s', strtotime($value));
    }

    function notifications()
    {
    $notifications = Transaction::with('member')->select('transactions.*', DB::raw('DATEDIFF(transactions.date_end, CURRENT_DATE) as telat'))->where('status', 0)->get();

    return $notifications;
    }
?>