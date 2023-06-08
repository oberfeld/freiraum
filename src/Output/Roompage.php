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
        $content .= "<h2>Anstehende Reservationen</h2>";
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

        Html::outputContent($content);
    }

    private static function formatDate(string $date): string
    {
        return date('j.n. H:i', strtotime($date));
    }

    public static function roomNotFound(): void
    {
        Html::outputContent("Bitte gültigen Raum in der Adresse angeben.");
    }
}
