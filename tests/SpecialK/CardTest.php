<?php

namespace SpecialK;

class CardTest extends \PHPUnit_Framework_TestCase
{
    public function testAllCards()
    {
        $cards = Card::all();
        $this->assertCount(52, $cards);
    }

    public function testAllCardsAreOrdered()
    {
        $cards = Card::all();
        $counter = 0;

        // check the order of the cards
        foreach (array('A','K','Q','J','T','9','8','7','6','5','4','3','2') as $face) {
            foreach (array('s','h','d','c') as $suit) {
                $this->assertEquals($face.$suit, $cards[$counter++]->__toString());
            }
        }
    }
}
