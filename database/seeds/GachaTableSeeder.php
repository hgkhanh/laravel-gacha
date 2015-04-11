<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class GachaTableSeeder extends Seeder {

    public function run()
    {
        DB::table('gachas')->delete();

        $gachas = array(
                [
                    'id'                        =>  1001,
                    'name'                      =>  'Normal Gacha',
                    'description'               =>  'Common 70%, Uncommon 25%, Rare 4%, Super Rare 1%',
                    'price'                     =>  100,
                    'free_draw_reset_duration'  =>  3600,
                    'common_prob'               =>  '700',
                    'uncommon_prob'             =>  '250',
                    'rare_prob'                 =>  '40',
                    'super_rare_prob'           =>  '10',
                    'created_at'                =>  date( 'Y-m-d H:i:s', time() ),
                    'updated_at'                =>  date( 'Y-m-d H:i:s', time() )
                ],
                [
                    'id'                        =>  1002,
                    'name'                      =>  'Expensive Gacha',
                    'description'               =>  'Common 10%, Uncommon 50%, Rare 30%, Super Rare 10%',
                    'price'                     =>  1000,
                    'free_draw_reset_duration'  =>  86400,
                    'common_prob'               =>  '100',
                    'uncommon_prob'             =>  '500',
                    'rare_prob'                 =>  '300',
                    'super_rare_prob'           =>  '100',
                    'created_at'                =>  date( 'Y-m-d H:i:s', time() ),
                    'updated_at'                =>  date( 'Y-m-d H:i:s', time() )
                ],
                [
                    'id'                        =>  2001,
                    'name'                      =>  'Box Gacha',
                    'description'               =>  'Common 55%, Uncommon 25%, Rare 15%, Super Rare 5%',
                    'price'                     =>  500,
                    'free_draw_reset_duration'  =>  0, //no free for u !!
                    'common_prob'               =>  '550',
                    'uncommon_prob'             =>  '250',
                    'rare_prob'                 =>  '150',
                    'super_rare_prob'           =>  '50',
                    'created_at'                =>  date( 'Y-m-d H:i:s', time() ),
                    'updated_at'                =>  date( 'Y-m-d H:i:s', time() )
                ]
            );

        DB::table('gachas')->insert($gachas);
    }

}