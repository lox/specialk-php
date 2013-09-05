<?php

namespace SpecialK\Evaluate;

use SpecialK\Evaluate\Constants;
use SpecialK\Evaluate\FiveEval;

/**
 * A seven card holdem evaluator
 */
class SevenEval
{
    private $rank, $flushRank, $face, $flush, $suit, $flushCheck;

    /**
     * Constructor
     */
    public function __construct($generate=true)
    {
        if ($generate) {
            $this->generateDeck();
            $this->generateRankings();
            $this->generateFlushCheck();
        }
    }

    public function save($dir)
    {
        return file_put_contents("$dir/seveneval.json", json_encode(array(
            $this->rank, $this->flushRank, $this->face, $this->flush, $this->suit, $this->flushCheck
        )));
    }

    /**
     * Loads a SevenEval object from a lookup table created with {@link save}
     * @return FiveEval
     */
    public static function load($dir=null)
    {
        $dir = $dir ?: __DIR__.'/../../../data';
        $seven = new self(false);
        $data = json_decode(file_get_contents("$dir/seveneval.json"), true);

        $seven->rank = $data[0];
        $seven->flushRank = $data[1];
        $seven->face = $data[2];
        $seven->flush = $data[3];
        $seven->suit = $data[4];
        $seven->flushCheck = $data[5];

        unset($data);

        return $seven;
    }

    private function generateDeck()
{
        $this->face = array();
        $this->flush = array();
        $this->suit = array();

        $face = array(
            Constants::ACE, Constants::KING, Constants::QUEEN, Constants::JACK,
            Constants::TEN, Constants::NINE, Constants::EIGHT, Constants::SEVEN,
            Constants::SIX, Constants::FIVE, Constants::FOUR, Constants::THREE,
            Constants::TWO
        );

        $faceflush = array(
            Constants::ACE_FLUSH, Constants::KING_FLUSH, Constants::QUEEN_FLUSH, Constants::JACK_FLUSH,
            Constants::TEN_FLUSH, Constants::NINE_FLUSH, Constants::EIGHT_FLUSH, Constants::SEVEN_FLUSH,
            Constants::SIX_FLUSH, Constants::FIVE_FLUSH, Constants::FOUR_FLUSH, Constants::THREE_FLUSH,
            Constants::TWO_FLUSH
        );

        $n=0;
        for ($n=0; $n<13; $n++) {
            $this->face[4*$n]    = ($face[$n] << Constants::NON_FLUSH_BIT_SHIFT) + Constants::SPADE;
            $this->face[4*$n+1]  = ($face[$n] << Constants::NON_FLUSH_BIT_SHIFT) + Constants::HEART;
            $this->face[4*$n+2]  = ($face[$n] << Constants::NON_FLUSH_BIT_SHIFT) + Constants::DIAMOND;
            $this->face[4*$n+3]  = ($face[$n] << Constants::NON_FLUSH_BIT_SHIFT) + Constants::CLUB;

            $this->flush[4*$n]   = $faceflush[$n];
            $this->flush[4*$n+1] = $faceflush[$n];
            $this->flush[4*$n+2] = $faceflush[$n];
            $this->flush[4*$n+3] = $faceflush[$n];

            $this->suit[4*$n]    = Constants::SPADE;
            $this->suit[4*$n+1]  = Constants::HEART;
            $this->suit[4*$n+2]  = Constants::DIAMOND;
            $this->suit[4*$n+3]  = Constants::CLUB;
        }
    }

