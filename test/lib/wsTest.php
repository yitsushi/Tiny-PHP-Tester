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
      echo termcolored(".", "LIGHT_GREEN");
    } else {
      echo termcolored("F", "LIGHT_RED");
      ob_start();
      echo "================\n";
      echo 'Need:    '; var_dump($first);
      echo 'Get:     '; var_dump($second);
      echo "================\n";
      $this->error = termcolored(ob_get_contents(), 'YELLOW');
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

