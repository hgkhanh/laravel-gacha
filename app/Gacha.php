<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Gacha extends Model {

    const NORMAL_GACHA_ID = 1001;
    const EXPENSIVE_GACHA_ID = 1002;
    const BOX_GACHA_ID = 2001;
    const RARITY_NAME = array(
		AppConstants::ITEM_TYPE_COMMON	=> 'common_prob',
		AppConstants::ITEM_TYPE_UNCOMMON=> 'uncommon_prob', 
		AppConstants::ITEM_TYPE_RARE    => 'rare_prob', 
		AppConstants::ITEM_TYPE_SRARE	=> 'super_rare_prob'
		);
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'gachas';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = [];


	public function get_odd_list_by_id($gacha_type_id){
    	$odd_list = Gacha::where('id','=',$gacha_type_id)->select(
			Gacha::RARITY_NAME[1],
			Gacha::RARITY_NAME[2],
			Gacha::RARITY_NAME[3],
			Gacha::RARITY_NAME[4]
    	)->first()->toArray();
    	
    	return $odd_list;
    }

    public function get_by_id($gacha_type_id){
    	return Gacha::find($gacha_type_id);
    }


}
