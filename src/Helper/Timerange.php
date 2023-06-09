<?php

declare(strict_types=1);

namespace Oberfeld\Freiraum\Helper;

/**
 * Timerange helper
 */
class Timerange
{
    public static function convertMinutesToString(int $minutes): string
    {
        if ($minutes < 60) {
            return "Frei in den nächsten {$minutes} Minuten.";
        }

        if ($minutes < 60 * 12) {
            return "Frei in den nächsten " . floor($minutes / 60) . " Stunden.";
        }

        return "Frei in der nächsten Zeit.";
    }
}
