<?php

namespace SpecialK;

/**
 * A range of two-card hands, expressed with a hand range syntax
 *
 * Supported syntax:
 *  AsKs  - 1 specific hand
 *  22    - 22
 *  JJ+   - JJ, QQ, KK, AA
 *  45s+  - All suited connectors above 45s
 *  88-JJ - 88, 99, TT, JJ
 */
class Range implements \IteratorAggregate, \Countable
{
    private $_hands = array();

    public function __construct($pattern, $dead = null)
    {
        foreach(explode(',', $pattern) as $atom) {
            $atom = trim($atom);

            // match non-ranged
            if(preg_match('/^([2-9TJKQKA*][sdch*]?)([2-9TJKQKA*][sdch*]?)(([\+\-].*?)?)$/', $atom, $m))
                $hands = $this->_parseAtoms($m[1], $m[2], $m[3]);

            // match suited/non-suited
            else if(preg_match('/^([2-9TJKQKA*])([2-9TJKQKA*])([os])(([\+\-].*?)?)$/', $atom, $m))
                $hands = $this->_parseAtomsWithSuitedness($m[1], $m[2], $m[3], $m[4]);

            else
                throw new \InvalidArgumentException("Unable to parse atom $atom");

            $this->_hands = array_merge($this->_hands, $hands);
        }
    }

    private function _parseAtoms($atom1, $atom2, $bounds=false)
    {
        if($atom1 == $atom2) {
            $hands = $this->_cardSet($atom1)->combinations(2);
        } else {
            $hands = $this->_cardSet($atom1)->product($this->_cardSet($atom2));
        }

        if($bounds && ($range = $this->_enumerateHandRange($atom1, $atom2, $bounds))) {
            $hands = array_merge($hands, $range);
        }

        return $hands;
    }

    private function _parseAtomsWithSuitedness($atom1, $atom2, $atom3, $bounds)
    {
        return array_filter($this->_parseAtoms($atom1, $atom2, $bounds), function($hand) use($atom3) {
            $same = $hand[0]->getSuit() == $hand[1]->getSuit();
            return (($atom3 == 's' && $same) || ($atom3 == 'o' && !$same));
        });
    }

    private function _enumerateHandRange($atom1, $atom2, $bound)
    {
        $faces = str_split('23456789TJQKA');
        $ord = array_flip($faces);
        $hands = array();

        for($o1 = $ord[$atom1[0]]+1, $o2 = $ord[$atom2[0]]+1; $o1 <=12 && $o2 <= 12; $o1++, $o2++) {
            $atom1[0] = $faces[$o1];
            $atom2[0] = $faces[$o2];
            $hands = array_merge($hands, $this->_parseAtoms($atom1, $atom2));
        }

        return $hands;
    }

    /**
     * Generates a cardset from a single card token, A[sdch], A*, A
     */
    private function _cardSet($atom)
    {
        if(strlen($atom) == '1') {
            $atom .= '*';
        }

        list($faceAtom, $suitAtom) = str_split($atom);

        $faces = ($faceAtom == '*') ? str_split('23456789TJQKA') : array($faceAtom);
        $cards = array();

        foreach($faces as $face) {
            if($suitAtom == '*') {
                foreach(array('s','d','c','h') as $suit) {
                    $cards []= new Card($face.$suit);
                }
            } else {
                $cards []= new Card($face.$suitAtom);
            }
        }

        return new CardSet($cards);
    }

    public function toArray()
    {
        return $this->_hands;
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->_hands);
    }

    public function count()
    {
        return count($this->_hands);
    }

    public function __toString()
    {
        $hands = array();

        foreach($this->_hands as $hand) {
            $hands []= $hand[0].$hand[1];
        }

        return implode(', ', $hands);
    }
}
