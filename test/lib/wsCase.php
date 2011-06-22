<?php
namespace wsTestLib;

class wsCase {
  var $_pfx = '';

  public function __construct($name) {
    $this->name    = $name;
    $this->session = array();
    $this->skip    = false;
  }

  public function add_test($name) {
    $this->session[] = new wsTest($name);
  }

  public function __toString() {
    return $this->name;
  }

  public function __get($name) {
    return $this->find_or_create_test("{$this->_pfx}_{$name}");
  }

  public function skip() {
    $this->skip = true;
  }

  public function is_skipped() {
    return $this->skip;
  }

  public function set_test_namespace($pfx) {
    $this->_pfx = $pfx;
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
      } else {
        $pass++;
      }
    }

    if ($this->is_skipped()) echo termcolored("[ S ]", 'CYAN');
    elseif ($fail > 0) echo termcolored("---->", "LIGHT_RED");
    else echo termcolored("---->", "LIGHT_GREEN");
    echo " {$this->name}\n";
    foreach($this->session as $s) {
      $name = preg_replace('/_/', ' ', $s);
      if (property_exists($s, 'error')) {
        echo termcolored("       [FAIL] ", "LIGHT_RED"), $name, "\n";
        echo "              ", trim(preg_replace('/\n/', "\n              ", $s->error)), "\n";
      } else {
        echo termcolored("       [ OK ] ", "LIGHT_GREEN"), $name, "\n";
      }
    }

    return array($fail, $pass);
  }
}

