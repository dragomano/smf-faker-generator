<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        DB::disableQueryLog();
        $this->call(ForumSeeder::class);
        //$this->call(PortalBlockSeeder::class);
        //$this->call(PortalPageSeeder::class);
    }
}
