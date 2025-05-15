<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';
    
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\User::create([
    	    'username' => 'admin',
	        'email' => 'admin@example.com',
	        'role_id' => 1,
            // 'email_verified_at' => now(),
            'created_by' => 1,
            'modified_by' => 0,
            'department_id' => 1,
	        'password' => bcrypt('$oisclondon#'), // password
	        // 'remember_token' => Str::random(10),
        ]);
        // $this->call(UsersTableSeeder::class);
    }
}
