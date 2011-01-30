<?php
namespace wsTestLib;

if (!defined('TEST')) {
  define('TEST', 'test');
}

require_once(dirname(__FILE__).'/lib/wsResult.php');

class wsBase {
  public function __construct() {
    $this->r = new wsResult();
  }

  public function find_and_call_tests() {
    $dir = opendir(\TEST."/cases");
    if ($dir == null) die(' >>> WTF! NEED cases dir...');
    while (($file = readdir($dir)) !== false) {
      if (  in_array($file, array('.', '..'))
        or (preg_match('/^\./',$file))
        or (!preg_match('/\.php$/',$file))) continue;
      require_once TEST."/cases/{$file}";
      $class_name = preg_replace('/\.php$/', '', $file);
      $class = __NAMESPACE__ . "\\" . $class_name;
      $c = new $class();
      ob_start();
      if(method_exists($c, 'sunrise')) $c->sunrise(); // __construct = sunrise (why not?)
      ob_end_clean();

      foreach(get_class_methods($c) as $m) {
        if (!preg_match('/^test_/', $m)) continue;
        if (property_exists($c, "name")) $case = $c->name;
        else $case = strtolower(preg_replace('/([A-Z])/', '_$1', $class));

        $c->$m(&$this->r->$case);
      }

      ob_start();
      if(method_exists($c, 'sunset')) $c->sunset();   // anti__construct = sunset (why not?)
      ob_end_clean();

      unset($c);
    }
  }

  public function finish() {
    return $this->r->finish();
  }
}

if (basename(__FILE__) == basename($argv[0])) {
  $b = new wsBase();
  $b->find_and_call_tests();
  $exit_code = $b->finish();
  exit($exit_code == false);
}
