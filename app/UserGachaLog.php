<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use App\AppConstants;

class UserGachaLog extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'user_gacha_logs';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['user_id', 'gacha_type_id','coin_spend', 'item_id', 'item_rarity'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = [];

	public function log($user_id, $gacha_type_id, $coin_spend, $item_id, $rarity)
	{
		$log_item = UserGachaLog::create([
			'user_id' 		=> 	$user_id,
			'gacha_type_id' =>	$gacha_type_id,
			'coin_spend' 	=>	$coin_spend,
			'item_id' 		=>	$item_id,
			'item_rarity' 	=>	$rarity
		]);

		$log_item->save();
		return $log_item;
	}

	public function get_last_free_draw_by_keys($user_id, $gacha_type_id) {
		return UserGachaLog::where(
			'user_id', '=', $user_id)->where(
			'gacha_type_id', '=', $gacha_type_id)->where(
			'coin_spend', '=', 0)->orderBy('created_at', 'desc')->first();
	}

	
	public function get_today_box_gacha_draw($user_id, $gacha_type_id) {
		$start_of_today = date('Y-m-d').' '.AppConstants::BOX_GACHA_RESET_TIME;
		return UserGachaLog::where(
			'user_id', '=', $user_id)->where(
			'gacha_type_id', '=', $gacha_type_id)->where(
			'created_at', '>=', $start_of_today)->get();
	}

}