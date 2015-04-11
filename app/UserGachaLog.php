<?php namespace App;

use Illuminate\Database\Eloquent\Model;

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
	protected $fillable = ['user_id', 'gacha_type_id','coin_spend'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = [];

	public function get_last_free_draw_by_keys($user_id, $gacha_type_id) {
		return UserGachaLog::where(
			'user_id', '=', $user_id)->where(
			'gacha_type_id', '=', $gacha_type_id)->where(
			'coin_spend', '=', 0)->first();
	}

	public function log($user_id, $gacha_type_id, $coin_spend)
	{
		$log_item = UserGachaLog::create([
			'user_id' 		=> 	$user_id,
			'gacha_type_id' =>	$gacha_type_id,
			'coin_spend' 	=>	$coin_spend
		]);

		$log_item->save();
		return $log_item;
	}
}