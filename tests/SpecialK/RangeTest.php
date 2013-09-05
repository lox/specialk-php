<?php

namespace SpecialK;

class RangeTest extends \PHPUnit_Framework_TestCase
{
    public function testPairs()
    {
        $range = new Range('22');
        $this->assertCount(6, $range);
    }

    public function testWildcard()
    {
        $range = new Range('****');
        $this->assertCount(1326, $range);

        $range = new Range('**');
        $this->assertCount(1326, $range);

        $range = new Range('AK');
        $this->assertCount(16, $range);
    }

    public function testSpecificSuitMatches()
    {
        $range = new Range('AsKs');
        $this->assertCount(1, $range);
    }

    public function testSuitedMatches()
    {
        $range = new Range('AKs');
        $this->assertCount(4, $range);

        $range = new Range('AKo');
        $this->assertCount(12, $range);
    }

    public function testUnboundedRange()
    {
        $range = new Range('TT+');
        $this->assertCount(30, $range);

        $range = new Range('45o+');
        $this->assertCount(120, $range);
    }

    public function testBoundedRange()
    {
        $range = new Range('TT-JJ');
        $this->assertCount(12, $range);

        $range = new Range('45s-78s');
        $this->assertCount(48, $range);
    }

}
