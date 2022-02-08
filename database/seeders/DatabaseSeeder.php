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

        $json = "{
    \"name\": \"Untitled Form\",
    \"count\": 0,
    \"version\": null,
    \"fields\": [
      {
        \"label\": \"Name\",
        \"input_type\": \"text\",
        \"required\": true,
        \"min\": null,
        \"max\": null
      },
      {
        \"label\": \"Last Name\",
        \"input_type\": \"text\",
        \"required\": true,
        \"min\": null,
        \"max\": null
      },
      {
        \"label\": \"Enter label\",
        \"input_type\": \"text\",
        \"required\": true,
        \"min\": null,
        \"max\": null
      }
    ]
  }";
        DB::table('forms')->insert([
            'name' => 'SurveyForm',
            'specification' => $json, //todo a valid specification
            'created_by' => 1,
        ]);

        // Create a different seeder for multiple responses
        $json = [
            "name" => "Survey Form",
            "count" => 7,
            "version" => null,
            "fields" => [
                0 => [
                    "label" => "First Name",
                    "input_type" => "text",
                    "required" => true,
                    "min" => null,
                    "max" => null,
                ],
                1 => [
                    "label" => "Last Name Not Required",
                    "input_type" => "text",
                    "required" => false,
                    "min" => null,
                    "max" => null,
                ],
                2 => [
                    "label" => "Age",
                    "input_type" => "number",
                    "required" => true,
                    "min" => 18,
                    "max" => null,
                ],
                3 => [
                    "label" => "number required min",
                    "input_type" => "number",
                    "required" => true,
                    "min" => 10,
                    "max" => null,
                ],
                4 => [
                    "label" => "number not required",
                    "input_type" => "number",
                    "required" => false,
                    "min" => 10,
                    "max" => 20,
                ],
                5 => [
                    "label" => "number required max",
                    "input_type" => "number",
                    "required" => true,
                    "min" => null,
                    "max" => 90,
                ],
                6 => [
                    "label" => "number required min & max",
                    "input_type" => "number",
                    "required" => true,
                    "min" => 10,
                    "max" => 90,
                ],
            ]
        ];
        DB::table('form_responses')->insert([
            'form_id' => 1,
            'user_id' => 1,
            'response' => json_encode($json),
        ]);

    }
}
