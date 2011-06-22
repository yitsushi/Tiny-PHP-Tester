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

      if (property_exists($c, "name")) $case = $c->name;
      else $case = strtolower(preg_replace('/([A-Z])/', '_$1', $class_name));

      if (property_exists($c, "skip") and $c->skip === true) {
        $this->r->$case->skip();
        unset($c);
        continue;
      }
      ob_start();
      if(method_exists($c, 'sunrise')) $c->sunrise(); // __construct = sunrise (why not?)
      ob_end_clean();

      foreach(get_class_methods($c) as $m) {
        if (!preg_match('/^test_/', $m)) continue;
        $prefix = preg_replace('/^test_/', '', $m);

        $this->r->$case->set_test_namespace($prefix);
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

$_colors = array(
  'LIGHT_RED'     => "[1;31m",
  'LIGHT_GREEN'   => "[1;32m",
  'YELLOW'        => "[1;33m",
  'LIGHT_BLUE'    => "[1;34m",
  'MAGENTA'       => "[1;35m",
  'LIGHT_CYAN'    => "[1;36m",
  'WHITE'         => "[1;37m",
  'NORMAL'        => "[0m",
  'BLACK'         => "[0;30m",
  'RED'           => "[0;31m",
  'GREEN'         => "[0;32m",
  'BROWN'         => "[0;33m",
  'BLUE'          => "[0;34m",
  'CYAN'          => "[0;36m",
  'BOLD'          => "[1m",
  'UNDERSCORE'    => "[4m",
  'REVERSE'       => "[7m"
);
function termcolored($text, $color="NORMAL", $back=1){
  global $_colors;
  $out = $_colors["{$color}"];
  if($out == ""){ $out = "[0m"; }
  if($back){
    return chr(27)."{$out}{$text}".chr(27)."[0m";
  }else{
    echo chr(27)."{$out}$text".chr(27).chr(27)."[0m";
  }
}

if (basename(__FILE__) == basename($argv[0])) {
  $b = new wsBase();
  $b->find_and_call_tests();
  $exit_code = $b->finish();
  exit($exit_code == false);
}
