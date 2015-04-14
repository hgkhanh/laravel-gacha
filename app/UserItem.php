<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class UserItem extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'user_items';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['user_id', 'item_id', 'number'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = [];

	public function get_user_item($user_id) {
		return UserItem::where('user_id', '=', $user_id)->simplePaginate(10);
	}

	public function get_user_item_by_keys($user_id, $item_id) {
		return UserItem::where('user_id', '=', $user_id)->where('item_id', '=', $item_id)->first();
	}

	public function add_item($user_id, $result_item)
	{
		$user_item = $this->get_user_item_by_keys($user_id, $result_item->id);
		if (isset($user_item))
		{
			$user_item->number++;
			$user_item->updated_at = date('Y-m-d H:i:s');
			UserItem::where('user_id', '=', $user_item->user_id)->where('item_id', '=', $user_item->item_id)->update($user_item['attributes']);
			return $result_item;
		}
		else
		{
			$user_item = new UserItem(array(
				'user_id'		=> $user_id,
				'item_id'		=> $result_item->id,
				'number'		=> 1,
			));
			$user_item->save();
			return $result_item;
		}
	}
}
