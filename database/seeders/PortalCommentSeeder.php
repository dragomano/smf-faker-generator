<?php

namespace Database\Seeders;

use App\Models\Member;
use App\Models\PortalComment;
use App\Models\PortalPage;
use App\Models\PortalTranslation;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PortalCommentSeeder extends Seeder
{
    private Carbon $currentDate;

    public function run(): void
    {
        PortalComment::unsetEventDispatcher();
        PortalTranslation::unsetEventDispatcher();

        $memberIds = Member::pluck('id_member')->toArray();

        if (empty($memberIds)) {
            return;
        }

        $pages = PortalPage::whereEntryType('default')->get();

        if ($pages->isEmpty()) {
            return;
        }

        $pages->each(function (PortalPage $page) use ($memberIds) {
            $this->createCommentsForPage($page, $memberIds);
        });

        $this->createTranslations();
    }

    private function createCommentsForPage(PortalPage $page, array $memberIds): void
    {
        $commentCount = mt_rand(0, 20);

        if ($commentCount === 0) {
            return;
        }

        $this->currentDate = Carbon::createFromTimestamp((int) $page->getRawOriginal('created_at'));
        $this->currentDate->addMinutes(mt_rand(10, 10080));

        $parentComments = [];

        for ($i = 0; $i < $commentCount; $i++) {
            $parentComments[] = $this->createComment(
                $page->page_id,
                0,
                $memberIds
            );

            $lastParent = end($parentComments);
            $this->createChildComments($lastParent, $memberIds);
        }
    }

    private function createChildComments(
        PortalComment $parentComment,
        array $memberIds,
        int $minCount = 0,
        int $maxCount = 3,
        int $level = 1
    ): void
    {
        $childCount = mt_rand($minCount, $maxCount);
        $children = [];

        for ($i = 0; $i < $childCount; $i++) {
            $children[] = $this->createComment(
                $parentComment->page_id,
                $parentComment->id,
                $memberIds
            );
        }

        if ($level === 1) {
            foreach ($children as $child) {
                $this->createChildComments($child, $memberIds, 1, 4, 2);
            }
        }
    }

    private function createComment(
        int $pageId,
        int $parentId,
        array $memberIds
    ): PortalComment
    {
        $this->currentDate->addMinutes(mt_rand(10, 1440));

        return PortalComment::factory()->create([
            'page_id' => $pageId,
            'parent_id' => $parentId,
            'author_id' => $memberIds[array_rand($memberIds)],
            'created_at' => $this->currentDate->timestamp,
        ]);
    }

    private function createTranslations(): void
    {
        PortalComment::query()
            ->orderBy('id')
            ->chunkById(500, function ($comments) {
                foreach ($comments as $comment) {
                    $comment->translations()->createMany([
                        [
                            'lang' => 'english',
                            'content' => fake()->unique()->paragraph,
                        ],
                        [
                            'lang' => 'russian',
                            'content' => fake('ru_RU')->unique()->paragraph,
                        ],
                    ]);
                }
            });

        $this->updatePageStats();
    }

    private function updatePageStats(): void
    {
        $pageStats = DB::table('lp_comments')
            ->select('page_id', DB::raw('COUNT(*) as total'), DB::raw('MAX(id) as last_id'))
            ->groupBy('page_id')
            ->get();

        foreach ($pageStats as $stat) {
            DB::table('lp_pages')
                ->where('page_id', $stat->page_id)
                ->update([
                    'num_comments' => $stat->total,
                    'last_comment_id' => $stat->last_id,
                ]);
        }
    }
}
