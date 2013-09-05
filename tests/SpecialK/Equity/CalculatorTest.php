<?php

namespace SpecialK\Equity;

use \SpecialK\Card;
use \SpecialK\CardSet;
use \SpecialK\Range;

class CalculatorTest extends \PHPUnit_Framework_TestCase
{
    public function testCalculateSimpleEquity()
    {
        $hands = array(
            new Range('A*K*'),
            new Range('JJ+'),
        );

        $calculator = new Calculator();
        $result = $calculator->calculate($hands);

        var_dump($result);
    }
}


