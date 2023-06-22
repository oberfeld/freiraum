<?php

declare(strict_types=1);

namespace Oberfeld\Freiraum\Output;

use Exception;
use Oberfeld\Freiraum\Helper\Html;

class Error
{
    public static function error(): void
    {
        Html::outputContent("<p><strong>Fehler ist aufgetreten. Bitte versuche es später nochmals.</strong>");
    }
}
