<?php

/**
 * Main routing script
 * 
 * Identify the room and render the room page.
 */
require_once __DIR__ . '/../vendor/autoload.php';

$room = trim($_SERVER['REQUEST_URI'], '/');

$roomName = \Oberfeld\Freiraum\Helper\Env::getRoomName($room);
$roomIcalUrl = \Oberfeld\Freiraum\Helper\Env::getRoomIcalUrl($room);

if ($roomName === null || $roomIcalUrl === null) {
    \Oberfeld\Freiraum\Output\Roompage::roomNotFound();
} else {
    $reservations = new \Oberfeld\Freiraum\Reservations($roomIcalUrl);
    \Oberfeld\Freiraum\Output\Roompage::showRoom($roomName, $reservations);
}
