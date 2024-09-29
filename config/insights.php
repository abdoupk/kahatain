<?php

declare(strict_types=1);

use NunoMaduro\PhpInsights\Domain\Insights\CyclomaticComplexityIsHigh;
use NunoMaduro\PhpInsights\Domain\Insights\ForbiddenDefineFunctions;
use NunoMaduro\PhpInsights\Domain\Insights\ForbiddenFinalClasses;
use NunoMaduro\PhpInsights\Domain\Insights\ForbiddenNormalClasses;
use NunoMaduro\PhpInsights\Domain\Insights\ForbiddenPrivateMethods;
use NunoMaduro\PhpInsights\Domain\Insights\ForbiddenTraits;
use NunoMaduro\PhpInsights\Domain\Metrics\Architecture\Classes;
use SlevomatCodingStandard\Sniffs\Commenting\UselessFunctionDocCommentSniff;
use SlevomatCodingStandard\Sniffs\Namespaces\AlphabeticallySortedUsesSniff;
use SlevomatCodingStandard\Sniffs\TypeHints\DeclareStrictTypesSniff;
use SlevomatCodingStandard\Sniffs\TypeHints\DisallowMixedTypeHintSniff;
use SlevomatCodingStandard\Sniffs\TypeHints\ParameterTypeHintSniff;
use SlevomatCodingStandard\Sniffs\TypeHints\PropertyTypeHintSniff;
use SlevomatCodingStandard\Sniffs\TypeHints\ReturnTypeHintSniff;

