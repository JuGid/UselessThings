<?php

namespace UselessThings\Menu\Menus;

use PhpSchool\CliMenu\CliMenu;
use PhpSchool\CliMenu\Builder\CliMenuBuilder;
use UselessThings\Menu\Menu;
use UselessThings\Items\Task;
use PhpSchool\CliMenu\Builder\SplitItemBuilder;
use UselessThings\Utils\FlashCreator;
use Symfony\Component\Yaml\Yaml;
use PhpSchool\CliMenu\MenuItem\LineBreakItem;
use PhpSchool\CliMenu\Action\ExitAction;
use PhpSchool\CliMenu\Action\GoBackAction;
use PhpSchool\CliMenu\MenuItem\SelectableItem;
use PhpSchool\CliMenu\MenuItem\StaticItem;

class ShowMenu extends Menu {

  public function createWithBuilder(CliMenuBuilder $mb) {

    $callable = function (CliMenu $menu) use ($actualise){
      $result = $menu->askText()
        ->setPromptText('To delete this task, write Y')
        ->setPlaceholderText('Y')
        ->setValidationFailedText('Please enter Y. Others will not delete.')
        ->ask();

      if($result->fetch() == 'Y') {
        $values = Yaml::parseFile(Task::getFileSave());
        $description_ = substr($menu->getSelectedItem()->getText(), strpos($menu->getSelectedItem()->getText(), ']') + 2);

        if(isset($values['tasks'][$description_])) {
          unset($values['tasks'][$description_]);
        }

        file_put_contents(Task::getFileSave(), Yaml::dump($values));

        $menu->removeItem($menu->getSelectedItem());

      } else {
        FlashCreator::create($menu, 'Task not deleted.');
      }

    };

    $actualise = function (CliMenu $menu) use($callable){
        $items = $menu->getItems();
        $itemForstyle = $items[0];
        //remove all our items except for the line break and actions
        foreach($items as $item) {
          if($item->getText() !== 'Actualise') {
            $menu->removeItem($item);
          }
        }
        $menu->addItem(new LineBreakItem('-', 1));

        $values = Yaml::parseFile(Task::getFileSave());
        if(count($values['tasks']) == 0) {
          $staticItem = new StaticItem('No tasks in manager');
          $menu->addItem($staticItem);
        }
        else {
          foreach($values['tasks'] as $description=>$priority) {
            $selectableItem = new SelectableItem('['.$priority.'] '. $description, $callable);
            $selectableItem->setStyle($itemForstyle->getStyle());
            $menu->addItem($selectableItem);
          }
        }

        $menu->addItem(new LineBreakItem('-', 1));

        $goBackButton = new SelectableItem('Go back', new GoBackAction);
        $goBackButton->setStyle($itemForstyle->getStyle());

        $exitButton = new SelectableItem('Exit', new ExitAction);
        $exitButton->setStyle($itemForstyle->getStyle());

        $menu->addItems([$goBackButton, $exitButton]);
        $menu->redraw();

    };

    $mb->setTitle('USELESS THINGS - SHOW')
       ->addItem('Actualise', $actualise)
       ->addLineBreak('-');
    $values = Yaml::parseFile(Task::getFileSave());

    if(count($values['tasks']) == 0) {
      $mb->addStaticItem('No tasks in manager.');
    } else {
      foreach($values['tasks'] as $description=>$priority) {
        $mb->addItem('['.$priority.'] '. $description, $callable);
      }
    }

    $mb->addLineBreak('-');
    return $mb;
  }

}
