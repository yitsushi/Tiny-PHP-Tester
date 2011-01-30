<?php
namespace wsTestLib;
class AnotherTestCase {
  // Define a human name
  var $name = 'Another simple test case';

  // It will be called first called method
  public function sunrise() {
    $this->one = 1;
    $this->two = 2;
  }

  public function test_one_equal_one($c) {
    $c->one_equal_with_one->assert($this->one, $this->one);
  }

  public function test_two_equal_two($c) {
    $c->two_equal_with_two->assert($this->two, $this->two);
  }

  // Sample test: 2 > 1 ?
  public function test_two_greater_than_one($c) {
    // is it true?      2 > 1
    $c->two_greater_than_one->is_true($this->two > $this->one);
    // is it false?     2 < 1
    $c->two_lesser_than_one->is_false($this->two < $this->one);
    // is it false?     2 = 1
    $c->two_equal_with_one->is_false($this->two == $this->one);
  }
}
