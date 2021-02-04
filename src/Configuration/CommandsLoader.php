<?php

namespace UselessThings\Configuration;

use Symfony\Component\Console\CommandLoader\FactoryCommandLoader;
use Symfony\Component\Yaml\Yaml;

class CommandsLoader{

  private static $commandloader;

  public function getCommands(){
    if (self::$commandloader === null)
    {
        self::$commandloader = self::load();
    }
    return self::$commandloader;
  }

  private function load()
  {
    $content = file_get_contents(__DIR__.'/commands.yaml');
    $value = Yaml::parse($content);

    $namespace = $value['commands']['namespace'] . "\\";

    $commands = array();
    foreach($value['commands']['to_load'] as $command=>$commandClass)
    {
      if(class_exists($namespace.$commandClass))
      {
        $commands[$command] = array($namespace.$commandClass,'create');
      }
    }
    return $commandLoader = new FactoryCommandLoader($commands);
  }
}
