<?php

use App\Enums\SponsorType;
use App\Models\City;
use App\Models\Family;
use App\Models\Orphan;
use App\Models\Tenant;
use Database\Seeders\AcademicLevelSeeder;
use Database\Seeders\CitySeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\seed;

uses(RefreshDatabase::class);

beforeEach(function () {
    seed(CitySeeder::class);

    seed(AcademicLevelSeeder::class);

    $this->tenant = Tenant::factory()->create([
        'infos' => [
            'super_admin' => [
                'first_name' => 'Rezig',
                'last_name' => 'Chikh',
                'password' => 'password',
                'email' => 'test@example.com',
            ],
            'domain' => 'foo.'.config('app.domain'),
            'association' => 'kafil el yatim El-bayadh ',
            'city_id' => 1144,
            'city' => [
                'id' => 1144,
                'daira_name' => 'البيض',
                'wilaya_code' => '32',
                'wilaya_name' => 'البيض',
            ],
        ],
    ]);

    $this->calculation = json_decode($this->tenant->calculation, true);

    $this->family = Family::factory()
        ->hasSponsor(1, [
            'sponsor_type' => SponsorType::WIDOWS_HUSBAND,
            'tenant_id' => $this->tenant->id,
        ])
        ->hasZone(1, ['tenant_id' => $this->tenant->id])
        ->hasBranch(1, ['tenant_id' => $this->tenant->id, 'city_id' => City::inRandomOrder()->first()->id])
        ->create([
            'tenant_id' => $this->tenant->id,
            'created_by' => \App\Models\User::inRandomOrder()->whereTenantId($this->tenant->id)->first()->id,
        ]);

    $this->family->load(['sponsor']);

    $this->orphan = Orphan::factory()->create([
        'sponsor_id' => $this->family->sponsor->id,
        'family_id' => $this->family->id,
        'created_by' => \App\Models\User::inRandomOrder()->whereTenantId($this->tenant->id)->first()->id,
        'tenant_id' => $this->tenant->id,
        'birth_date' => now()->subDays(80),
    ]);
});

it('correctly calculates weights for family when sponsor is widow(الأرملة).', function () {
    $this->family->sponsor->update([
        'sponsor_type' => SponsorType::WIDOW->value,
    ]);

    expect(calculateWeights($this->family, $this->calculation))
        ->toBe(2.0);
});

it('correctly calculates weights for family when sponsor is widower(الأرمل).', function () {
    $this->family->sponsor->update([
        'sponsor_type' => SponsorType::WIDOWER->value,
    ]);

    expect(calculateWeights($this->family, $this->calculation))
        ->toBe(1.75);
});

it('correctly calculates weights for family when sponsor is widower`s wife( زوجة الأرمل ).', function () {
    $this->family->sponsor->update([
        'sponsor_type' => SponsorType::WIDOWERS_WIFE->value,
    ]);

    expect(calculateWeights($this->family, $this->calculation))
        ->toBe(1.75);
});

it('correctly calculates weights for family when sponsor is other( الجد / الجدة / آخر).', function () {
    $this->family->sponsor->update([
        'sponsor_type' => SponsorType::OTHER->value,
    ]);

    expect(calculateWeights($this->family, $this->calculation))
        ->toBe(2.0);
});

it('correctly calculates weights for family when sponsor is mother of a supported childhood (أم طفولة مسعفة).', function () {
    $this->family->sponsor->update([
        'sponsor_type' => SponsorType::MOTHER_OF_A_SUPPORTED_CHILDHOOD->value,
    ]);

    expect(calculateWeights($this->family, $this->calculation))
        ->toBe(1.75);
});

it('correctly calculates weights for family when sponsor is widow`s husband (زوج الأرملة).', function () {
    $this->family->sponsor->update([
        'sponsor_type' => SponsorType::WIDOWS_HUSBAND->value,
    ]);

    expect(calculateWeights($this->family, $this->calculation))
        ->toBe(2.0);
});
