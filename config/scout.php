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
                    'academic_level.phase_key',
                    'pants_size',
                    'shoes_size',
                    'shirt_size',
                    'health_status',
                    'family_status',
                    'gender',
                    'income',
                    'birth_date',
                    'is_handicapped',
                    'academic_average',
                    'speciality.speciality',
                    'family.income_rate',
                    'sponsor.id',
                    'family.zone.id',
                    'family.branch.id',
                ],
                'searchableAttributes' => [
                    'name',
                    'note',
                    'health_status',
                    'age',
                    'family_status',
                    'academic_level.level',
                    'academic_level.phase',
                    'vocational_training.speciality',
                    'vocational_training.division',
                    'shoes_size',
                    'shirt_size',
                    'pants_size',
                    'gender',
                    'family_status.ar',
                    'family_status.fr',
                    'family_status.en',
                    'academic_level.name',
                    'readable_birth_date',
                    'ccp',
                    'phone_number',
                    'eid_suit.shoes_shop_name',
                    'eid_suit.shoes_shop_address',
                    'eid_suit.shoes_shop_phone_number',
                    'eid_suit.clothes_shop_name',
                    'eid_suit.clothes_shop_address',
                    'eid_suit.clothes_shop_phone_number',
                    'academic_average',
                    'institution.name',
                ],
                'sortableAttributes' => [
                    'name',
                    'institution.name',
                    'family_status.ar',
                    'family_status.fr',
                    'family_status.en',
                    'academic_level.i_id',
                    'birth_date',
                    'age',
                    'pants_size',
                    'shoes_size',
                    'shirt_size',
                    'sponsor.name',
                    'family.income_rate',
                    'family.zone.name',
                    'family.branch.name',
                    'created_at',
                    'updated_at',
                    'academic_average',
                    'speciality.speciality',
                ],
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
                    'orphan.name',
                    'sponsor.name',
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
                    'academic_level.i_id',
                    'sponsor_type',
                    'gender',
                    'income',
                    'orphans_count',
                    'function',
                    'family.income_rate',
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
                'sortableAttributes' => ['name', 'family.income_rate', 'birth_date', 'academic_level.i_id', 'health_status', 'created_at'],
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
                    'housing.value',
                    'housing.name',
                    'housing.housing_receipt_number',
                    'housing.other_properties',
                    'furnishings.television.note', 'furnishings.refrigerator.note', 'furnishings.fireplace.note', 'furnishings.washing_machine.note', 'furnishings.water_heater.note', 'furnishings.oven.note', 'furnishings.wardrobe.note', 'furnishings.cupboard.note', 'furnishings.covers.note', 'furnishings.mattresses.note', 'furnishings.other_furnishings.note',
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
                    'aggregate_zakat_benefit',
                    'aggregate_white_meat_benefit',
                    'aggregate_red_meat_benefit',
                    'housing.value',
                    'housing.name',
                    'housing.housing_receipt_number',
                    'housing.number_of_rooms',
                    'furnishings.television.checked', 'furnishings.refrigerator.checked', 'furnishings.fireplace.checked', 'furnishings.washing_machine.checked', 'furnishings.water_heater.checked', 'furnishings.oven.checked', 'furnishings.wardrobe.checked', 'furnishings.cupboard.checked', 'furnishings.covers.checked', 'furnishings.mattresses.checked', 'furnishings.other_furnishings.checked',
                    'eid_al_adha_status',
                    'difference_before_ramadan_sponsorship',
                    'ramadan_basket_category',
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
                    'sponsor.name',
                    'address.zone.name',
                    'branch.name',
                    'ramadan_basket_category',
                    'ramadan_sponsorship_difference',
                    'aggregate_zakat_benefit',
                    'aggregate_white_meat_benefit',
                    'aggregate_red_meat_benefit',
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
                'sortableAttributes' => ['name', 'members_count', 'families_count', 'created_at'],
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
                    'members_count',
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
                    'needable.income_rate',
                    'status',
                    'tenant_id',
                    'branch.id',
                    'zone.id',
                    'needable.type',
                    'status',
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
                    'branch.name',
                    'zone.name',
                ],
            ],
            'finances' => [
                'filterableAttributes' => [
                    '__soft_deleted',
                    'id',
                    'abs_amount',
                    'amount',
                    'finance_type',
                    'specification',
                    'creator.id',
                    'receiver.id',
                    'tenant_id',
                    'created_at',
                    'date',
                ],
                'searchableAttributes' => [
                    'description',
                    'specification.ar',
                    'specification.fr',
                    'specification.en',
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
            'private_schools' => [
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
                    'name',
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
            'vocational_trainings' => [
                'filterableAttributes' => [
                    'id',
                    'speciality',
                    'division',
                ],
                'searchableAttributes' => [
                    'speciality',
                    'division',
                ],
                'sortableAttributes' => [
                    'id',
                ],
            ],
            'vocational_training_centers' => [
                'filterableAttributes' => [
                    'id',
                    'wilaya_code',
                ],
                'searchableAttributes' => [
                    'arabic_name',
                    'latin_name',
                ],
                'sortableAttributes' => [
                    'id',
                    'created_at',
                ],
            ],
            'transcripts' => [
                'filterableAttributes' => [
                    'tenant_id',
                    'average',
                    'trimester',
                    'orphan_id',
                    'academic_level_id',
                ],
                'searchableAttributes' => [
                    'average',
                    'trimester',
                ],
                'sortableAttributes' => [
                    'average',
                    'trimester',
                    'first_trimester.grade_0',
                    'first_trimester.grade_1',
                    'first_trimester.grade_2',
                    'first_trimester.grade_3',
                    'first_trimester.grade_4',
                    'first_trimester.grade_5',
                    'first_trimester.grade_6',
                    'first_trimester.grade_7',
                    'first_trimester.grade_8',
                    'first_trimester.grade_9',
                    'first_trimester.grade_10',
                    'first_trimester.grade_11',
                    'first_trimester.grade_12',
                    'first_trimester.grade_13',
                    'second_trimester.grade_0',
                    'second_trimester.grade_1',
                    'second_trimester.grade_2',
                    'second_trimester.grade_3',
                    'second_trimester.grade_4',
                    'second_trimester.grade_5',
                    'second_trimester.grade_6',
                    'second_trimester.grade_7',
                    'second_trimester.grade_8',
                    'second_trimester.grade_9',
                    'second_trimester.grade_10',
                    'second_trimester.grade_11',
                    'second_trimester.grade_12',
                    'second_trimester.grade_13',
                    'third_trimester.grade_0',
                    'third_trimester.grade_1',
                    'third_trimester.grade_2',
                    'third_trimester.grade_3',
                    'third_trimester.grade_4',
                    'third_trimester.grade_5',
                    'third_trimester.grade_6',
                    'third_trimester.grade_7',
                    'third_trimester.grade_8',
                    'third_trimester.grade_9',
                    'third_trimester.grade_10',
                    'third_trimester.grade_11',
                    'third_trimester.grade_12',
                    'third_trimester.grade_13',
                    '2.grade',
                    'created_at',
                ],
            ],
            'universities' => [
                'filterableAttributes' => [
                    'zone',
                    'type',
                ],
                'searchableAttributes' => [
                    'name',
                ],
                'sortableAttributes' => [
                    'id',
                ],
            ],
            'schools' => [
                'filterableAttributes' => [
                    'id',
                    'city_id',
                    'city.wilaya_code',
                    'phase_key',
                    'name',
                    'tenant_id',
                ],
                'searchableAttributes' => [
                    'name',
                    'city.commune_name_ascii',
                    'city.commune_name',
                ],
                'sortableAttributes' => [
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
