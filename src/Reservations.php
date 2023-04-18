<?php

declare(strict_types=1);

namespace Oberfeld\Freiraum;

use ICal\ICal;

class Reservations
{
    protected array $events = [];

    public function __construct(?string $roomIcalUrl = null)
    {
        if ($roomIcalUrl !== null) {
            $this->events = (new Ical($roomIcalUrl))->events();
        }
    }

    public function setEvents(array $events): void
    {
        $this->events = $events;
    }

    public function getMinutesUntilNextEvent(): ?int
    {
        $now = new \DateTimeImmutable();

        foreach ($this->events as $event) {
            if ($event->dtstart <= $now && $event->dtend > $now) {
                return 0;
            }

            if ($event->dtstart > $now) {
                return intval(round(($event->dtstart->getTimestamp() - $now->getTimestamp()) / 60));
            }
        }

        // No events in the foreseeable future, so return a large number
        return 60 * 24 * 365;
    }

    public function getNextEvents(int $count = 3)
    {
        $now = new \DateTimeImmutable();

        $events = [];

        foreach ($this->events as $event) {
            // Already started?
            if ($event->dtstart <= $now && $event->dtend > $now) {
                $events[] = $event;
            }

            // Starts in the future?
            if ($event->dtstart > $now) {
                $events[] = $event;
            }

            if (count($events) >= $count) {
                break;
            }
        }

        return $events;
    }
}
