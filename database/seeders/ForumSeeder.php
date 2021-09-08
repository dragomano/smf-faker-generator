<?php

namespace Database\Seeders;

use App\Models\Board;
use App\Models\Category;
use App\Models\Member;
use App\Models\Membergroup;
use App\Models\Message;
use App\Models\Topic;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class ForumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Member::factory()->create([
            'member_name' => 'Test',
            'date_registered' => strtotime(now()),
            'id_group' => 1,
            'real_name' => 'Test',
            'passwd' => '$2y$10$bTAgLLhjQHbLpJOUyMqtVOGW6a5j2Yw.1D4PeaSbhA7e.S1Y7vtsi', // test
            'email_address' => 'admin@test.com',
        ]);

        Membergroup::factory()->createMany([
            [
                'group_name' => 'Administrator',
                'description' => '',
                'online_color' => '#FF0000',
                'icon' => '5#iconadmin.png',
                'group_type' => 1,
            ],
            [
                'group_name' => 'Global Moderator',
                'description' => '',
                'online_color' => '#0000FF',
                'icon' => '5#icongmod.png',
            ],
            [
                'group_name' => 'Moderator',
                'description' => '',
                'icon' => '5#iconmod.png',
            ]
        ]);

        $membergroups = Membergroup::factory(10)->create();

        $members = Member::factory(mt_rand(46, 78))->state(new Sequence(
            function () use ($membergroups) {
                return ['id_group' => $membergroups->random()];
            }
        ))->create();

        $categories = Category::factory(mt_rand(3, 6))->create();

        $boards = Board::factory(mt_rand(17, 22))
            ->state(
                new Sequence(
                    function () use ($categories) {
                        return ['id_cat' => $categories->random()];
                    }
                )
            )->create();

        $topics = collect();
        $boards->each(function ($board) use ($members, $topics) {
            $topics->push(Topic::factory(mt_rand(1, 30))
                ->state(new Sequence(
                    function () use ($members) {
                        return ['id_member_started' => $members->random()];
                    }
                ))
                ->create([
                    'id_board' => $board->id_board,
                ])
            );
        });

        $topics->each(function ($topics) use ($members) {
            $state = new Sequence(
                function () use ($members) {
                    $member = $members->random();

                    return [
                        'id_member' => $member->id_member,
                        'poster_name' => $member->real_name,
                        'poster_email' => $member->email_address,
                    ];
                }
            );

            $topics->each(function ($topic) use ($state) {
                Message::factory(mt_rand(0, 12))
                    ->state($state)
                    ->create([
                        'id_topic' => $topic->id_topic,
                        'id_board' => $topic->id_board,
                    ]);
            });
        });
    }
}
