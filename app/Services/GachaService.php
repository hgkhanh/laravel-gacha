<?php namespace App\Services;

use App\Gacha;
use App\Item;
use App\UserItem;
use Illuminate\Support\Facades\Auth;
use App\User;

class GachaService {

	protected $user_model;
	protected $gacha_model;
	protected $item_model;
	protected $user_item_model;

	public function __construct()
    {
        $this->user_model = new User();
        $this->gacha_model = new Gacha();
        $this->item_model = new Item();
        $this->user_item_model = new UserItem();
    }

	// To be Overrided by child
	public function can_draw_free($gacha_type_id)
	{
		return false;
	}
	/**
	 * process to draw gacha
	 * and give new item to user
	 *
	 * @return result_item
	 */
	public function draw_gacha($gacha_type_id)
	{
		$odd_list = $this->gacha_model->get_odd_list_by_id($gacha_type_id);
		$rarity = $this->draw_rarity($odd_list);
		return $this->draw_item($rarity);
	}

	/**
	 * input array odd_list [X,Y,Z,...]
	 * X is an array with (name) of rarity and (probability)
	 *
	 * @return rarity name
	 */
	public function draw_rarity($odd_list)
	{
		$rate_list = array_values($odd_list);
		$max_number = array_sum($rate_list);
		$number = mt_rand(0, $max_number - 1);

		$hit_lot = false;
		$hit_range = array();
		$from_rate = 0;
		foreach ($odd_list as $index => $lot) 
		{
			$to_rate = $from_rate + $lot;
			$hit_range[] = array($from_rate, $to_rate);
			if ($from_rate <= $number && $number < $to_rate)
			{
				$hit_lot = $index;
				break;
			}
			else
			{
				$from_rate += $lot;
			}
		}
		return $hit_lot;
	}

	public function draw_item($rarity)
	{
		//Get random item with given rarity 
		$item_rarity_code = array_search($rarity,Gacha::RARITY_NAME);
		$odd_list = $this->item_model->get_item_by_rarity($item_rarity_code);
		
		$result_item = $odd_list[mt_rand(0, count($odd_list) - 1)];

		//create user_item row or increase item number of existing row
		$this->user_item_model->add_item(Auth::user()->id, $result_item);
		return $result_item;
	}


}