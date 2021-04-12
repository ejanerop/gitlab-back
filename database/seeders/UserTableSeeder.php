<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->name = 'Eric';
        $user->email = 'ejanerop97@gmail.com';
        $user->gitlab_token = '8iscuLB6M_PzSAjfEwY7';
        $user->password = Hash::make('12345678');
        $user->save();
        $user->createToken('access');
    }
}
