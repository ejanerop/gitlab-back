<?php

namespace Database\Seeders;

use App\Models\User;
use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

use function PHPUnit\Framework\throwException;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if((env('DEFAULT_USER') !== null && env('DEFAULT_USER') !== '')
        && (env('DEFAULT_USER_PASSWORD') !== null && env('DEFAULT_USER_PASSWORD') !== '')
        && (env('DEFAULT_USER_GITLAB_TOKEN') !== null && env('DEFAULT_USER_GITLAB_TOKEN') !== '')
        && (env('DEFAULT_USER_EMAIL') !== null && env('DEFAULT_USER_EMAIL') !== ''))
        {
            $user = new User();
            $user->name = env('DEFAULT_USER');
            $user->email = env('DEFAULT_USER_EMAIL');
            $user->gitlab_token = env('DEFAULT_USER_GITLAB_TOKEN');
            $user->password = Hash::make(env('DEFAULT_USER_PASSWORD'));
            $user->save();
        } else {
            $this->command->error('Configure environment variables.');
        }


    }
}
