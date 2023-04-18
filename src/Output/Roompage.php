<?php

declare(strict_types=1);

namespace Oberfeld\Freiraum\Output;

use Oberfeld\Freiraum\Reservations;

class Roompage
{
    public static function showRoom(string $name, Reservations $reservations): void
    {
        echo "Raum $name, frei in " . $reservations->getMinutesUntilNextEvent() . " Minuten";

        var_dump($reservations->getNextEvents());
    }

    public static function roomNotFound(): void
    {
        echo "Bitte gültigen Raum eingeben.";
    }
}
