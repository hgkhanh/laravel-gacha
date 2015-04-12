<?php namespace App\Services;

use DB;
use App\AppConstants;
use App\Gacha;
use App\Services\GachaService;
use App\UserGachaLog;
use Illuminate\Support\Facades\Auth;

class BoxGachaService extends GachaService {

	protected $user_gacha_log_model;
	
	public function __construct()
    {
    	parent::__construct();
		$this->user_gacha_log_model = new UserGachaLog();
    }

	/**
	 * process to draw gacha
	 * and give new item to user
	 *
	 * @return result_item
	 */
	public function draw_gacha($gacha_type_id)
	{
		//calculate odd list
		$odd_list = $this->gacha_model->get_odd_list_by_id($gacha_type_id);
			// list of items drew
		$draw_history = $this->user_gacha_log_model->get_today_box_gacha_draw(Auth::user()->id, $gacha_type_id);
			// one item accounts for how many % of the box.
			// e.g: box size = 100, one item accounts for 1% of the box
		$item_percent = AppConstants::GACHA_PROB_MAX/AppConstants::BOX_GACHA_POOL_SIZE;
			// then for each drew item, deduct that much of their percent in the odd_list
		foreach ($draw_history as $draw) {
			switch ($draw['item_rarity']) {
				case AppConstants::ITEM_TYPE_COMMON:
					$odd_list["common_prob"] -= $item_percent;
					break;
				case AppConstants::ITEM_TYPE_UNCOMMON:
					$odd_list["uncommon_prob"] -= $item_percent;
					break;
				case AppConstants::ITEM_TYPE_RARE:
					$odd_list["rare_prob"] -= $item_percent;
					break;
				case AppConstants::ITEM_TYPE_SRARE:
					$odd_list["super_rare_prob"] -= $item_percent;
					break;
				default:
					break;
			}
		}
		//Draw with above odd_list
		$rarity = $this->draw_rarity($odd_list);
		return $this->draw_item($rarity);
	}

	public function process_box_gacha_draw($user_id, $gacha_type_id){
		$gacha_price = $this->get_gacha_price($gacha_type_id);
		$current_coin = $this->user_model->get_current_user_coin();
		// not free draw ?
			//not enough money ? return
		if($gacha_price >= $current_coin && $gacha_price !== 0){
			$gacha_result = array();
			$gacha_result['error'] = 'Not enough Coin.';
			return $gacha_result;
		}

		// START TRANSACTION
		$transaction_result = DB::transaction(function() use ($user_id, $gacha_type_id, $gacha_price)
		{
			//coin deduct
			$result_coin = $this->user_model->spend_coin($gacha_price);

			//draw gacha
			$gacha_result = $this->draw_gacha($gacha_type_id);
			$gacha_result['price'] = $gacha_price;
			$gacha_result['current_coin'] = $result_coin;

			//log
			$result_log =$this->user_gacha_log_model->log(
				$user_id, $gacha_type_id, $gacha_price,
				$gacha_result->id, $gacha_result->rarity);

			return $gacha_result;	
		});
		//END TRANSACTION

		return $transaction_result;

	}

}