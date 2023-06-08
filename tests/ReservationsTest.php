<?php

declare(strict_types=1);

use ICal\Event;
use PHPUnit\Framework\TestCase;

final class ReservationsTest extends TestCase
{
    private const DATE_TIME_FORMAT = 'Ymd\THis';
    private const FAR_IN_THE_FUTURE = 60 * 24 * 365;

    public function testGetMinutesUntilNextEvent(): void
    {
        $reservations = new \Oberfeld\Freiraum\Reservations();

        // No events
        $this->assertEquals(self::FAR_IN_THE_FUTURE, $reservations->getMinutesUntilNextEvent());

        // One event in the past
        $reservations->setEvents([
            $this->createEvent(-60, -30),
        ]);

        $this->assertEquals(self::FAR_IN_THE_FUTURE, $reservations->getMinutesUntilNextEvent());

        // Event happening right now
        $reservations->setEvents([
            $this->createEvent(-30, 30),
        ]);

        $this->assertEquals(0, $reservations->getMinutesUntilNextEvent());

        // Multiple events, one happening right now
        $reservations->setEvents([
            $this->createEvent(-60, -30),
            $this->createEvent(-30, 30),
            $this->createEvent(30, 60),
        ]);

        $this->assertEquals(0, $reservations->getMinutesUntilNextEvent());

        // Future events
        $reservations->setEvents([
            $this->createEvent(-60, -90),
            $this->createEvent(300, 60),
            $this->createEvent(600, 90),
            $this->createEvent(900, 120),
        ]);

        $this->assertEquals(5, $reservations->getMinutesUntilNextEvent());
    }

    public function testGetNextEvents(): void
    {
        $reservations = new \Oberfeld\Freiraum\Reservations();

        // No events
        $events = $reservations->getNextEvents();

        $this->assertEmpty($events);

        // Only past events
        $reservations->setEvents([
            $this->createEvent(-60, -30),
            $this->createEvent(-30, -1),
        ]);

        $events = $reservations->getNextEvents();

        $this->assertEmpty($events);

        // One event happening right now
        $reservations->setEvents([
            $this->createEvent(-60, -30, 'past'),
            $this->createEvent(-30, 30, 'now'),
            $this->createEvent(30, 60, 'future'),
        ]);

        $events = $reservations->getNextEvents();

        $this->assertCount(2, $events);
        $this->assertEquals('now', $events[0]->summary);
        $this->assertEquals('future', $events[1]->summary);

        // More events than you can count
        $reservations->setEvents([
            $this->createEvent(-60, -30, 'past'),
            $this->createEvent(30, 60, 'future'),
            $this->createEvent(90, 120, 'future2'),
            $this->createEvent(150, 180, 'future3'),
            $this->createEvent(210, 240, 'future4'),
        ]);

        $events = $reservations->getNextEvents();

        $this->assertCount(3, $events); // Defaults to 3
        $this->assertEquals('future', $events[0]->summary);
        $this->assertEquals('future2', $events[1]->summary);
        $this->assertEquals('future3', $events[2]->summary);

        $events = $reservations->getNextEvents(5);

        $this->assertCount(4, $events);
        $this->assertEquals('future', $events[0]->summary);
        $this->assertEquals('future2', $events[1]->summary);
        $this->assertEquals('future3', $events[2]->summary);
        $this->assertEquals('future4', $events[3]->summary);
    }

    private function createEvent($startTimestampRelative, $endTimestampRelative, $summary = 'n/a'): Event
    {
        $startTimestamp = time() + $startTimestampRelative;
        $endTimestamp = time() + $endTimestampRelative;

        $event = new Event();
        $event->dtstart = date(self::DATE_TIME_FORMAT, $startTimestamp);
        $event->dtend = date(self::DATE_TIME_FORMAT, $endTimestamp);
        $event->summary = $summary;

        return $event;
    }
}
