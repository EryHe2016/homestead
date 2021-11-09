<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->count(50)->create();

        $user = User::find(1);
        $user->name = 'ery.he';
        $user->email = 'ery.he@feisu.com';
        $user->password = bcrypt('ery0704');
        $user->save();
    }
}
