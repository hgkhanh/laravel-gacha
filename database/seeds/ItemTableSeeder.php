<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class ItemTableSeeder extends Seeder {

    public function run()
    {
        DB::table('items')->delete();

        $item_name_list = array(
	        "Arcane Ring",
			"Armlet of Mordiggian",
			"Assault Cuirass",
			"Blink Dagger",
			"Bloodstone",
			"Oblivion Staff",
			"Ogre Club",
            "Blade of Alacrity",
            "Staff of Wizardry",
			"Orchid Malevolence",
			"Divine Rapier",
			"Sange and Yasha",
			"Satanic",
			"Orb of Venom",
			"Drum of Endurance",
			"Medallion of Courage",
			"Smoke of Deceit",
			"Veil of Discord",
            "Scyther of Vyse",
            "Gem of True Sight",
            "Heart of Tarrasque",
            "Mask of Madness",
            "Black King Bar",
            "Hood of Defiance",
            "Diffusal Blade",
            "Linken's Sphere",
            "Shiva's Guard",
            "Manta Style",
            "Abyssal Blade",
            "Eul's Scepter of Divinity",
            "Aghanim's Scepter",
            "Pipe of Insight",
            "Hand of Midas",
            "Ring of Basilius",
            "Urn of Shadows"
		 );

        $rarity_name = array(
        	'1' => 'Common', 
        	'2' => 'Uncommon', 
        	'3' => 'Rare', 
        	'4' => 'Super Rare'
        );
        $items_array = array();
        $id = 1;
        foreach ($item_name_list as $item_name_entry) {

        	for ($rarity_idx = 1; $rarity_idx<=4 ; $rarity_idx++) {

                $item_name = "[".$rarity_name[$rarity_idx] . "] " . $item_name_entry;
                $item_desc = "This is description of ".$item_name;

        		$item = [
                    'id'  => $id,
        			'name' => $item_name,
        			'description' => $item_desc,
        			'rarity' => $rarity_idx,
                    'created_at' => date( 'Y-m-d H:i:s', time() ),
                    'updated_at' => date( 'Y-m-d H:i:s', time() )
        		];


        		array_push($items_array, $item);
                $id++;
        	}

        }
        DB::table('items')->insert($items_array);
    }

}