<?php

return [

    /*
     * The name of the disk on which the snapshots are stored.
     */
    'disk' => 'snapshots',

    /*
     * The connection to be used to create snapshots. Set this to null
     * to use the default configured in `config/databases.php`
     */
    'default_connection' => null,

    /*
     * The directory where temporary files will be stored.
     */
    'temporary_directory_path' => storage_path('app/laravel-db-snapshots/temp'),

    /*
     * Create dump files that are gzipped
     */
    'compress' => false,

    /*
     * Only these tables will be included in the snapshot. Set to `null` to include all tables.
     *
     * Default: `null`
     */
    'tables' => [
        'smf_boards',
        'smf_board_permissions_view',
        'smf_categories',
        'smf_lp_blocks',
        'smf_lp_categories',
        'smf_lp_comments',
        'smf_lp_pages',
        'smf_lp_page_tag',
        'smf_lp_params',
        'smf_lp_tags',
        'smf_lp_translations',
        'smf_membergroups',
        'smf_members',
        'smf_messages',
        'smf_topics',
    ],

    /*
     * All tables will be included in the snapshot expect this tables. Set to `null` to include all tables.
     *
     * Default: `null`
     */
    'exclude' => null,
];
