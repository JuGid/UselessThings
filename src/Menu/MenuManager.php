<?php

namespace UselessThings\Menu;

use PhpSchool\CliMenu\Builder\CliMenuBuilder;

class MenuManager {

  private function verify(string $menuName) : ?string {
    $menuFullname = "UselessThings\\Menu\\Menus\\" . $menuName . 'Menu';
    if(!class_exists($menuFullname)) {
      $menuFullname = null;
      echo "The menu ".$menuName ."Menu doesn't exist. \n";
    }
    return $menuFullname;
  }

  public function get(string $menuName) {
    $verif = $this->verify($menuName);
    $menuInstanciated = null;

    if($verif!== null) {
      $menuInstanciated = (new $verif())->getMenu();
    }
    return $menuInstanciated;
  }

  public function getWithBuilder(string $menuName, CliMenuBuilder $mb) {
    $verif = $this->verify($menuName);
    $menuInstanciated = null;

    if($verif !== null) {
      $menuInstanciated = (new $verif())->createWithBuilder($mb);
    }

    return $menuInstanciated;
  }


  public function getMenu(string $menuName) {
    return $this->get($menuName);
  }

  public static function start() {
    return (new MainMenu())->getMenu();
  }
}
