<?php

namespace UselessThings\Commands;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\Command;
use UselessThings\Menu\MenuManager;
use PhpSchool\CliMenu\Builder\CliMenuBuilder;

class RunCommand extends Command{

  private $menuManager;

  public function __construct() {
    parent::__construct();
    $this->menuManager = new MenuManager();
  }

  public static function create()
  {
    return new RunCommand();
  }

  public function configure()
  {
      $this -> setName('start')
            -> setDescription('Start UselessThings.');
  }

  public function execute(InputInterface $input, OutputInterface $output)
  {
    $start = $this->menuManager->getMenu('Main');
    $start->open();
    return 0;
  }

}
