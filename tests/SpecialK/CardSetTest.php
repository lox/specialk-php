<?php

namespace SpecialK;

class CardSetTest extends \PHPUnit_Framework_TestCase
{
    public function testSetIsCountable()
    {
        $set = new CardSet(array(new Card('Kh'), new Card('Qs')));
        $this->assertCount(2, $set);
    }

    public function testSetContains()
    {
        $cards = array(new Card('Kh'), new Card('Qs'));
        $set = new CardSet($cards);

        $this->assertTrue($set->contains($cards[0]));
        $this->assertTrue($set->contains(new Card('Qs')));
        $this->assertFalse($set->contains(new Card('Jd')));
    }

    public function testFaceWildcardMask()
    {
        $set = new CardSet(Card::all());
        $diamonds = $set->mask('*', 'd');
        $this->assertCount(13, $diamonds);
    }

    public function testSuitWildcardMask()
    {
        $set = new CardSet(Card::all());
        $aces = $set->mask('A', '*');
        $this->assertCount(4, $aces);
    }

    public function testCombinationsOf2()
    {
        $set = new CardSet(array(new Card('Kh'), new Card('Kc'), new Card('Ks'), new Card('Kd')));

        $hands = array();
        $combinations = $set->combinations(2, function($c1, $c2) use(&$hands) {
            $hands []= array($c1, $c2);
        });

        $this->assertCount(6, $hands);
    }

    public function testCombinationsOf3()
    {
        $set = new CardSet(array(new Card('Kh'), new Card('Kc'), new Card('Ks'), new Card('Kd')));

        $hands = array();
        $combinations = $set->combinations(3, function($c1, $c2, $c3) use(&$hands) {
            $hands []= array($c1, $c2, $c3);
        });

        $this->assertCount(4, $hands);
    }

    public function testDifference()
    {
        $all = CardSet::construct();
        $aces = CardSet::construct('A', '*');
        $result = $all->difference($aces);

        $this->assertCount(48, $result);
        $this->assertFalse($result->contains(new Card('Ac')));
        $this->assertFalse($result->contains(new Card('Ad')));
        $this->assertFalse($result->contains(new Card('Ah')));
        $this->assertFalse($result->contains(new Card('As')));
    }

}
