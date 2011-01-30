<?php
namespace wsTestLib;

require_once(dirname(__FILE__).'/wsCase.php');
require_once(dirname(__FILE__).'/wsTest.php');

class wsResult {
  public function __construct() {
    $this->session = array();
  }

  public function add_case($name) {
    $this->session[] = new wsCase($name);
  }

  public function __get($name) {
    return $this->find_or_create_case($name);
  }

  private function find_or_create_case($name) {
    foreach($this->session as $s) {
      if ("{$s}" == $name) return $s;
    }
    $c = new wsCase($name);
    $this->session[] = $c;
    return $c;
  }

  public function finish() {
    echo "\n\n";
    $cases    = 0;
    $tests    = 0;
    $pass     = 0;
    $defects  = 0;
    $failures = 0;
    foreach($this->session as $s) {
      $cases++;
      list($f, $p) = $s->print_errors();
      $tests    += ($f + $p);
      $pass     += $p;
      $failures += $f;
      if ($f > 0) $defects++;
    }

    echo "\n---------------------------------\n";
    echo "   Cases:        {$cases}\n";
    echo "   Defects:      {$defects}\n";
    echo "   Tests:        {$tests}\n";
    echo "   Pass:         {$pass}\n";
    echo "   Failures:     {$failures}\n";

    return ($failures == 0);
  }
}

if (basename(__FILE__) == basename($argv[0])) {
  $r = new wsResult();
  //$r->message_board->post_new_message(true);
  $r->test_case->assert_match->assert(1, 1);
  $r->test_case->assert_mismatch->assert(1, 2);
  $r->test_case->assert_is_true_match->is_true(true);
  $r->test_case->assert_is_true_mismatch->is_true(false);
  $r->test_case->assert_is_false_match->is_false(false);
  $r->test_case->assert_is_false_mismatch->is_false(true);

  $r->test_case_sec->assert_match->assert(1, 1);
  $r->test_case_sec->assert_match_2->assert(3, 3);
  $r->test_case_sec->assert_match_3->assert('ok', 'ok');
  $r->test_case_sec->assert_mismatch->assert(1, 2);
  $r->test_case_sec->assert_is_true_match->is_true(true);
  $r->test_case_sec->assert_is_true_mismatch->is_true(false);
  $r->test_case_sec->assert_is_false_match->is_false(false);
  $r->test_case_sec->assert_is_false_mismatch->is_false(true);

  exit($r->finish() == false);
}