    public function generateRankings()
    {
        $fiveEval = new FiveEval();

        $this->rank = array();
        $this->flushRank = array();

        $face = array(
            Constants::ACE, Constants::KING, Constants::QUEEN, Constants::JACK,
            Constants::TEN, Constants::NINE, Constants::EIGHT, Constants::SEVEN,
            Constants::SIX, Constants::FIVE, Constants::FOUR, Constants::THREE,
            Constants::TWO
        );

        $faceFlush = array(
            Constants::ACE_FLUSH, Constants::KING_FLUSH, Constants::QUEEN_FLUSH, Constants::JACK_FLUSH,
            Constants::TEN_FLUSH, Constants::NINE_FLUSH, Constants::EIGHT_FLUSH, Constants::SEVEN_FLUSH,
            Constants::SIX_FLUSH, Constants::FIVE_FLUSH, Constants::FOUR_FLUSH, Constants::THREE_FLUSH,
            Constants::TWO_FLUSH
        );

        //Non-flush ranks
        for ($i=1; $i<13; $i++) {for ($j=1; $j<=$i; $j++) {for ($k=1; $k<=$j; $k++) {for ($l=0; $l<=$k; $l++) {
            for ($m=0; $m<=$l; $m++) {for ($n=0; $n<=$m; $n++) {for ($p=0; $p<=$n; $p++) {

                if ($i!=$m && $j!=$n && $k!=$p) {
                    $key=$face[$i]+$face[$j]+$face[$k]+$face[$l]+$face[$m]+$face[$n]+$face[$p];

                    //The 4*$i+0 and 4*$m+1 trick prevents flushes
                    $rank=$fiveEval->evaluate(array(4*$i, 4*$j, 4*$k, 4*$l, 4*$m+1, 4*$n+1, 4*$p+1));
                    $this->rank[$key]=$rank;}}}}}}}}

        //Flush ranks
        //All 7 same suit:
        for ($i=6; $i<13; $i++) {for ($j=5; $j<$i; $j++) {for ($k=4; $k<$j; $k++) {for ($l=3; $l<$k; $l++) {
            for ($m=2; $m<$l; $m++) {for ($n=1; $n<$m; $n++) {for ($p=0; $p<$n; $p++) {

                $key=$faceFlush[$i]+$faceFlush[$j]+$faceFlush[$k]+$faceFlush[$l]+$faceFlush[$m]+
                                                                        $faceFlush[$n]+$faceFlush[$p];
                $rank=$fiveEval->evaluate(array(4*$i, 4*$j, 4*$k, 4*$l, 4*$m, 4*$n, 4*$p));
                $this->flushRank[$key]=$rank;}}}}}}}

        //Only 6 same suit:
        for ($i=5; $i<13; $i++) {for ($j=4; $j<$i; $j++) {for ($k=3; $k<$j; $k++) {for ($l=2; $l<$k; $l++) {
            for ($m=1; $m<$l; $m++) {for ($n=0; $n<$m; $n++) {

                $key=$faceFlush[$i]+$faceFlush[$j]+$faceFlush[$k]+$faceFlush[$l]+$faceFlush[$m]+$faceFlush[$n];

                //The Two of clubs is the card at index 51, the
                //other cards are all spades
                $rank=$fiveEval->evaluate(array(4*$i, 4*$j, 4*$k, 4*$l, 4*$m, 4*$n, 51));
                $this->flushRank[$key]=$rank;}}}}}}

        //Only 5 same suit:
        for ($i=4; $i<13; $i++) {for ($j=3; $j<$i; $j++) {for ($k=2; $k<$j; $k++) {for ($l=1; $l<$k; $l++) {
            for ($m=0; $m<$l; $m++) {

                $key=$faceFlush[$i]+$faceFlush[$j]+$faceFlush[$k]+$faceFlush[$l]+$faceFlush[$m];

                $rank=$fiveEval->evaluate(array(4*$i, 4*$j, 4*$k, 4*$l, 4*$m));
                $this->flushRank[$key]=$rank;}}}}}
    }

