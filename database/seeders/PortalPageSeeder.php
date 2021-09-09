<?php

namespace Database\Seeders;

use App\Models\LpCategory;
use App\Models\LpComment;
use App\Models\LpPage;
use App\Models\LpParam;
use App\Models\LpTag;
use App\Models\LpTitle;
use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class PortalPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $members = Member::all();

        if (! $members) {
            $members = Member::factory(10)->create();
        }

        $categories = LpCategory::factory(10)->create();

        $tags = LpTag::factory(30)->create();

        $pages = LpPage::factory(200)->withRandomImage()->state(new Sequence(function () use ($categories, $members) {
            return [
                'category_id' => $categories->random(),
                'author_id' => $members->random()
            ];
        }))->create();

        $pages->each(function ($page) use ($tags, $members) {
            LpTitle::factory()->createMany([
                [
                    'item_id' => $page->page_id,
                    'type' => 'page',
                    'lang' => 'english',
                    'title' => 'English title #' . $page->page_id
                ],
                [
                    'item_id' => $page->page_id,
                    'type' => 'page',
                    'lang' => 'russian',
                    'title' => 'Заголовок на русском #' . $page->page_id
                ],
            ]);

            LpParam::factory()->createMany([
                [
                    'item_id' => $page->page_id,
                    'type' => 'page',
                    'name' => 'keywords',
                    'value' => implode(',', $tags->pluck('tag_id')->random(rand(0, 4))->toArray())
                ],
                [
                    'item_id' => $page->page_id,
                    'type' => 'page',
                    'name' => 'show_author_and_date',
                    'value' => true
                ],
                [
                    'item_id' => $page->page_id,
                    'type' => 'page',
                    'name' => 'show_related_pages',
                    'value' => true
                ],
                [
                    'item_id' => $page->page_id,
                    'type' => 'page',
                    'name' => 'allow_comments',
                    'value' => true
                ],
            ]);

            LpComment::factory(mt_rand(0, 20))->state(new Sequence(function () use ($members) {
                return ['author_id' => $members->random()];
            }))->create([
                'page_id' => $page->page_id,
            ]);
        });

        $comments = LpComment::all();
        $childComments = $comments->each(function ($comment) {
            LpComment::factory(mt_rand(0, 3))
                ->state(
                    new Sequence(
                        function () use ($comment) {
                            return [
                                'page_id' => $comment->page_id,
                                'parent_id' => $comment->id,
                            ];
                        }
                    )
                )
                ->createdFrom($comment->created_at)
                ->create();
        });

        $childComments->each(function ($comment) {
            LpComment::factory(mt_rand(0, 3))
                ->state(
                    new Sequence(
                        function () use ($comment) {
                            return [
                                'page_id' => $comment->page_id,
                                'parent_id' => $comment->id,
                            ];
                        }
                    )
                )
                ->createdFrom($comment->created_at)
                ->create();
        });
    }
}
