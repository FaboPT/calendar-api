<?php

namespace App\Traits;

use Carbon\Carbon;

trait Utils
{
    /**
     * Parse date to time
     * @param $time
     * @return string
     */
    public function parseTime($time): string
    {
        return Carbon::parse($time)->format('H:i:s');
    }
}
