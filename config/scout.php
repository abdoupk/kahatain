<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Search Engine
    |--------------------------------------------------------------------------
    |
    | This option controls the default search connection that gets used while
    | using Laravel Scout. This connection is used when syncing all models
    | to the search service. You should adjust this based on your needs.
    |
    | Supported: "algolia", "meilisearch", "typesense",
    |            "database", "collection", "null"
    |
    */

    'driver' => env('SCOUT_DRIVER', 'algolia'),

    /*
    |--------------------------------------------------------------------------
    | Index Prefix
    |--------------------------------------------------------------------------
    |
    | Here you may specify a prefix that will be applied to all search index
    | names used by Scout. This prefix may be useful if you have multiple
    | "tenants" or applications sharing the same search infrastructure.
    |
    */

    'prefix' => env('SCOUT_PREFIX', ''),

    /*
    |--------------------------------------------------------------------------
    | Queue Data Syncing
    |--------------------------------------------------------------------------
    |
    | This option allows you to control if the operations that sync your data
    | with your search engines are queued. When this is set to "true" then
    | all automatic data syncing will get queued for better performance.
    |
    */

    'queue' => env('SCOUT_QUEUE', false),

    /*
    |--------------------------------------------------------------------------
    | Database Transactions
    |--------------------------------------------------------------------------
    |
    | This configuration option determines if your data will only be synced
    | with your search indexes after every open database transaction has
    | been committed, thus preventing any discarded data from syncing.
    |
    */

    'after_commit' => false,

    /*
    |--------------------------------------------------------------------------
    | Chunk Sizes
    |--------------------------------------------------------------------------
    |
    | These options allow you to control the maximum chunk size when you are
    | mass importing data into the search engine. This allows you to fine
    | tune each of these chunk sizes based on the power of the servers.
    |
    */

    'chunk' => [
        'searchable' => 500,
        'unsearchable' => 500,
    ],

    /*
    |--------------------------------------------------------------------------
    | Soft Deletes
    |--------------------------------------------------------------------------
    |
    | This option allows to control whether to keep soft deleted records in
    | the search indexes. Maintaining soft deleted records can be useful
    | if your application still needs to search for the records later.
    |
    */

    'soft_delete' => true,

    /*
    |--------------------------------------------------------------------------
    | Identify User
    |--------------------------------------------------------------------------
    |
    | This option allows you to control whether to notify the search engine
    | of the user performing the search. This is sometimes useful if the
    | engine supports any analytics based on this application's users.
    |
    | Supported engines: "algolia"
    |
    */

    'identify' => env('SCOUT_IDENTIFY', false),

    /*
    |--------------------------------------------------------------------------
    | Algolia Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your Algolia settings. Algolia is a cloud hosted
    | search engine which works great with Scout out of the box. Just plug
    | in your application ID and admin API key to get started searching.
    |
    */

    'algolia' => [
        'id' => env('ALGOLIA_APP_ID', ''),
        'secret' => env('ALGOLIA_SECRET', ''),
    ],

    /*
    |--------------------------------------------------------------------------
    | Meilisearch Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your Meilisearch settings. Meilisearch is an open
    | source search engine with minimal configuration. Below, you can state
    | the host and key information for your own Meilisearch installation.
    |
    | See: https://www.meilisearch.com/docs/learn/configuration/instance_options#all-instance-options
    |
    */

    'meilisearch' => [
        'host' => env('MEILISEARCH_HOST', 'http://localhost:7700'),
        'key' => env('MEILISEARCH_KEY'),
        'index-settings' => [
            'users' => [
                'filterableAttributes' => [
                    '__soft_deleted',
                    'id',
                    'name',
                    'email',
                    'phone',
                    'tenant_id',
                    'roles',
                    'committees',
                    'competences',
                    'gender',
                    'zone.id',
                    'branch.id',
                    'academic_level.id',
                    'created_at',
                ],
                'searchableAttributes' => ['name', 'email', 'phone', 'gender'],
                'sortableAttributes' => [
                    'name',
                    'email',
                    'phone',
                    'gender',
                    'created_at',
                ],
            ],
            'roles' => [
                'filterableAttributes' => [
                    '__soft_deleted',
                    'uuid',
                    'name',
                    'tenant_id',
                ],
                'searchableAttributes' => ['name'],
                'sortableAttributes' => [
                    'name',
                    'permissions_count',
                    'users_count',
                    'created_at',
                ],
            ],
            'orphans' => [
                'filterableAttributes' => [
                    '__soft_deleted',
                    'id',
                    'name',
                    'tenant_id',
                    'academic_level.id',
                    'pants_size',
                    'shoes_size',
                    'shirt_size',
                    'health_status',
                    'family_status',
                    'gender',
                    'age',
                    'income',
                    'birth_date',
                    'sponsorships',
                ],
                'searchableAttributes' => [
                    'name',
                    'note',
                    'health_status',
                    'age',
                    'family_status',
                    'academic_level.level',
                    'academic_level.phase',
                    'shoes_size',
                    'shirt_size',
                    'pants_size',
                    'gender',
                    'family_status.ar',
                    'family_status.fr',
                    'family_status.en',
                    'academic_level.name',
                    'readable_birth_date',
                    'academic_achievements.academic_level',
                    'college_achievements.academic_level',
                    'college_achievements.university',
                    'college_achievements.speciality',
                    'vocational_training_achievements.vocational_training_speciality',
                    'vocational_training_achievements.vocational_training_division',
                    'vocational_training_achievements.institute',
                ],
                'sortableAttributes' => ['name', 'family_status.ar', 'family_status.fr', 'family_status.en', 'academic_level.id', 'birth_date', 'age', 'created_at'],
            ],
            'babies' => [
                'filterableAttributes' => [
                    '__soft_deleted',
                    'orphan.id',
                    'tenant_id',
                    'orphan.health_status',
                    'orphan.gender',
                    'family.id',
                    'orphan.birth_date',
                    'sponsor.id',
                    'orphan.id',
                    'address.zone.id',
                    'baby_milk_quantity',
                    'baby_milk_type',
                    'diapers_quantity',
                    'diapers_type',
                ],
                'searchableAttributes' => [
                    'orphan.name',
                    'sponsor.name',
                    'family.name',
                    'baby_milk_type',
                    'diapers_type',
                    'baby_milk_quantity',
                    'diapers_quantity',
                ],
                'sortableAttributes' => [
                    'name',
                    'created_at',
                    'baby_milk_quantity',
                    'diapers_quantity',
                    'orphan.birth_date',
                ],
            ],
            'inventory' => [
                'filterableAttributes' => [
                    '__soft_deleted',
                    'id',
                    'name',
                    'qty',
                    'unit',
                    'tenant_id',
                ],
                'searchableAttributes' => [
                    'name',
                    'quantity',
                    'unit',
                    'note',
                    'qty',
                ],
                'sortableAttributes' => ['name', 'created_at', 'qty', 'unit'],
            ],
            'archive' => [
                'filterableAttributes' => ['tenant_id'],
                'searchableAttributes' => [],
                'sortableAttributes' => ['created_at'],
            ],
            'sponsors' => [
                'filterableAttributes' => [
                    '__soft_deleted',
                    'id',
                    'name',
                    'tenant_id',
                    'academic_level_id',
                    'sponsor_type',
                    'gender',
                    'income',
                    'sponsorships',
                    'orphans_count',
                    'function',
                ],
                'searchableAttributes' => [
                    'name',
                    'function',
                    'birth_certificate_number',
                    'mother_name',
                    'academic_level.level',
                    'academic_level.phase',
                    'father_name',
                    'phone_number',
                    'sponsor_type',
                    'gender',
                    'diploma',
                    'ccp',
                ],
                'sortableAttributes' => ['name', 'birth_date', 'academic_level.id', 'health_status', 'created_at'],
            ],
            'families' => [
                'rankingRules' => [
                    'words',
                    'sort',
                    'typo',
                    'proximity',
                    'attribute',
                    'exactness',
                ],
                'searchableAttributes' => [
                    'name',
                    'phone',
                    'file_number',
                    'address.zone.name',
                    'address.address',
                    'start_date',
                    'second_sponsor.name',
                    'second_sponsor.degree_of_kinship',
                    'second_sponsor.address',
                    'spouse.name',
                    'spouse.function',
                    'branch.name',
                    'orphans_count',
                    'total_income',
                    'income_rate',
                    'sponsor.name',
                    'sponsor.phone_number',
                    'difference_before_monthly_sponsorship',
                    'difference_after_monthly_sponsorship',
                    'monthly_sponsorship_rate',
                    'amount_from_association',
                    'basket_from_association',
                    'amount_from_benefactor',
                    'basket_from_benefactor',
                ],
                'filterableAttributes' => [
                    '__soft_deleted',
                    'id',
                    'name',
                    'file_number',
                    'start_date',
                    'address.zone.id',
                    'tenant_id',
                    'branch.id',
                    'spouse.function',
                    'sponsor.academic_level_id',
                    'sponsor.id',
                    'family_sponsorships.monthly_allowance',
                    'family_sponsorships.ramadan_basket',
                    'family_sponsorships.zakat',
                    'family_sponsorships.housing_assistance',
                    'family_sponsorships.eid_el_adha',
                    'orphans_count',
                    'total_income',
                    'income_rate',
                    'difference_before_monthly_sponsorship',
                    'difference_after_monthly_sponsorship',
                    'monthly_sponsorship_rate',
                    'amount_from_association',
                    'basket_from_association',
                    'amount_from_benefactor',
                    'basket_from_benefactor',
                ],
                'sortableAttributes' => [
                    'name',
                    'file_number',
                    'created_at',
                    'start_date',
                    'orphans_count',
                    'total_income',
                    'income_rate',
                    'difference_before_monthly_sponsorship',
                    'difference_after_monthly_sponsorship',
                    'monthly_sponsorship_rate',
                    'amount_from_association',
                    'basket_from_association',
                    'amount_from_benefactor',
                    'basket_from_benefactor',
                ],
            ],
            'zones' => [
                'filterableAttributes' => [
                    '__soft_deleted',
                    'id',
                    'families_count',
                    'name',
                    'description',
                    'tenant_id',
                    'created_at',
                ],
                'searchableAttributes' => ['name', 'families_count', 'description', 'created_at'],
                'sortableAttributes' => ['name', 'families_count', 'created_at'],
            ],
            'branches' => [
                'filterableAttributes' => [
                    '__soft_deleted',
                    'id',
                    'city.id',
                    'president.id',
                    'families_count',
                    'created_at',
                    'tenant_id',
                ],
                'searchableAttributes' => [
                    'name',
                    'description',
                    'city.ar_name',
                    'city.latin_name',
                    'president.name',
                ],
                'sortableAttributes' => [
                    'id',
                    'name',
                    'families_count',
                    'city.ar_name',
                    'city.latin_name',
                    'president.name',
                    'created_at',
                ],
            ],
            'needs' => [
                'filterableAttributes' => [
                    '__soft_deleted',
                    'id',
                    'needable.name',
                    'needable.type',
                    'status',
                    'tenant_id',
                ],
                'searchableAttributes' => [
                    'note',
                    'subject',
                    'demand',
                    'needable.name',
                    'needable.type',
                    'status',
                ],
                'sortableAttributes' => [
                    'note',
                    'needable.name',
                    'needable.type',
                    'status',
                    'created_at',
                ],
            ],
            'family_sponsorships' => [
                'filterableAttributes' => [
                    '__soft_deleted',
                    'id',
                    'monthly_allowance',
                    'ramadan_basket',
                    'zakat',
                    'housing_assistance',
                    'eid_al_adha',
                    'tenant_id',
                    'family.branch.id',
                    'family.id',
                    'family.zone.id',
                    'family.orphans_count',
                    'family.total_income',
                    'sponsor.id',
                ],
                'searchableAttributes' => [
                    'family.address',
                    'family.zone',
                    'family.branch',
                    'sponsor.name',
                    'sponsor.phone_number',
                    'family.orphans_count',
                    'family.total_income',
                    'family.income_rate',
                ],
                'sortableAttributes' => [
                    'created_at',
                    'family.orphans_count',
                    'family.zone',
                    'family.branch',
                    'sponsor.name',
                    'family.total_income',
                    'family.income_rate',
                ],
            ],
            'orphan_sponsorships' => [
                'filterableAttributes' => [
                    '__soft_deleted',
                    'id',
                    'medical_sponsorship',
                    'orphan.id',
                    'university_scholarship',
                    'association_trips',
                    'summer_camp',
                    'orphan.academic_achievement.academic_year',
                    'orphan.academic_achievement.academic_level.id',
                    'orphan.academic_achievement.last_year_average',
                    'orphan.gender',
                    'orphan.birth_date',
                    'orphan.shoes_size',
                    'orphan.shirt_size',
                    'orphan.pants_size',
                    'eid_suit',
                    'private_lessons',
                    'school_bag',
                    'tenant_id',
                ],
                'searchableAttributes' => [
                    'orphan.name',
                    'orphan.phone_number',
                    'orphan.age',
                    'orphan.gender',
                ],
                'sortableAttributes' => [
                    'created_at',
                    'orphan.name',
                    'orphan.year_average',
                    'orphan.academic_level',
                    'orphan.academic_phase',
                    'sponsor.name',
                    'family.zone',
                    'orphan.shirt_size',
                    'orphan.pants_size',
                    'orphan.shoes_size',
                ],
            ],
            'finances' => [
                'filterableAttributes' => [
                    '__soft_deleted',
                    'id',
                    'amount',
                    'specification',
                    'creator',
                    'tenant_id',
                ],
                'searchableAttributes' => [
                    'description',
                    'specification',
                    'date',
                    'amount',
                    'creator.name',
                    'receiver.name',
                ],
                'sortableAttributes' => [
                    'date',
                    'specification',
                    'amount',
                    'creator.name',
                    'receiver.name',
                    'specification.ar',
                    'specification.en',
                    'specification.fr',
                    'created_at',
                ],
            ],
            'schools' => [
                'filterableAttributes' => [
                    '__soft_deleted',
                    'id',
                    'tenant_id',
                    'quota',
                ],
                'searchableAttributes' => ['name', 'quota'],
                'sortableAttributes' => ['created_at', 'name', 'quota'],
            ],
            'previews' => [
                'filterableAttributes' => ['__soft_deleted', 'id', 'tenant_id'],
                'searchableAttributes' => ['report', 'inspectors', 'family.name'],
                'sortableAttributes' => ['created_at', 'preview_date'],
            ],
            'benefactors' => [
                'filterableAttributes' => [
                    '__soft_deleted',
                    'created_at',
                    'tenant_id',
                    'sponsorships_count',
                ],
                'searchableAttributes' => [
                    'first_name',
                    'last_name',
                    'phone',
                    'sponsorships_count',
                ],
                'sortableAttributes' => [
                    'sponsorships_count',
                    'created_at',
                    'name',
                ],
            ],
            'committees' => [
                'filterableAttributes' => [
                    '__soft_deleted',
                    'created_at',
                    'tenant_id',
                    'members_count',
                ],
                'searchableAttributes' => [
                    'name',
                    'description',
                    'members_count',
                ],
                'sortableAttributes' => [
                    'members_count',
                    'created_at',
                    'name',
                ],
            ],
        ],
    ],

    /*
        |--------------------------------------------------------------------------
        | Typesense Configuration
        |--------------------------------------------------------------------------
        |
        | Here you may configure your Typesense settings. Typesense is an open
        | source search engine using minimal configuration. Below, you will
        | state the host, key, and schema configuration for the instance.
        |
        */

    'typesense' => [
        'client-settings' => [
            'api_key' => env('TYPESENSE_API_KEY', 'xyz'),
            'nodes' => [
                [
                    'host' => env('TYPESENSE_HOST', 'localhost'),
                    'port' => env('TYPESENSE_PORT', '8108'),
                    'path' => env('TYPESENSE_PATH', ''),
                    'protocol' => env('TYPESENSE_PROTOCOL', 'http'),
                ],
            ],
            'nearest_node' => [
                'host' => env('TYPESENSE_HOST', 'localhost'),
                'port' => env('TYPESENSE_PORT', '8108'),
                'path' => env('TYPESENSE_PATH', ''),
                'protocol' => env('TYPESENSE_PROTOCOL', 'http'),
            ],
            'connection_timeout_seconds' => env(
                'TYPESENSE_CONNECTION_TIMEOUT_SECONDS',
                2
            ),
            'healthcheck_interval_seconds' => env(
                'TYPESENSE_HEALTHCHECK_INTERVAL_SECONDS',
                30
            ),
            'num_retries' => env('TYPESENSE_NUM_RETRIES', 3),
            'retry_interval_seconds' => env(
                'TYPESENSE_RETRY_INTERVAL_SECONDS',
                1
            ),
        ],
        'model-settings' => [
            // User::class => [
            //     'collection-schema' => [
            //         'fields' => [
            //             [
            //                 'name' => 'id',
            //                 'type' => 'string',
            //             ],
            //             [
            //                 'name' => 'name',
            //                 'type' => 'string',
            //             ],
            //             [
            //                 'name' => 'created_at',
            //                 'type' => 'int64',
            //             ],
            //         ],
            //         'default_sorting_field' => 'created_at',
            //     ],
            //     'search-parameters' => [
            //         'query_by' => 'name'
            //     ],
            // ],
        ],
    ],
];
