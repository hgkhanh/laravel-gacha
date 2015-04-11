<?php namespace App\Services;

class Utils  {
	public static function get_time_diff_from_now($past_time_str){
		$current_timestamp = strtotime(date('Y-m-d H:i:s'));
		$past_time = strtotime($past_time_str);
		return $current_timestamp - $past_time;
	}

}