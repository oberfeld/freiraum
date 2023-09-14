<?php

declare(strict_types=1);

namespace Oberfeld\Freiraum\Output;

use Oberfeld\Freiraum\Helper\Html;
use Oberfeld\Freiraum\Helper\Timerange;
use Oberfeld\Freiraum\Reservations;

class Roompage
{
    public static function showRoom(string $name, Reservations $reservations): void
    {
        $freeMinutes = $reservations->getMinutesUntilNextEvent();

        // Title
        $content = Html::generateTitle($name);

        // Info
        if ($freeMinutes == 0) {
            $content .= Html::generateNextEventInfoBox("Aktuell besetzt.", 'bg-rose-100');
        } else if ($freeMinutes <= 60) {
            $content .= Html::generateNextEventInfoBox("Bald belegt.", 'bg-amber-100');
        } else {
            $content .= Html::generateNextEventInfoBox(Timerange::convertMinutesToString($freeMinutes), 'bg-lime-200');
        }

        // Next events
        $content .= "<h2>Aktuelle Reservationen</h2>";
        $content .= "<table><tbody>";

        foreach ($reservations->getNextEvents() as $events) {
            $content .= "<tr>";
            $content .= "<td>" . self::formatDate($events->dtstart) . "</td>";
            $content .= "<td>" . self::formatDate($events->dtend) . "</td>";
            $content .= "<td>{$events->description}</td>";
            $content .= "<td>{$events->summary}</td>";
            $content .= "</tr>";
        }

        $content .= "</tbody></table>";

        $content .= "<p>Du willst reservieren? Den Link findest Du in der Infomappe, welche im Raum aufliegt.</p>";

        Html::outputContent($content, $name);
    }

    private static function formatDate(string $date): string
    {
        $date = new \DateTimeImmutable($date, new \DateTimeZone('Europe/Zurich'));

        // Get some date strings: Yesterday, today, tomorrow
        if($date->format('Y-m-d') == (new \DateTimeImmutable())->modify('-1 day')->format('Y-m-d')) {
            return 'Gestern, ' . $date->format('H:i');
        } else if ($date->format('Y-m-d') == (new \DateTimeImmutable())->format('Y-m-d')) {
            return 'Heute, ' . $date->format('H:i');
        } else if($date->format('Y-m-d') == (new \DateTimeImmutable())->modify('+1 day')->format('Y-m-d')) {
            return 'Morgen, ' . $date->format('H:i');
        } else {
            return $date->format('d.m. H:i');
        }
    }

    public static function roomNotFound(): void
    {
        Html::outputContent("Bitte gültigen Raum in der Adresse angeben.");
    }
}
