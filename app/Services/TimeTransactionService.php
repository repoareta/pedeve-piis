<?php

namespace App\Services;

use DB;

class TimeTransactionService
{
    private $stringDate;

    public function __construct()
    {
        $this->stringDate = DB::table('timetrans')
            ->select(DB::raw('max(thnbln) as string_date'))
            ->where('status', 1)
            ->where(DB::raw('length(thnbln)'), 6)
            ->get()
            ->first()->string_date;
    }

    public function getCurrentYear()
    {
        return substr($this->stringDate, 0, -2);
    }

    public function getCurrentMonth()
    {
        return substr($this->stringDate, 4, 2);
    }

    public function getAllMonths()
    {
        $listOfMonths = [];

        for ($month = 1; $month <= 12; $month++) {

            $formattedMonth = strlen($month) <= 1 ? '0' . $month : (string) $month;
            $monthInString = date('F', mktime(0, 0, 0, $month, 1));

            array_push($listOfMonths, [
                'month_number' => $formattedMonth,
                'month_name' => $monthInString,
            ]);
        }

        return $listOfMonths;
    }

    public function getStringDate()
    {
        return (string) $this->stringDate;
    }

    public function getTimeTransStatus(string $stringDate)
    {
        $resultStatus = '';

        $status = DB::table('timetrans')
            ->select('status')
            ->where('thnbln', $stringDate)
            ->where('suplesi', 0)
            ->first()->status;

        switch ($status) {
            case '1':
                $resultStatus = 'gtopening';
                break;

            case '2':
                $resultStatus = 'gtstopping';
                break;
            
            case '3':
                $resultStatus = 'gtclosing';
                break;
            
            default:
                $resultStatus = 'gtnone';
                break;
        }

        return $resultStatus;
    }
}