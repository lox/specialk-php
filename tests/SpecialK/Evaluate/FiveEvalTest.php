<?php

namespace SpecialK\Evaluate;

class FiveEvalTest extends \PHPUnit_Framework_TestCase
{
    private $fiveEval;

    public function setUp()
    {
        if(!isset($this->fiveEval))
            $this->fiveEval = new FiveEval();
    }

    public function testHighCard()
    {
        $this->assertEquals(1, $this->_rank("7s 5s 4s 3s 2c"));
        $this->assertEquals(1277, $this->_rank("As Ks Qs Js 9c"));

        $this->assertGreaterThan(
            $this->_rank("As Qc Td 5c 4c"),
            $this->_rank("As Kc Td 7c 4c")
        );
    }

    public function testOnePair()
    {
        $evaluator = new FiveEval();

        $this->assertEquals(1278, $this->_rank("2c 2c 5c 4c 3s"));
        $this->assertEquals(4137, $this->_rank("Ac Ac Kc Qc Js"));

        $this->assertGreaterThan($this->_rank("As Ac Td 5c 4c"), $this->_rank("As Ac Td 7c 4c"));
    }

    public function testEvaluateStraight()
    {
        $evaluator = new FiveEval();
        $this->assertGreaterThan($this->_rank("As Ac Td 5c 4c"), $this->_rank("As 2c 3d 4c 5c"));
    }

     private function _rank($hand)
    {
        return $this->fiveEval->evaluate($hand);
    }
}
