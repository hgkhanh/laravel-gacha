<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Support\Facades\Auth;
use App\Services\Utils;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['name', 'email', 'password','coin','coin_updated_at'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];

    const START_COIN = 5000;

    public function get_current_user_coin()
    {
        $user_id = Auth::user()->id;
        $user = User::find($user_id);

        $time_diff = Utils::get_time_diff_from_now($user->coin_updated_at);
        $current_coin = $user->coin + $time_diff * AppConstants::COIN_PER_SEC;
        return $current_coin;
    }

    public function spend_coin($amount)
    {
        $user_id = Auth::user()->id;
        $user = User::find($user_id);

        $time_diff = Utils::get_time_diff_from_now($user->coin_updated_at);
        $current_coin = $user->coin + $time_diff * AppConstants::COIN_PER_SEC;
        $result_coin =  $current_coin  - $amount;
        $user->coin = $result_coin;
        $user->coin_updated_at = date('Y-m-d H:i:s');
        $user->save();
        return $user->coin;
    }

}
