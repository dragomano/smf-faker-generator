<?php

namespace Database\Seeders;

use App\Models\Member;
use App\Models\Membergroup;
use Illuminate\Database\Seeder;

class MemberSeeder extends Seeder
{
    public function run(): void
    {
        Member::factory()->create([
            'member_name' => 'Test',
            'date_registered' => strtotime(now()),
            'id_group' => 1,
            'real_name' => 'Test',
            'passwd' => Member::getHashedPassword('Test', 'test'),
            'email_address' => 'admin@test.com',
        ]);

        $groups = collect(Membergroup::where('id_group', '!=', 1)->get());

        Member::factory(50)
            ->sequence(fn() => ['id_group' => $groups->random()])
            ->create();
    }
}
