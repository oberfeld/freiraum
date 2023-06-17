# Freiraum

[![Project Status: Active – The project has reached a stable, usable state and is being actively developed.](https://www.repostatus.org/badges/latest/active.svg)](https://www.repostatus.org/#active)

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

## Deployment

`composer run deploy-LIVE` -> Pusht den aktuellen `main`-Branch auf den Server.

## Credits

- [Tailwind CSS](https://tailwindcss.com/)
- [Tailwind Typography](https://tailwindcss.com/docs/typography-plugin)
- [johngrogg/ics-parser](https://github.com/u01jmg3/ics-parser)
- [vlucas/phpdotenv](https://github.com/vlucas/phpdotenv)
- [Door icon by Box Icons](https://www.iconfinder.com/search/icons?family=boxicons-solid)

## License

MIT. Siehe [LICENSE.md](LICENSE.md).
