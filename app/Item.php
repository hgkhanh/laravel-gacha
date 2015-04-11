<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'items';

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

	public function get_item_by_rarity($rarity) {
		if (is_array($rarity))
		{
			return Item::whereIn('rarity', $rarity)->get();
		}
		else
		{
			return Item::where('rarity', '=', $rarity)->get();
		}
	}

}
