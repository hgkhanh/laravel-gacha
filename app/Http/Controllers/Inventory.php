<?php namespace App\Http\Controllers;


use DB;
use App\User;
use App\UserItem;
use App\Item;
use Illuminate\Support\Facades\Auth;

class Inventory extends Controller {

	private $user_item_list;
    private $user_model;
    private $user_item_model;
    private $item_model_list;

	public function __construct()
    {
        $this->middleware('auth');
        $this->user_model = new User();
        $this->user_item_model = new UserItem();
        $this->item_model_list = Item::all();
    }
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//get coin
        $current_coin = $this->user_model->get_current_user_coin();

        //get user item
        $this->user_item_list = $this->user_item_model->get_user_item(Auth::user()->id);
         	//get item detail
        $this->_get_item_detail();
echo $this->user_item_list;
		return view('inventory')->with('current_coin',$current_coin)->with('user_item_list',$this->user_item_list);
	}

	private function _get_item_detail()
	{
		foreach ($this->user_item_list as &$user_item) {
			foreach ($this->item_model_list as $item_model) {
				if ($user_item->item_id == $item_model->id)
				{
					$user_item->name = $item_model->name;
					$user_item->rarity = $item_model->rarity;
					break;
				}
			}
		}
	}

}
