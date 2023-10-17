<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $query = "INSERT INTO currencies (name) VALUES ('jpy'), ('usd'), ('gbp'), ('eur'), ('sgd'), ('kwd'), ('bhd'), ('aud'), ('chf'), ('gip')";

        DB::statement($query);
    }
}
