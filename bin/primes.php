#!/usr/bin/php
<?php

define('PRIME_START', 2);   //  One, by definition, is not prime

if (isset($argv[2])) {
    $start = (int) $argv[1];
    $max = (int) $argv[2];
} elseif (isset($argv[1])) {
    $start = (int) PRIME_START;
    $max = (int) $argv[1];
} else {
    $start = PRIME_START;
    $max = PHP_INT_MAX;
}

if ($start < PRIME_START) {
    $start = PRIME_START;
}

if ($max < PRIME_START) {
    $max = PHP_INT_MAX;
}

//echo "Using $start as start value and $max as max value\n";

$int = $start;

while ($int <= $max) {
    $start_time = microtime(true);
    if (is_prime($int)) {
        $total_time = round((microtime(true) - $start_time), 2);
        //echo "$int is prime (calculated in {$total_time}s)\n";
        echo $int . "\n";
    }
    ++$int;
}

//echo "All possible primes lower than $max have been calculated!\n";

/**
 * A very naïve test to determine the primality of a given integer
 *
 * @param int $int
 * @return boolean integer is prime
 */
function is_prime($int)
{
    if (! is_numeric($int)) {
        return false;
    }

    $int = (int) $int;

    //echo "Testing primality of $int\n";

    $test_divisor_start = PRIME_START; //  By coincidence, the first divisor to determine prime numbers is also the first prime number
    $test_divisor_end = (int) sqrt($int);

    //echo "Possible divisors for $int range from $test_divisor_start through $test_divisor_end\n";

    $test_divisor = $test_divisor_start;

    while ($test_divisor <= $test_divisor_end) {
        //echo "Testing if $test_divisor is a divisor of $int\n";
        if (is_divisor($int, $test_divisor)) {
            //echo "$test_divisor IS a divisor for $int\n";
            return false;
        }
        //echo "$test_divisor is not a divisor for $int\n";
        ++$test_divisor;
    }

    //  If we are here, then that means no divisors were found
    return true;
}

/**
 * Very simple function to determine if one integer is the divisor of another
 *
 * @param int $dividend
 * @param int $divisor
 * @return boolean $divisor is divisor of dividend
 */
function is_divisor($dividend, $divisor)
{
    if (0 === $dividend % $divisor) {
        return true;
    } else {
        return false;
    }
}
