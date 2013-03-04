<?php

namespace SpecialK\Evaluate;

class SevenEvalTest extends \PHPUnit_Framework_TestCase
{
    private $fiveEval, $sevenEval;

    public function setUp()
    {
        if (!isset($this->fiveEval)) {
            $this->fiveEval = new FiveEval();
            $this->sevenEval = new SevenEval();
        }
    }

    public function testValidityOfRanks()
    {
        $this->assertHandsEqual("2c 2c 5c 4c 3s Ad Ad");
        $this->assertHandsEqual("5c 5d 5h 2c 3c 4c 7c");
    }

     private function assertHandsEqual($hand)
    {
        $this->assertEquals(
            $this->fiveEval->evaluate($hand),
            $this->sevenEval->evaluate($hand)
        );
    }
}
