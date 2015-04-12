<?php namespace App\Http\Controllers;

use DB;
use App\Gacha;
use App\User;
use App\Services\GachaService;
use App\Services\ProbGachaService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Logging\Log;

class GachaController extends Controller {

    private $prob_gacha_service;
    private $user_model;

    public function __construct()
    {
        $this->middleware('auth');
        $this->prob_gacha_service = new ProbGachaService();
        $this->user_model = new User();
    }

	public function index()
	{
        $current_coin = $this->user_model->get_current_user_coin();
		return view('gacha')->with('current_coin',$current_coin);
	}

	public function draw_normal_gacha ()
	{
        $gacha_result = $this->prob_gacha_service->process_prob_gacha_draw(Auth::user()->id, Gacha::NORMAL_GACHA_ID);
        if(!isset($gacha_result['error'])){
    		$response = array(
                'status' => 'success',
                'msg' => 'draw_normal_gacha call Successfully',
                'gacha' => $gacha_result,
            );
        }
        else{
            $response = array(
                'status' => 'fail',
                'msg' => $gacha_result['error']
            );
            
        }
        return response()->json($response);
	}

	public function draw_expensive_gacha ()
	{
		$gacha_result = $this->prob_gacha_service->process_prob_gacha_draw(Auth::user()->id, Gacha::EXPENSIVE_GACHA_ID);
        if(!isset($gacha_result['error'])){
            $response = array(
                'status' => 'success',
                'msg' => 'draw_expensive_gacha call Successfully',
                'gacha' => $gacha_result,
            );
        }
        else{
            $response = array(
                'status' => 'fail',
                'msg' => $gacha_result['error']
            );
            
        }
        return response()->json($response);
	}

	public function draw_box_gacha ()
	{
		$response = array(
            'status' => 'success',
            'msg' => 'draw_box_gacha call Successfully',
        );
        return response()->json($response);
	}
}