return [

    /*
    |--------------------------------------------------------------------------
    | Default Preset
    |--------------------------------------------------------------------------
    |
    | This option controls the default preset that will be used by PHP Insights
    | to make your code reliable, simple, and clean. However, you can always
    | adjust the `Metrics` and `Insights` below in this configuration file.
    |
    | Supported: "default", "laravel", "symfony", "magento2", "drupal", "wordpress"
    |
    */

    'preset' => 'laravel',

    /*
    |--------------------------------------------------------------------------
    | IDE
    |--------------------------------------------------------------------------
    |
    | This options allow to add hyperlinks in your terminal to quickly open
    | files in your favorite IDE while browsing your PhpInsights report.
    |
    | Supported: "textmate", "macvim", "emacs", "sublime", "phpstorm",
    | "atom", "vscode".
    |
    | If you have another IDE that is not in this list but which provide an
    | url-handler, you could fill this config with a pattern like this:
    |
    | myide://open?url=file://%f&line=%l
    |
    */

    'ide' => 'phpstorm',

    /*
    |--------------------------------------------------------------------------
    | Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may adjust all the various `Insights` that will be used by PHP
    | Insights. You can either add, remove or configure `Insights`. Keep in
    | mind, that all added `Insights` must belong to a specific `Metric`.
    |
    */

    'exclude' => [
        'auth.php',
        'http-statuses.php',
        'pagination.php',
        'passwords.php',
        'validation.php',
    ],

    'add' => [
        Classes::class => [
            ForbiddenFinalClasses::class,
        ],
    ],

    'remove' => [
        AlphabeticallySortedUsesSniff::class,
        DeclareStrictTypesSniff::class,
        DisallowMixedTypeHintSniff::class,
        ForbiddenDefineFunctions::class,
        ForbiddenNormalClasses::class,
        ForbiddenTraits::class,
        ParameterTypeHintSniff::class,
        PropertyTypeHintSniff::class,
        ReturnTypeHintSniff::class,
        UselessFunctionDocCommentSniff::class,
    ],

    'config' => [
        ForbiddenPrivateMethods::class => [
            'title' => 'The usage of private methods is not idiomatic in Laravel.',
        ],
        CyclomaticComplexityIsHigh::class => [
            'exclude' => [
                'app\Http\Controllers\V1\Families\FamilyStoreController.php',
                'app\Providers\TenancyServiceProvider.php',
                'app\Http\Resources\V1\Families\FamilyEditSponsorshipResource.php',
                'app\Exports\FullExports\OrphansExport.php',
            ],
        ],
        \SlevomatCodingStandard\Sniffs\Functions\FunctionLengthSniff::class => [
            'maxLinesLength' => 30,
            'exclude' => [
                'app\Providers\TenancyServiceProvider.php',
                'app\Models\OrphanSponsorship.php',
                'app\Http\Resources\V1\Sponsors\SponsorShowResource.php',
                'app\Http\Resources\V1\Orphans\OrphanEditResource.php',
                'app\Models\Baby.php',
                'app\Providers\AppServiceProvider.php',
                'app\Models\Sponsor.php',
                'app\Http\Controllers\V1\Families\FamilyStoreController.php',
                'app\Http\Controllers\V1\Trash\TrashIndexController.php',
                'app\Http\Resources\V1\Occasions\EidSuitResource.php',
                'app\Http\Requests\V1\Families\CreateFamilyRequest.php',
                'app\Models\User.php',
                'app\Models\Orphan.php',
                'app\Models\Family.php',
                'app\Helpers\private-schools.php',
                'app\Helpers\statistics\orphans_statistics.php',
                'app\Helpers\statistics\financial_statistics.php',
                'app\Models\FamilySponsorship.php',
                'app\Exports\FullExports\FamiliesExport.php',
                'app\Helpers\dashboard.php',
                'app\Helpers\families.php',
                'app\Http\Requests\V1\RegisterTenantRequest.php',
                'app\Http\Controllers\Auth\NewPasswordController.php',
            ],
        ],
        \PHP_CodeSniffer\Standards\Generic\Sniffs\Files\LineLengthSniff::class => [
            'lineLimit' => 120,
            'absoluteLineLimit' => 130,
            'exclude' => [
                'app\Helpers\occasions.php',
                'app\Http\Controllers\Auth\VerifyEmailController.php',
                'app\Http\Controllers\Auth\RegisteredUserController.php',
                'lang',
                'app\Helpers\statistics\financial_statistics.php',
                'app\Helpers\dashboard.php',
                'app\Http\Requests\V1\Families\CreateFamilyRequest.php',
                'app\Http\Controllers\Auth\PasswordResetLinkController.php',
                'app\Http\Controllers\RegisteredTenantController.php',
                'app\Http\Controllers\Auth\NewPasswordController.php',
                'app\Providers\TenancyServiceProvider.php',
                'app\Http\Controllers\Auth\EmailVerificationPromptController.php',
                '.\ray.php',
            ],
        ],
        \PHP_CodeSniffer\Standards\PSR12\Sniffs\Classes\ClassInstantiationSniff::class => [
            'exclude' => [
                'app\Http\Middleware\HandleInertiaRequests.php',
            ],
        ],

        SlevomatCodingStandard\Sniffs\Functions\UnusedParameterSniff::class => [
            'exclude' => [
                'app/Http/Resources',
                'app\Rules\PermissionNameExistsRule.php',
                'app\Providers\AppServiceProvider.php',
                'app\Providers\TenancyServiceProvider.php',
            ],
        ],

        PhpCsFixer\Fixer\Operator\NewWithBracesFixer::class => [
            'exclude' => [
                'app\Http\Middleware\HandleInertiaRequests.php',
                'app\Http\Requests\V1\RegisterTenantRequest.php',
            ],
        ],
        SlevomatCodingStandard\Sniffs\Classes\ForbiddenPublicPropertySniff::class => [
            'exclude' => [
                'app/Models',
                'app\Providers\TenancyServiceProvider.php'
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Requirements
    |--------------------------------------------------------------------------
    |
    | Here you may define a level you want to reach per `Insights` category.
    | When a score is lower than the minimum level defined, then an error
    | code will be returned. This is optional and individually defined.
    |
    */

    'requirements' => [
        //        'min-quality' => 0,
        //        'min-complexity' => 0,
        //        'min-architecture' => 0,
        //        'min-style' => 0,
        //        'disable-security-check' => false,
    ],

    /*
    |--------------------------------------------------------------------------
    | Threads
    |--------------------------------------------------------------------------
    |
    | Here you may adjust how many threads (core) PHPInsights can use to perform
    | the analysis. This is optional, don't provide it and the tool will guess
    | the max core number available. It accepts null value or integer > 0.
    |
    */

    'threads' => null,

    /*
    |--------------------------------------------------------------------------
    | Timeout
    |--------------------------------------------------------------------------
    | Here you may adjust the timeout (in seconds) for PHPInsights to run before
    | a ProcessTimedOutException is thrown.
    | This accepts an int > 0. Default is 60 seconds, which is the default value
    | of Symfony's setTimeout function.
    |
    */

    'timeout' => 60,
];
