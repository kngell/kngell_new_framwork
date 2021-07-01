<?php
class MyDateTime
{
    public function add_business_days($startdate, $businessdays, $holidays, $dateformat)
    {
        $i = 1;
        $dayx = strtotime($startdate);

        while ($i <= $businessdays) {
            $day = date('N', $dayx);
            $date = date('Y-m-d', $dayx);
            if ($day < 6 && !in_array($date, $holidays)) {
                $i++;
            }
            $dayx = strtotime($date . ' +1 day');
        }
        return date($dateformat, strtotime(date('Y-m-d', $dayx) . ' -1 day'));
    }
}