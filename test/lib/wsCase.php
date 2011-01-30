<?php
namespace wsTestLib;

class wsCase {
  public function __construct($name) {
    $this->name    = $name;
    $this->session = array();
  }

  public function add_test($name) {
    $this->session[] = new wsTest($name);
  }

  public function __toString() {
    return $this->name;
  }

  public function __get($name) {
    return $this->find_or_create_test($name);
  }

  private function find_or_create_test($name) {
    foreach($this->session as $s) {
      if ("{$s}" == $name) return $s;
    }
    $t = new wsTest($name);
    $this->session[] = $t;
    return $t;
  }

  public function print_errors() {
    $fail   = 0;
    $pass   = 0;
    $errors = array();
    foreach($this->session as $s) {
      if (property_exists($s, 'error')) {
        $errors[] = $s->error;
        $fail++;
      } else $pass++;
    }

    if ($fail > 0) echo "[FAIL]";
    else echo "[ OK ]";
    echo " {$this->name}\n";
    foreach($errors as $e) {
      echo $e;
    }

    return array($fail, $pass);
  }
}

