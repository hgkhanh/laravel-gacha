<?php namespace App;


class AppConstants {
	const START_COIN_AMOUNT 		= 5000;
	const COIN_PER_SEC				= 1;

	const ITEM_TYPE_COMMON			= 1;
	const ITEM_TYPE_UNCOMMON		= 2;
	const ITEM_TYPE_RARE			= 3;
	const ITEM_TYPE_SRARE			= 4;
	const ITEM_TYPES_LIST			= array(
										self::ITEM_TYPE_COMMON, 
										self::ITEM_TYPE_UNCOMMON, 
										self::ITEM_TYPE_RARE, 
										self::ITEM_TYPE_SRARE
										);
}
