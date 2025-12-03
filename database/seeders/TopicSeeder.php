<?php

namespace Database\Seeders;

use App\Models\Board;
use App\Models\Member;
use App\Models\Message;
use App\Models\Topic;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TopicSeeder extends Seeder
{
    private int $globalTimestamp;

    public function run(): void
    {
        Topic::unsetEventDispatcher();
        Message::unsetEventDispatcher();

        $members = Member::all();
        $boards = Board::all();

        if ($members->isEmpty() || $boards->isEmpty()) {
            return;
        }

        $this->globalTimestamp = CarbonImmutable::parse('-2 years')->getTimestamp();

        $boards->each(function ($board) use ($members) {
            Topic::factory(mt_rand(3, 6))
                ->recycle($members)
                ->create([
                    'id_board' => $board->id_board,
                ]);
        });

        Topic::query()
            ->orderBy('id_topic')
            ->chunkById(50, function ($topics) use ($members) {
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

                foreach ($topics as $topic) {
                    $this->createMessagesForTopic($topic, $state);
                }
            });
    }

    private function createMessagesForTopic($topic, $state): void
    {
        $totalMessages = mt_rand(4, 16);
        $chunkSize = 100;

        Message::factory(1)
            ->state($state)
            ->withSequentialDate($this->globalTimestamp)
            ->withRandomImage('bbc', 'body')
            ->create([
                'id_topic' => $topic->id_topic,
                'id_board' => $topic->id_board,
            ]);

        for ($i = 0; $i < $totalMessages; $i += $chunkSize) {
            $currentChunkSize = min($chunkSize, $totalMessages - $i);

            $messageFactory = Message::factory($currentChunkSize)
                ->state($state)
                ->withSequentialDate($this->globalTimestamp);

            $messages = $messageFactory->raw([
                'id_topic' => $topic->id_topic,
                'id_board' => $topic->id_board,
            ]);

            if ($currentChunkSize === 1) {
                $messages = [$messages];
            }

            usort($messages, fn($a, $b) => $a['poster_time'] <=> $b['poster_time']);

            Message::insert($messages);
        }

        $this->updateStats();
    }

    protected function updateStats(): void
    {
        $memberPosts = DB::table('messages')
            ->select('id_member', DB::raw('COUNT(*) as total_posts'))
            ->groupBy('id_member')
            ->get();

        foreach ($memberPosts as $record) {
            DB::table('members')
                ->where('id_member', $record->id_member)
                ->update(['posts' => $record->total_posts]);
        }

        $firstMessages = DB::table('messages')
            ->select('id_topic', DB::raw('MIN(id_msg) as first_msg'))
            ->groupBy('id_topic')
            ->get();

        foreach ($firstMessages as $record) {
            DB::table('topics')
                ->where('id_topic', $record->id_topic)
                ->update(['id_first_msg' => $record->first_msg]);
        }

        $topicAgg = DB::table('messages')
            ->select('id_topic', DB::raw('COUNT(*) as total'), DB::raw('MAX(id_msg) as last_msg'))
            ->groupBy('id_topic')
            ->get();

        $topicRows = $topicAgg->map(static function ($r) {
            return [
                'id_topic'    => $r->id_topic,
                'num_replies' => max((int) $r->total - 1, 0),
                'id_last_msg' => $r->last_msg,
            ];
        });

        DB::table('topics')->upsert(
            $topicRows->all(),
            ['id_topic'],
            ['num_replies', 'id_last_msg']
        );

        $boardTopics = DB::table('topics')
            ->select('id_board', DB::raw('COUNT(*) as topics'))
            ->groupBy('id_board')
            ->get();

        foreach ($boardTopics as $record) {
            DB::table('boards')
                ->where('id_board', $record->id_board)
                ->update(['num_topics' => $record->topics]);
        }

        $boardPosts = DB::table('messages')
            ->select('id_board', DB::raw('COUNT(*) as posts'))
            ->groupBy('id_board')
            ->get();

        foreach ($boardPosts as $record) {
            DB::table('boards')
                ->where('id_board', $record->id_board)
                ->update(['num_posts' => $record->posts]);
        }
    }
}
