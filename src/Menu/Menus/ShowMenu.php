<?php

namespace UselessThings\Menu\Menus;

use PhpSchool\CliMenu\CliMenu;
use PhpSchool\CliMenu\Builder\CliMenuBuilder;
use UselessThings\Menu\Menu;
use UselessThings\Items\Task;
use PhpSchool\CliMenu\Builder\SplitItemBuilder;
use UselessThings\Utils\FlashCreator;
use Symfony\Component\Yaml\Yaml;

class ShowMenu extends Menu {

  public function __construct() {
  }

  public function createWithBuilder(CliMenuBuilder $mb) {

    $callable = function (CliMenu $menu){
      $result = $menu->askText()
        ->setPromptText('To delete this task, write Y')
        ->setPlaceholderText('Y')
        ->setValidationFailedText('Please enter Y. Others will not delete.')
        ->ask();

      var_dump($result->fetch());

      if($result->fetch() == 'Y') {
        $values = Yaml::parseFile(Task::getFileSave());
        $description_ = substr($menu->getSelectedItem()->getText(), strpos($menu->getSelectedItem()->getText(), ']') + 2);

        if(isset($values['tasks'][$description_])) {
          unset($values['tasks'][$description_]);
        }

        file_put_contents(Task::getFileSave(), Yaml::dump($values));

        $menu->removeItem($menu->getSelectedItem());
        $menu->redraw();
      } else {
        FlashCreator::create($menu, 'Task not deleted.');
      }

    };

    $mb->setTitle('USELESS THINGS - SHOW');
    $value = Yaml::parseFile(Task::getFileSave());

    foreach($value['tasks'] as $description=>$priority) {
      $mb->addItem('['.$priority.'] '. $description, $callable);
    }
    $mb->addLineBreak('-');
    return $mb;
  }

}
