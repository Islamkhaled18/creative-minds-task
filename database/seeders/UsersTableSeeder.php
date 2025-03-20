<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            'name'     => 'Islam Khaled',
            'email'    => 'islam@gmail.com',
            'password' => bcrypt('123456789'),
        ];

        User::create($users);

    }
}
