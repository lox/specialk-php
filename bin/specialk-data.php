<?php

require_once(__DIR__.'/../vendor/autoload.php');
ini_set('memory_limit', '1024M');

$dir = __DIR__.'/../data';

$timer = microtime(true);
printf("Generating five card hand data file...");

$five = new \SpecialK\Evaluate\FiveEval();
$five->save($dir);

printf(" Saved in %.2fs\n", microtime(true)-$timer);

$timer = microtime(true);
printf("Generating seven card hand data file...");

$seven = new \SpecialK\Evaluate\SevenEval();
$seven->save($dir);

printf(" Saved in %.2fs\n", microtime(true)-$timer);
