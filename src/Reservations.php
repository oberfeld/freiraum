<?php

declare(strict_types=1);

namespace Oberfeld\Freiraum;

use ICal\ICal;

class Reservations
{
    protected array $events = [];
    protected \DateTimezone $timezone;

    public function __construct(?string $roomIcalUrl = null)
    {
        if ($roomIcalUrl !== null) {
            $this->events = (new Ical($roomIcalUrl))->events();
        }

        $this->timezone = new \DateTimezone('Europe/Zurich');
    }

    public function setEvents(array $events): void
    {
        $this->events = $events;
    }

    public function getMinutesUntilNextEvent(): ?int
    {
        $now = new \DateTimeImmutable();

        foreach ($this->events as $event) {
            $start = new \DateTimeImmutable($event->dtstart, $this->timezone);
            $end = new \DateTimeImmutable($event->dtend, $this->timezone);

            if ($start <= $now && $end > $now) {
                return 0;
            }

            if ($start > $now) {
                return intval(round(($start->getTimestamp() - $now->getTimestamp()) / 60));
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
            $start = new \DateTimeImmutable($event->dtstart, $this->timezone);
            $end = new \DateTimeImmutable($event->dtend, $this->timezone);

            // Already started?
            if ($start <= $now && $end > $now) {
                $events[] = $event;
            }

            // Starts in the future?
            if ($start > $now) {
                $events[] = $event;
            }

            if (count($events) >= $count) {
                break;
            }
        }

        return $events;
    }
}
