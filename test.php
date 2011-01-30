<?php
// init for full sorce code
// Constans, class, function, variale etc.
if (file_exists('init.php')) {
  require 'init.php';
}

// test base dir
if (!defined('TEST')) {
  define('TEST', 'test');
}

require_once TEST.'/base.php';

$b = new wsTestLib\wsBase();
$b->find_and_call_tests();
$exit_code = $b->finish();

// for shell: exit 1 if fail detected and exit 0 if all success
exit($exit_code == false);

