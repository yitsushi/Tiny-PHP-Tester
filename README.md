Tiny PHP Tester - It's a one_night testing system for php. Simple and small ^_^
====================================

## DESCRIPTION
Very simple php testing/unit-testing tool for PHP projects.
It's NOT a professional tool just useful.

## INSTALL
 * Copy files (clone it) into the target directory
 * If you need to edit the init.php
 * Read the example classes
 * Write your own class
 * Customize the code as you liking

## RUN
    $ php test.php
    .F.....

    [FAIL] Simple test case
    ================
    my_mismatch_with_is_true:
    bool(true)
    bool(false)
    [ OK ] Another simple test case

    ---------------------------------
       Cases:        2
       Defects:      1
       Tests:        7
       Pass:         6
       Failures:     1

 * Cases: Number of testing classes
 * Defects: Number of testing classes what have least one failed test
 * Tests: Number of tests
 * Pass: Number of tests which make no mistake
 * Failures: Number of tests which make mistake

Return value: 1

## AUTHOR
    Name:      Balazs Nadasdi
    Email:     yitsushi gmail com
    Twitter:   @yitsushi
    Company:   Woop media kft.
