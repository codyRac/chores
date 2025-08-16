<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class GroupsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('groups')->delete();
        
        \DB::table('groups')->insert(array (
            0 => 
            array (
                'id' => 1,
                'title' => 'Group One',
                'created_at' => '2025-08-12 00:10:02',
                'updated_at' => '2025-08-12 00:10:02',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}