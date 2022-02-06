<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        /*
        DB::table('admin')->insert([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ]);
        */
        DB::table('users')->insert([
            'name' => 'Ganesh',
            'email' => 'ganeshkarkigk@gmail.com',
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ]);

    }
}
