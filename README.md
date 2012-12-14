SpecialK Poker Hand Evaluator
=============================

This is a straight PHP port of SpecialK's poker hand evaluator.

Reference:
 - http://specialk-coding.blogspot.com/2010/04/texas-holdem-7-card-evaluator_23.html
 - http://specialk-coding.blogspot.com/2011/02/texas-holdem-7-card-evaluator-part-ii.html
 - https://github.com/SpecialK/SpecialKEval/tree/master/Java/src/com/SpecialK/SpecialKEval

Usage
-----

There are two evaluators, a five card evaluator and a seven card evaluator. The seven card
one is the most useful:

```php

$seven = new \SpecialK\Evaluator\SevenEval();
echo $seven->compare('As Ac Td 5c 4c 2c 6h', 'Ks Kc Td 5c 4c 2c 6h');

// prints 1, AA beats KK
```

Performance
-----------

For comparison, the C++ implementation runs `200,036,416 evaluations
per second` on my MacBook Air 2012.

```bash
$ php benchmark/fiveeval.php

Evaluator loaded in 0.09s, using 77228 Kbytes of memory
Evaluated 1000000 5-card hands in 1.47s (680243/s)
Evaluated 1000000 7-card hands in 63.51s (15745/s)
```

```bash
$ php benchmark/seveneval.php

Evaluator loaded in 0.10s, using 77229 Kbytes of memory
Evaluated 1000000 7-card hands in 3.34s (299672/s)
```

If performance is important, make sure to use the `evaluateFive` and `evaluateSeven` methods
directly with integers.

License
-------

GPLv3, as per the original code


