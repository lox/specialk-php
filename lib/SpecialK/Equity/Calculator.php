<?php

namespace SpecialK\Equity;

use \SpecialK\Card;
use \SpecialK\CardSet;

class Calculator
{
    public function calculate($hands, $board=null, $dead=null, $trials=100000)
    {
        $cards = CardSet::construct();
        $count = 5;

        foreach($hands as $idx=>$hand) {
            printf("HAND %d: %s\n", $idx, $hand);
            $cards = $cards->difference($hand);
        }

        if(!is_null($board)) {
            printf("BOARD %s\n", $cards);
            $cards = $cards->difference($board);
            $count -= $cards->count();
        }

        if(!is_null($dead)) {
            $cards = $cards->difference($dead);
        }

        /*
        // enumerate
        $cards->combinations($count, function($c1, $c2, $c3, $c4, $c5) use(&$counter) {
            if($counter % 100000 == 0) {
                printf("%s\n", number_format($counter));
                ob_flush();
            }

            $counter++;
        });

        var_dump($count);
         */
    }





}
