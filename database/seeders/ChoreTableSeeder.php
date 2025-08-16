<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ChoreTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('chore')->delete();
        
        \DB::table('chore')->insert(array (
            0 => 
            array (
                'id' => 1,
                'title' => 'Taking out the Trash',
                'points' => 5,
                'catergory' => 'trash',
                'created_at' => '2025-08-12 00:05:16',
                'updated_at' => '2025-08-12 00:05:16',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'title' => 'Mopping',
                'points' => 10,
                'catergory' => 'floor',
                'created_at' => '2025-08-12 00:05:33',
                'updated_at' => '2025-08-12 00:05:33',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}