<?php

namespace UselessThings\Menu\Menus;

use PhpSchool\CliMenu\CliMenu;
use PhpSchool\CliMenu\Builder\CliMenuBuilder;
use UselessThings\Menu\Menu;
use UselessThings\Items\Task;
use PhpSchool\CliMenu\Builder\SplitItemBuilder;
use UselessThings\Utils\FlashCreator;

class CreateMenu extends Menu {

  private $task;

  public function __construct() {
    $this->task = new Task();
  }

  public function createWithBuilder(CliMenuBuilder $mb) {

    //Should find way to reduce this in more beautiful way
    //May I use __invoke from class magic methods ?
    $askDescription = function (CliMenu $menu) {
      $result = $menu->askText()
                     ->setPlaceholderText('Enter description here')
                     ->ask();

      $this->task->setDescription($result->fetch());
      $menu->getSelectedItem()->setText('Description : ' . $this->task->getDescription());
      $menu->redraw();
    };

    $askPriority = function (CliMenu $menu) {
      $result = $menu->askNumber()
                     ->setPlaceholderText('Enter priority number here')
                     ->ask();

      $this->task->setPriority($result->fetch());
      $menu->getSelectedItem()->setText('Priority : ' . $this->task->getPriority());
      $menu->redraw();
    };

    $create = function (CliMenu $menu) {
      if($this->task->isValid()) {
        $text = "Tache [". $this->task->getDescription() ." (" . $this->task->getPriority() .")] added";
        $items = $menu->getItemByIndex(0)->getItems();
        $items[0]->setText('Description');
        $items[1]->setText('Priority');
        $this->task->saveAndReset();
        FlashCreator::create($menu, $text);
        $menu->redraw();
      } else {
        FlashCreator::create($menu, "Invalid task", 'red', 'white');
      }

    };

    return $mb->setTitle('USELESS THINGS - CREATE')
              ->addSplitItem(function (SplitItemBuilder $b) use ($askDescription, $askPriority){
                $b->addItem('[D]escription', $askDescription)
                  ->addItem('[P]riority', $askPriority);
              })
              ->addItem('Create', $create)
              ->addLineBreak('-');
  }

}
