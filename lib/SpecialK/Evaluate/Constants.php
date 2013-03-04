<?php

namespace SpecialK\Evaluate;

class Constants
{
    const BIG_NUMBER=700000000;
    const DECK_SIZE=52;

    const NUMBER_OF_SUITS=4;
    const NUMBER_OF_FACES=13;

    const SPADE=0;
    const HEART=1;
    const DIAMOND=8;
    const CLUB=57;

    const TWO_FIVE=0;
    const THREE_FIVE=1;
    const FOUR_FIVE=5;
    const FIVE_FIVE=22;
    const SIX_FIVE=94;
    const SEVEN_FIVE=312;
    const EIGHT_FIVE=992;
    const NINE_FIVE=2422;
    const TEN_FIVE=5624;
    const JACK_FIVE=12522;
    const QUEEN_FIVE=19998;
    const KING_FIVE=43258;
    const ACE_FIVE=79415;

    const TWO_FLUSH=1;
    const THREE_FLUSH=2;
    const FOUR_FLUSH=4;
    const FIVE_FLUSH=8;
    const SIX_FLUSH=16;
    const SEVEN_FLUSH=32;
    const EIGHT_FLUSH=64;
    const NINE_FLUSH=128; // 64+32+16+8+4+2+1+1;
    const TEN_FLUSH=255; // 128+64+32+16+8+4+2+1;
    const JACK_FLUSH=508; // 255+128+64+32+16+8+4+1;
    const QUEEN_FLUSH=1012; // 508+255+128+64+32+16+8+1;
    const KING_FLUSH=2016; // 1012+508+255+128+64+32+16+1;
    const ACE_FLUSH=4016; // 2016+1012+508+255+128+64+32+1

    const MAX_FIVE_NONFLUSH_KEY_INT=360918; // 4*ACE_FIVE+KING_FIVE;
    const MAX_SEVEN_FLUSH_KEY_INT=7999; // ACE_FLUSH+KING_FLUSH+QUEEN_FLUSH+JACK_FLUSH+TEN_FLUSH+NINE_FLUSH+EIGHT_FLUSH;

    //_SEVEN tag suppressed
    const TWO=0;
    const THREE=1;
    const FOUR=5;
    const FIVE=22;
    const SIX=98;
    const SEVEN=453;
    const EIGHT=2031;
    const NINE=8698;
    const TEN=22854;
    const JACK=83661;
    const QUEEN=262349;
    const KING=636345;
    const ACE=1479181;
    //end of _SEVEN tag suppressed

    const MAX_NONFLUSH_KEY_INT=7825759; // 4*ACE+3*KING;
    const MAX_FLUSH_KEY_INT=7999; // ACE_FLUSH+KING_FLUSH+QUEEN_FLUSH+JACK_FLUSH+TEN_FLUSH+NINE_FLUSH+EIGHT_FLUSH;
    const MAX_KEY_INT=62598246241; // MAX_NONFLUSH_KEY_INT+MAX_FLUSH_KEY_INT;
    const MAX_FLUSH_CHECK_SUM=399; // 7*CLUB;

    const L_WON=-1;
    const R_WON=1;
    const DRAW=0;

    const CIRCUMFERENCE_FIVE=187853;
    const CIRCUMFERENCE_SEVEN=4565145;

    //Bit masks
    const SUIT_BIT_MASK=511;
    const NON_FLUSH_BIT_SHIFT=9;

    /////////
    //The following are used with NSAssert for
    //debugging, ignored by release mode
    const RANK_OF_A_WORST_HAND=0;
    const RANK_OF_WORST_STRAIGHT=5854;
    const RANK_OF_BEST_STRAIGHT=5863;
    const RANK_OF_WORST_FLUSH=5864;
    const RANK_OF_BEST_FLUSH=7140;
    const RANK_OF_WORST_STRAIGHT_FLUSH=7453;
    const RANK_OF_BEST_STRAIGHT_FLUSH=7462;
    const RANK_OF_A_BEST_HAND=RANK_OF_BEST_STRAIGHT_FLUSH;

    const KEY_COUNT=53924;
    const NON_FLUSH_KEY_COUNT=49205;
    const FLUSH_KEY_COUNT=4719;

    //Used in flush checking
    const UNVERIFIED=-2;
    const NOT_A_FLUSH=-1;
    const NO_FLUSH_POSSIBLE=-1;
    /////////

    //Limits
    const MAX_NUMBER_OF_UNDEALT_CARDS=48; //DECK_SIZE-4;
    const MAX_NUMBER_OF_PLAYERS=8;

    //Equity
    const CAKE=840;
    const EQUITY_TWO=1438335360;
    const EQUITY_THREE=1151433360;
    const EQUITY_FOUR=912246720;
    const EQUITY_FIVE=714561120;
    const EQUITY_SIX=552726720;
    const EQUITY_SEVEN=421631280;
    const EQUITY_EIGHT=316673280;
}
