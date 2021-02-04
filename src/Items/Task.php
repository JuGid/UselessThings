<?php

namespace UselessThings\Items;

use Symfony\Component\Yaml\Yaml;

class Task {

  private $file_save = __DIR__. '/tasks_save.yml';

  private $priority;

  private $description;

  public function getPriority() {
    return $this->priority;
  }

  public function getDescription() {
    return $this->description;
  }

  public function setPriority(int $priority) {
    $this->priority = $priority;

    return $this;
  }

  public function setDescription(string $description) {
    $this->description = $description;

    return $this;
  }

  public function save() {
    $value = Yaml::parseFile($this->file_save);
    $value['tasks'][$this->description] = $this->priority;
    $yaml = Yaml::dump($value);
    file_put_contents($this->file_save, $yaml);
  }

  public function reset() {
    $this->priority = 0;
    $this->description = '';
  }

  public function saveAndReset() {
    $this->save();
    $this->reset();
  }

  public function isValid() {
    return $this->priority !== null && $this->description !== null && $this->description !== '';
  }

  public static function getFileSave() {
    return __DIR__. '/tasks_save.yml';
  }
}
