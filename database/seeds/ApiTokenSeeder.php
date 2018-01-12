<?php

use Illuminate\Database\Seeder;

class ApiTokenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('api_tokens')->insert([
            'secret' => str_random(20),
            'public' => sha1(str_random(20)),
        ]);
    }
}
