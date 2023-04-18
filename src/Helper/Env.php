<?php

declare(strict_types=1);

namespace Oberfeld\Freiraum\Helper;

use Dotenv\Dotenv;

/**
 * Env helper
 */
class Env
{
    protected const PREFIX_ICAL_URL = 'FREIRAUM_ICAL_URL_';
    protected const PREFIX_ROOM_NAME = 'FREIRAUM_NAME_';

    public static function get(string $key): ?string
    {
        if (!isset($_ENV[$key])) {
            $dotenv = Dotenv::createImmutable(__DIR__ . "/../../");
            $dotenv->load();
        }

        return $_ENV[$key] ?? null;
    }

    public static function getRoomIcalUrl(string $roomkey): ?string
    {
        return self::get(self::PREFIX_ICAL_URL . strtoupper($roomkey));
    }

    public static function getRoomName(string $roomkey): ?string
    {
        return self::get(self::PREFIX_ROOM_NAME . strtoupper($roomkey));
    }
}
