<?php

namespace UselessThings\Menu;

use PhpSchool\CliMenu\Builder\CliMenuBuilder;
use PhpSchool\CliMenu\CliMenu;

interface MenuInterface {
  public function getMenu():CliMenu;
  public function getName():string;
  public function createWithBuilder(CliMenuBuilder $mb);
}
