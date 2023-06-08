<?php

declare(strict_types=1);

namespace Oberfeld\Freiraum\Output;

use Oberfeld\Freiraum\Reservations;

class Roompage
{
    public static function showRoom(string $name, Reservations $reservations): void
    {
        echo "Raum $name, frei in den nächsten " . $reservations->getMinutesUntilNextEvent() . " Minuten";

        foreach ($reservations->getNextEvents() as $event) {
            echo "<br>";
            echo $event->summary;
            echo "<br>";
            echo $event->dtstart;
            echo "<br>";
            echo $event->dtend;
            echo "<br>";
        }
    }

    public static function roomNotFound(): void
    {
        echo "Bitte gültigen Raum in der Adresse angeben.";
    }
}
