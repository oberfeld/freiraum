# Freiraum

[![Project Status: WIP – Initial development is in progress, but there has not yet been a stable, usable release suitable for the public.](https://www.repostatus.org/badges/latest/wip.svg)](https://www.repostatus.org/#wip)

Zeigt die nächsten Reservationen eines Raumes (iCal-Feed) als einfach Webseite an.

Gestaltet für die Gemeinschaftsräume der [Wohnbaugenossenschaft Oberfeld](https://wohnenimoberfeld.ch).

`LIVE`: <https://freiraum.wohnenimoberfeld.ch>

## Konzept

Beim Aufruf wird aus dem URL-Pfad das Kürzel eines Raumes gelesen. Die dazugehörige URL des iCal-Feeds und der Name des Raumes werden aus dem `.env`-File gelesen.

Die Webseite zeigt jeweils den Zustand des Raums (Frei, besetzt, demnächst besetzt) und die nächsten drei Reservationen an.

Aus Datensparsamkeit ist absichtlich kein Link zum effektiven Reservationssystem vorhanden.

Simples PHP 8. Minimalistisch. Keine Authentifizierung, keine Datenbank, keine Benutzerverwaltung.

## Entwicklung

Einmalig: `composer install`
Einmalig: `npm install`

Lokales Entwickeln: `composer run serve` -> <http://localhost:8000/RAUMNAME>

Parallel dazu: `composer run tailwind`

## Testing

`composer test`

## Credits

- [Tailwind CSS](https://tailwindcss.com/)
- [Tailwind Typography](https://tailwindcss.com/docs/typography-plugin)
- [johngrogg/ics-parser](https://github.com/u01jmg3/ics-parser)
- [vlucas/phpdotenv](https://github.com/vlucas/phpdotenv)

## License

MIT. Siehe [LICENSE.md](LICENSE.md).
