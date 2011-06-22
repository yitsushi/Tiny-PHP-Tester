<?php
namespace wsTestLib;
class AnotherTestCase {
  // Define a human name
  var $name = 'Another simple test case';
  var $skip = false;

  // It will be called first called method
  public function sunrise() {
    $this->one = 1;
    $this->two = 2;
  }

  public function test_one($c) {
    $c->equal_with_one->assert($this->one, 1);
  }

  // Sample test: 2 > 1 ?
  public function test_two($c) {
    // is it true?      2 > 1
    $c->greater_than_one->is_true($this->two > $this->one);
    // is it false?     2 < 1
    $c->lesser_than_one->is_false($this->two < $this->one);
    // is it false?     2 = 1
    $c->equal_with_one->is_false($this->two == $this->one);
  }
}
