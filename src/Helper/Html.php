<?php

declare(strict_types=1);

namespace Oberfeld\Freiraum\Helper;

/**
 * HTML Helper
 * 
 * Uses template files store in resources/. This way, they
 * get picked up by the TailwindCSS JIT compiler.
 */
class Html
{
  public static function outputContent(string $content): void
  {
    require_once __DIR__ . '/../../resources/html5.php';
  }

  public static function generateTitle(string $content): string
  {
    ob_start();
    require_once __DIR__ . '/../../resources/title.php';
    return ob_get_clean();
  }

  public static function generateNextEventInfoBox(string $content, string $bgcolor): string
  {
    ob_start();
    require_once __DIR__ . '/../../resources/nextEventInfoBox.php';
    return ob_get_clean();
  }
}
