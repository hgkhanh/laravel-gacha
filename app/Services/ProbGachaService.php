<?php namespace App\Services;

use DB;
use App\Gacha;
use App\Services\GachaService;
use App\UserGachaLog;
use Illuminate\Support\Facades\Auth;

class ProbGachaService extends GachaService {

	protected $user_gacha_log_model;
	
	public function __construct()
    {
    	parent::__construct();
		$this->user_gacha_log_model = new UserGachaLog();
    }

	public function can_draw_free($gacha_type_id){
		$free_draw_log = $this->user_gacha_log_model->get_last_free_draw_by_keys(Auth::user()->id, $gacha_type_id);
		if(isset($free_draw_log)){ 
			$gacha = $this->gacha_model->get_by_id($gacha_type_id);
			if(isset($gacha)){
				$time_diff = Utils::get_time_diff_from_now($free_draw_log->created_at);
				if($time_diff < $gacha->free_draw_reset_duration)
					return false;
				else
					return true;
				
			}
		}
		else{ // no previous log, can draw free
			return true;
		}
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

	public function process_prob_gacha_draw($user_id, $gacha_type_id){
		$gacha_price = $this->get_gacha_price($gacha_type_id);
		$current_coin = $this->user_model->get_current_user_coin();
		// not free draw ?
			//not enough money ? return
		if($gacha_price !== 0 && $gacha_price >= $current_coin){
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