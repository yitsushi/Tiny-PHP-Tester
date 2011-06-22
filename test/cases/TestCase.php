<?php
namespace wsTestLib;
class TestCase {
  // Define a human name
  var $name = 'Simple test case';
  var $skip = false;

  // It will be called first (aka: __construct)
  public function sunrise() {
    echo 'TestCase sunrise.', "\n";
  }

  // It will be called last (aka: __destruct)
  public function sunset() {
    echo 'TestCase sunset.', "\n";
  }

  public function test_my_match($c) {
    $c->with_is_true->is_true(true);
  }

  public function test_my_mismatch($c) {
    $c->with_is_true->is_true(false);
  }
}
