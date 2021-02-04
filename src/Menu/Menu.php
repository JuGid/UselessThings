<?php

namespace UselessThings\Menu;

use PhpSchool\CliMenu\CliMenu;
use PhpSchool\CliMenu\Builder\CliMenuBuilder;

abstract class Menu implements MenuInterface {

  protected $menu;
  protected $menuManager;

  public function __construct() {
    $this->menuManager = new MenuManager();
  }

  public function open() {
    $this->menu->open();
  }

  public function getName():string {
    return (new \ReflectionClass($this))->getShortName();
  }

  public function getMenu() : CliMenu{
    $this->menu = $this->createWithBuilder(new CliMenuBuilder())->build();

    return $this->menu;
  }

}
