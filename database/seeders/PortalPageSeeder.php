<?php

namespace Database\Seeders;

use App\Models\PortalCategory;
use App\Models\PortalPage;
use App\Models\PortalParam;
use App\Models\PortalTag;
use App\Models\PortalTranslation;
use App\Models\Member;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class PortalPageSeeder extends Seeder
{
    public function run(): void
    {
        PortalPage::unsetEventDispatcher();
        PortalTranslation::unsetEventDispatcher();
        PortalParam::unsetEventDispatcher();

        $memberIds = Member::pluck('id_member')->all();
        $categoryIds = PortalCategory::pluck('category_id')->all();
        $tagIds = PortalTag::pluck('tag_id')->all();

        if (empty($memberIds) || empty($categoryIds) || empty($tagIds)) {
            return;
        }

        $currentDate = now()->subYears(2)->startOfDay();

        for ($i = 0; $i < 50; $i++) {
            $currentDate->addMinutes(mt_rand(240, 4320));

            PortalPage::factory()->create([
                'author_id'   => Arr::random($memberIds),
                'category_id' => Arr::random($categoryIds),
                'created_at'  => $currentDate->timestamp,
            ]);
        }

        unset($memberIds, $categoryIds);

        PortalPage::query()
            ->orderBy('page_id')
            ->chunkById(50, function ($pages) use ($tagIds) {
                $pageIds = $pages->pluck('page_id')->all();
                $pageTypes = $pages->pluck('type', 'page_id')->all();

                $translations = [];
                $pivot = [];
                $params = [];

                foreach ($pageIds as $pageId) {
                    $type = $pageTypes[$pageId] ?? 'bbc';

                    $translations[] = PortalTranslation::factory()
                        ->withRandomImage($type)
                        ->make([
                            'item_id' => $pageId,
                            'type' => 'page',
                            'lang' => 'english',
                        ])
                        ->toArray();

                    $translations[] = PortalTranslation::factory()
                        ->withRandomImage($type)
                        ->make([
                            'item_id' => $pageId,
                            'type' => 'page',
                            'lang' => 'russian',
                        ])
                        ->toArray();

                    $tagCount = rand(1, 5);
                    $randomKeys = array_rand($tagIds, $tagCount);
                    if (! is_array($randomKeys)) {
                        $randomKeys = [$randomKeys];
                    }

                    foreach ($randomKeys as $key) {
                        $pivot[] = [
                            'page_id' => $pageId,
                            'tag_id' => $tagIds[$key],
                        ];
                    }

                    $params[] = [
                        'item_id' => $pageId,
                        'type' => 'page',
                        'name' => 'show_author_and_date',
                        'value' => true,
                    ];
                    $params[] = [
                        'item_id' => $pageId,
                        'type' => 'page',
                        'name' => 'show_related_pages',
                        'value' => true,
                    ];
                    $params[] = [
                        'item_id' => $pageId,
                        'type' => 'page',
                        'name' => 'allow_comments',
                        'value' => true,
                    ];
                }

                if (! empty($translations)) {
                    PortalTranslation::insert($translations);
                }

                if (! empty($pivot)) {
                    DB::table('lp_page_tag')->insert($pivot);
                }

                if (! empty($params)) {
                    PortalParam::insert($params);
                }

                unset($pageIds, $pageTypes, $translations, $pivot, $params);
            });

        unset($tagIds);
    }
}
