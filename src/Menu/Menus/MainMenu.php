<?php

namespace UselessThings\Menu\Menus;

use PhpSchool\CliMenu\CliMenu;
use PhpSchool\CliMenu\Builder\CliMenuBuilder;
use UselessThings\Menu\Menu;
use PhpSchool\CliMenu\Style\SelectableStyle;

class MainMenu extends Menu {

  public function createWithBuilder(CliMenuBuilder $mb) {
    $itemCallable = function (CliMenuBuilder $menu) {
      echo $menu->getSelectedItem()->getText();
    };

    return $mb->setTitle('USELESS THINGS')
              ->enableAutoShortcuts()
              ->addSubMenu('[S]how tasks', function (CliMenuBuilder $showmenu) {
                $this->menuManager->getWithBuilder('Show', $showmenu);
              })
              ->addSubMenu('[C]reate Tasks', function (CliMenuBuilder $createmenu) {
                $this->menuManager->getWithBuilder('Create', $createmenu);
              })
              ->addLineBreak('-')
              ->setBackgroundColour('40')
              ->setForegroundColour('blue')
              ->setPadding(4)
              ->setMargin(4)
              ->setBorder(1, 2, '40')
              ->setTitleSeparator('=')
              ->modifySelectableStyle(function (SelectableStyle $style) {
                  $style->setUnselectedMarker(' ')
                      ->setSelectedMarker('>');
              })
              ->setWidth(80)
              ->setMarginAuto();
  }

}
