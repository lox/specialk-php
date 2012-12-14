<?php

DEFINE('ITERATIONS', 1000000);

require_once(__DIR__.'/../vendor/autoload.php');

$timer = microtime(true);
$evaluator = \SpecialK\Evaluate\SevenEval::load(__DIR__.'/../data');
$deck = array();

printf("Evaluator loaded in %.2fs, using %d Kbytes of memory\n",
	microtime(true)-$timer, memory_get_usage()/1024);

for($i=0; $i<52; $i++)
  $deck[$i] = $i;

shuffle($deck);
$timer = microtime(true);

for($i=0; $i<ITERATIONS; $i++)
	$evaluator->evaluateSeven($deck[0], $deck[1], $deck[2], $deck[3], $deck[4], $deck[5], $deck[6]);

$seconds = microtime(true)-$timer;
printf("Evaluated %d 7-card hands in %.2fs (%d/s)\n", ITERATIONS, $seconds, ITERATIONS/$seconds);

