<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('users')->delete();
        
        \DB::table('users')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'cody',
                'email' => 'cluerra@gmail.com',
                'email_verified_at' => NULL,
                'password' => '$2y$12$PILX1tOX81LMxi8lCATpAeEbU3oRwoUttSrC12QpvHPKZzIRaG.mW',
                'remember_token' => NULL,
                'created_at' => '2025-08-11 23:48:35',
                'updated_at' => '2025-08-11 23:48:35',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Emily',
                'email' => 'test@test.com',
                'email_verified_at' => NULL,
                'password' => '$2y$12$GS84p9AIblulmx0YYI10ee0VtjjrvuficfqBudtNzXGy9BIW1m4Ci',
                'remember_token' => NULL,
                'created_at' => '2025-08-12 00:30:00',
                'updated_at' => '2025-08-12 00:30:00',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}