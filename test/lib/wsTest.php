<?php
namespace wsTestLib;

class wsTest {
  public function __construct($name) {
    $this->name = $name;
  }

  public function __toString() {
    return $this->name;
  }

  public function assert($first, $second) {
    if ($first === $second) {
      echo ".";
    } else {
      echo "F";
      ob_start();
      echo "================\n";
      echo "{$this->name}: \n";
      var_dump($first, $second);
      $this->error = ob_get_contents();
      ob_end_clean();
    }
  }

  public function is_true($value) {
    $this->assert(true, $value);
  }

  public function is_false($value) {
    $this->assert(false, $value);
  }

  public function is_null($value) {
    $this->assert(null, $value);
  }

  public function is_not_null($value) {
    $this->is_false($value === null);
  }

  public function is_empty($value) {
    $this->assert('', $value);
  }

  public function is_not_empty() {
    $this->is_false($value === '');
  }
}

