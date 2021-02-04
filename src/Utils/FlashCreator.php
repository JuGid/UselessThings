<?php

namespace UselessThings\Utils;

use PhpSchool\CliMenu\CliMenu;

class FlashCreator {

  public static function create(CliMenu $menu, string $text, string $bg = 'black', string $fg = 'white') {
    $flash = $menu->flash($text);
    $flash->getStyle()->setBg($bg);
    $flash->getStyle()->setFg($fg);
    $flash->display();
  }
}
