<?php

namespace SpecialK;

/**
 * An ordered set of cards
 */
class CardSet implements \IteratorAggregate, \Countable
{
    private $_cards = array();

    /**
     * Constructor
     */
    public function __construct($cards)
    {
        foreach($cards as $card) {
            $this->add($card);
        }
    }

    public function add($card)
    {
        $this->_cards[$card->intVal()] = $card;
        return $this;
    }

    /**
     * Whether the set contains a particular card
     * @return bool
     */
    public function contains($card)
    {
        return isset($this->_cards[$card->intVal()]);
    }

    /**
     * Mask a set by a given face, suit or both
     * @return CardSet
     */
    public function mask($face = '*', $suit = '*')
    {
        $cards = array();

        foreach($this->_cards as $card) {
            if($face == '*' || $card->getFace() == $face) {
                if($suit == '*' || $card->getSuit() == $suit) {
                    $cards []= $card;
                }
            }
        }

        return new self($cards);
    }

    /**
     * Applies a closure over all combinations of N cards
     */
    public function combinations($number, $closure=null)
    {
        $cards = array_values($this->_cards);
        $iterator = new Combinations($cards, $number);
        $result = array();

        foreach($iterator as $subset) {
            if($closure) {
                call_user_func_array($closure, $subset);
            } else {
                $result []= $subset;
            }
        }

        return $result;
    }

    /**
     * Returns a cartesian join of two card sets
     * @return array
     */
    public function product($set)
    {
        $result = array();

        foreach($this->_cards as $i1=>$c1) {
            foreach($set->_cards as $i2=>$c2) {
                if($c1 != $c2) {
                    $result []= array($c1, $c2);
                }
            }
        }

        return $result;
    }

    /**
     * Returns a new set that contains the original set without provided set
     * @return set
     */
    public function difference($set)
    {
        // arrays are copy-on-write
        $cards = $this->_cards;

        foreach($set->_cards as $idx=>$card) {
            if(isset($cards[$idx])) {
                unset($cards[$idx]);
            }
        }

        return new self($cards);
    }

    /**
     * Returns a new Set with the union of the two sets
     * @return set
     */
    public function union($set)
    {
        // shallow copy
        $cards = $this->_cards;

        foreach($set->_cards as $idx=>$card) {
            $cards[$idx] = $card;
        }

        return new self($cards);
    }

    /**
     * Pick N cards, at random
     */
    public function pick($count)
    {
        return array_rand($this->_cards, $count);
    }

    /* (non-phpdoc */
    public function getIterator()
    {
        ksort($this->_cards);
        return new \ArrayIterator($this->_cards);
    }

    /* (non-phpdoc */
    public function count()
    {
        return count($this->_cards);
    }

     /* (non-phpdoc */
    public function __toString()
    {
        return implode($this->_cards);
    }

    /**
     * Helper, Construct and mask a new instance
     */
    public static function construct($face='*', $suit='*')
    {
        $set = new self(Card::all());
        return $set->mask($face, $suit);
    }
}

