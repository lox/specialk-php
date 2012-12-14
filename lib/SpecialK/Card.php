<?php

namespace SpecialK;

/**
 * Cards are indexed in descending value from 0 - 51, from As - 2c
 */
class Card
{
	/**
	 * Parse a two-character card into an integer
	 * @return int
	 */
	public static function parse($str)
	{
		$face = array(
			'a'=>0,'k'=>1,'q'=>2,'j'=>3,'t'=>4,'9'=>5,'8'=>6,'7'=>7,'6'=>8,
			'5'=>9,'4'=>10,'3'=>11,'2'=>12
		);

		$suit = array(
			's'=>0,'h'=>1,'d'=>2,'c'=>3
		);

		$str = strtolower($str);
		return (4 * $face[$str[0]]) + $suit[$str[1]];
	}

	/**
	 * Parse a string of space delimited hands into an array of ints
	 * @return array
	 */
	public static function parseHand($str)
	{
		$hand = array();

		foreach(explode(' ', $str) as $card)
			$hand []= self::parse($card);

		return $hand;
	}
}

