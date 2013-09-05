<?php

namespace SpecialK;

/**
 * A single playing card
 */
class Card
{
    private $_face, $_suit, $_int;

    private static $_faces = array(
        'A'=>0, 'K'=>1, 'Q'=>2, 'J'=>3,
        'T'=>4, '9'=>5, '8'=>6, '7'=>7,
        '6'=>8, '5'=>9, '4'=>10, '3'=>11,
        '2'=>12
    );

    private static $_suits = array(
        's'=>0, 'h'=>1, 'd'=>2, 'c'=>3
    );

    /**
     * Constructor
     * @param string the string value of the hand
     */
    public function __construct($str)
    {
        if(!preg_match('/^[2-9AKQJT][shdc]$/', $str)) {
            throw new \InvalidArgumentException("Invalid hand string $str");
        }

        $this->_face = $str[0];
        $this->_suit = $str[1];
        $this->_int = (4 * self::$_faces[$str[0]]) + self::$_suits[$str[1]];
    }

    /**
     * Returns an integer for the card, in descending value from 0 - 51, from As - 2c
     */
    public function intVal()
    {
        return $this->_int;
    }

    /**
     * Returns a 2 character string representation
     */
    public function __toString()
    {
        return $this->_face.$this->_suit;
    }

    public function getFace()
    {
        return $this->_face;
    }

    public function getSuit()
    {
        return $this->_suit;
    }

    /**
     * Parse a string of space delimited hands into an array of ints
     * @return array
     */
    public static function parseHand($str)
    {
        $hand = array();

        foreach(explode(' ', $str) as $card)
            $hand []= new self($card);

        return $hand;
    }

    /**
     * Returns all cards, from highest to lowest
     * @return array
     */
    public static function all()
    {
        $cards = array();

        foreach (array('A','K','Q','J','T','9','8','7','6','5','4','3','2') as $face) {
            foreach (array('s','h','d','c') as $suit) {
                $cards []= new self($face.$suit);
            }
        }

        return $cards;
    }

}
