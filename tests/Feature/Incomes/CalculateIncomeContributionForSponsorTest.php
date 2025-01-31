<?php

use App\Enums\SponsorType;
use App\Models\Family;
use App\Models\Tenant;
use Database\Seeders\CitySeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\seed;

uses(RefreshDatabase::class);

beforeEach(function () {
    seed(CitySeeder::class);

    $this->tenant = Tenant::factory()->create([
        'infos' => [
            'super_admin' => [
                'first_name' => 'Rezig',
                'last_name' => 'Chikh',
                'password' => 'password',
                'email' => 'test@example.com',
            ],
        ],
    ]);

    $this->family = Family::factory()
        ->hasSponsor(1, ['tenant_id' => $this->tenant->id, 'is_unemployed' => false])
        ->hasZone(1, ['tenant_id' => $this->tenant->id])
        ->hasBranch(1, ['tenant_id' => $this->tenant->id])
        ->create(['tenant_id' => $this->tenant->id]);

    $this->family->load(['sponsor']);

    $this->incomes = $this->family->sponsor->incomes()->create([
        'tenant_id' => $this->tenant->id,
        'other_income' => 1000,
        'total_income' => 1000,
        'account' => [
            'ccp' => [
                'monthly_income' => null,
                'balance' => null,
                'performance_grant' => null,
            ],
            'bank' => [
                'monthly_income' => null,
                'balance' => null,
                'performance_grant' => null,
            ],
        ],
    ]);
})->group('incomes');

it('correctly calculates income contribution for sponsor widower (الأرمل) when is employed', function () {
    $this->family->sponsor->update([
        'sponsor_type' => SponsorType::WIDOWER->value,
    ]);

    expect(calculateContributionsForSponsor($this->family->sponsor))->toBe(1000.0);
})->group('incomes');

it('correctly calculates income contribution for sponsor widow (الأرملة) when is employed', function () {
    $this->family->sponsor->update([
        'sponsor_type' => SponsorType::WIDOW->value,
    ]);

    expect(calculateContributionsForSponsor($this->family->sponsor))->toBe(1000.0);
})->group('incomes');

it('correctly calculates income contribution for sponsor widow`s husband (زوج الأرملة) when is employed', function () {
    $this->family->sponsor->update([
        'sponsor_type' => SponsorType::WIDOWS_HUSBAND->value,
    ]);

    expect(calculateContributionsForSponsor($this->family->sponsor))->toBe(1000.0);
})->group('incomes');

it('correctly calculates income contribution for sponsor widower`s wife (زوجة الأرمل) when is employed', function () {
    $this->family->sponsor->update([
        'sponsor_type' => SponsorType::WIDOWERS_WIFE->value,
    ]);

    expect(calculateContributionsForSponsor($this->family->sponsor))->toBe(1000.0);
})->group('incomes');

it('correctly calculates income contribution for sponsor other (الجد / الجدة / آخر) when is employed', function () {
    $this->family->sponsor->update([
        'sponsor_type' => SponsorType::OTHER->value,
    ]);

    expect(calculateContributionsForSponsor($this->family->sponsor))->toBe(1000.0);
})->group('incomes');

it('correctly calculates income contribution for sponsor mother of a supported childhood (أم طفولة مسعفة) when is employed', function () {
    $this->family->sponsor->update([
        'sponsor_type' => SponsorType::MOTHER_OF_A_SUPPORTED_CHILDHOOD->value,
    ]);

    expect(calculateContributionsForSponsor($this->family->sponsor))->toBe(1000.0);
})->group('incomes');

it('correctly calculates income contribution for sponsor widower (الأرمل) when is unemployed', function () {
    $this->family->sponsor->update([
        'sponsor_type' => SponsorType::WIDOWER->value,
        'is_unemployed' => true,
    ]);

    expect(calculateContributionsForSponsor($this->family->sponsor))->toBe(0.0);
})->group('incomes');

it('correctly calculates income contribution for sponsor widow (الأرملة) when is unemployed', function () {
    $this->family->sponsor->update([
        'sponsor_type' => SponsorType::WIDOW->value,
        'is_unemployed' => true,
    ]);

    expect(calculateContributionsForSponsor($this->family->sponsor))->toBe(0.0);
})->group('incomes');

it('correctly calculates income contribution for sponsor widow`s husband (زوج الأرملة) when is unemployed', function () {
    $this->family->sponsor->update([
        'sponsor_type' => SponsorType::WIDOWS_HUSBAND->value,
        'is_unemployed' => true,
    ]);

    expect(calculateContributionsForSponsor($this->family->sponsor))->toBe(15000.0);
})->group('incomes');

it('correctly calculates income contribution for sponsor widower`s wife (زوجة الأرمل) when is unemployed', function () {
    $this->family->sponsor->update([
        'sponsor_type' => SponsorType::WIDOWERS_WIFE->value,
        'is_unemployed' => true,
    ]);

    expect(calculateContributionsForSponsor($this->family->sponsor))->toBe(0.0);
})->group('incomes');

it('correctly calculates income contribution for sponsor other (الجد / الجدة / آخر) when is unemployed', function () {
    $this->family->sponsor->update([
        'sponsor_type' => SponsorType::OTHER->value,
        'is_unemployed' => true,
    ]);

    expect(calculateContributionsForSponsor($this->family->sponsor))->toBe(0.0);
})->group('incomes');

it('correctly calculates income contribution for sponsor mother of a supported childhood (أم طفولة مسعفة) when is unemployed', function () {
    $this->family->sponsor->update([
        'sponsor_type' => SponsorType::MOTHER_OF_A_SUPPORTED_CHILDHOOD->value,
        'is_unemployed' => true,
    ]);

    expect(calculateContributionsForSponsor($this->family->sponsor))->toBe(0.0);
})->group('incomes');
