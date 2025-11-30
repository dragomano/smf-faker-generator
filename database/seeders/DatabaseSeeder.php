<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        DB::disableQueryLog();

        $this->call(MembergroupSeeder::class);
        $this->call(MemberSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(BoardSeeder::class);
        $this->call(TopicSeeder::class);
        $this->call(PortalBlockSeeder::class);
        $this->call(PortalCategorySeeder::class);
        $this->call(PortalTagSeeder::class);
        $this->call(PortalPageSeeder::class);
        $this->call(PortalCommentSeeder::class);
    }
}