    private function generateFlushCheck()
    {
        $this->flushCheck = array();

        //Begin with spades and run no further than clubs
        $suitKey = Constants::SPADE;
        $suits = array(Constants::SPADE, Constants::HEART, Constants::DIAMOND, Constants::CLUB);

        for($i = 0; $i < Constants::MAX_FLUSH_CHECK_SUM+1 ; $i++ )
            $this->flushCheck[$i]=Constants::UNVERIFIED;

        //7-card
        for ($card_1=0; $card_1<Constants::NUMBER_OF_SUITS; $card_1++) {
            for ($card_2=0; $card_2<=$card_1; $card_2++) {
                for ($card_3=0; $card_3<=$card_2; $card_3++) {
                    for ($card_4=0; $card_4<=$card_3; $card_4++) {
                        for ($card_5=0; $card_5<=$card_4; $card_5++) {
                            for ($card_6=0; $card_6<=$card_5; $card_6++) {
                                for ($card_7=0; $card_7<=$card_6; $card_7++) {

                                    $suitCount = 0;
                                    $flushSuitIndex = -1;
                                     $cardsMatched = 0;
                                    $suitKey = $suits[$card_1] + $suits[$card_2] + $suits[$card_3] + $suits[$card_4] +
                                        $suits[$card_5] + $suits[$card_6] + $suits[$card_7];

                                    if ($this->flushCheck[$suitKey] == Constants::UNVERIFIED) {
                                        do {
                                            $flushSuitIndex++;
                                            $suitCount=	($suits[$card_1] == $suits[$flushSuitIndex] ? 1 : 0) +
                                                        ($suits[$card_2] == $suits[$flushSuitIndex] ? 1 : 0) +
                                                        ($suits[$card_3] == $suits[$flushSuitIndex] ? 1 : 0) +
                                                        ($suits[$card_4] == $suits[$flushSuitIndex] ? 1 : 0) +
                                                        ($suits[$card_5] == $suits[$flushSuitIndex] ? 1 : 0) +
                                                        ($suits[$card_6] == $suits[$flushSuitIndex] ? 1 : 0) +
                                                        ($suits[$card_7] == $suits[$flushSuitIndex] ? 1 : 0);
                                            $cardsMatched += $suitCount;
                                        } while ($cardsMatched < 3 && $flushSuitIndex < 4);

                                        //7-card flush check means flush
                                        if($suitCount>4)
                                            $this->flushCheck[$suitKey] = $suits[$flushSuitIndex];
                                        else
                                            $this->flushCheck[$suitKey] = Constants::NOT_A_FLUSH;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    /**
     * Gets the numerical rank of the best 5 card combination from 7 cards
     */
    public function evaluateSeven($card1, $card2, $card3, $card4, $card5, $card6, $card7)
    {
        if(is_object($card1)) {
            $card1 = $card1->intVal();
            $card2 = $card2->intVal();
            $card3 = $card3->intVal();
            $card4 = $card4->intVal();
            $card5 = $card5->intVal();
            $card6 = $card6->intVal();
            $card7 = $card7->intVal();
        }

        $faceKey = $this->face[$card1] +
            $this->face[$card2] +
            $this->face[$card3] +
            $this->face[$card4] +
            $this->face[$card5] +
            $this->face[$card6] +
            $this->face[$card7];

        $flushCheckKey = $faceKey & Constants::SUIT_BIT_MASK;
        $flushSuit = $this->flushCheck[$flushCheckKey];

        if ($flushSuit < 0) {
            $faceKey = $faceKey >> Constants::NON_FLUSH_BIT_SHIFT;

            return $this->rank[$faceKey];
        } else {
            $faceKey = ($this->suit[$card1] == $flushSuit ? $this->flush[$card1] : 0) +
                  ($this->suit[$card2] == $flushSuit ? $this->flush[$card2] : 0) +
                  ($this->suit[$card3] == $flushSuit ? $this->flush[$card3] : 0) +
                  ($this->suit[$card4] == $flushSuit ? $this->flush[$card4] : 0) +
                  ($this->suit[$card5] == $flushSuit ? $this->flush[$card5] : 0) +
                  ($this->suit[$card6] == $flushSuit ? $this->flush[$card6] : 0) +
                  ($this->suit[$card7] == $flushSuit ? $this->flush[$card7] : 0);

            return $this->flushRank[$faceKey];
        }
    }

    /**
     * Gets the numerical rank of a given 7-card hand.
     */
    public function evaluate($cards)
    {
        if(is_string($cards))
            $cards = \SpecialK\Card::parseHand($cards);

        if(count($cards) == 7)

            return $this->evaluateSeven($cards[0], $cards[1], $cards[2], $cards[3], $cards[4], $cards[5], $cards[6]);
        else
            throw new \InvalidArgumentException("Must provide 7 cards");
    }

    /**
     * Compare two hands, returns -1, 0, 1
     */
    public function compare($hand1, $hand2)
    {
        return strcmp($this->evaluate($hand1), $this->evaluate($hand2));
    }
}
