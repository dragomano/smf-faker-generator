<?php

namespace Database\Seeders;

use App\Models\LpCategory;
use App\Models\LpComment;
use App\Models\LpPage;
use App\Models\LpParam;
use App\Models\LpTag;
use App\Models\LpTitle;
use App\Models\Member;
use Illuminate\Database\Seeder;

class PortalPageSeeder extends Seeder
{
    public function run(): void
    {
        $members = Member::all();

        if ($members->isEmpty()) {
            $members = Member::factory(10)->create();
        }

        $categories = LpCategory::all();

        $tags = LpTag::all();

        $pages = LpPage::factory(200)
            ->recycle($categories)
            ->recycle($members)
            ->withRandomImage()
            ->create();

        $pages->each(function ($page) use ($tags, $members) {
            LpTitle::factory()->createMany([
                [
                    'item_id' => $page->page_id,
                    'type' => 'page',
                    'lang' => 'english',
                ],
                [
                    'item_id' => $page->page_id,
                    'type' => 'page',
                    'lang' => 'russian',
                ],
            ]);

            $randomTags = $tags->random(rand(1, 5));
            $randomTags->each(function ($tag) use ($page) {
                $page->tags()->attach($tag->tag_id);
            });

            LpParam::factory()->createMany([
                [
                    'item_id' => $page->page_id,
                    'type' => 'page',
                    'name' => 'show_author_and_date',
                    'value' => true,
                ],
                [
                    'item_id' => $page->page_id,
                    'type' => 'page',
                    'name' => 'show_related_pages',
                    'value' => true,
                ],
                [
                    'item_id' => $page->page_id,
                    'type' => 'page',
                    'name' => 'allow_comments',
                    'value' => true,
                ],
            ]);

            LpComment::factory(mt_rand(0, 20))
                ->recycle($members)
                ->create([
                    'page_id' => $page->page_id,
                ]);
        });

        $comments = LpComment::all();
        $childComments = $comments->each(function ($comment) {
            LpComment::factory(mt_rand(0, 3))
                ->sequence(
                    fn() => [
                        'page_id' => $comment->page_id,
                        'parent_id' => $comment->id,
                    ]
                )
                ->createdFrom($comment->created_at)
                ->create();
        });

        $childComments->each(function ($comment) {
            LpComment::factory(mt_rand(0, 3))
                ->sequence(
                    fn() => [
                        'page_id' => $comment->page_id,
                        'parent_id' => $comment->id,
                    ]
                )
                ->createdFrom($comment->created_at)
                ->create();
        });
    }
}
