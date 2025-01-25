<?php

use App\Enums\SponsorType;
use App\Models\Branch;
use App\Models\City;
use App\Models\Family;
use App\Models\Orphan;
use App\Models\Sponsor;
use App\Models\Tenant;
use App\Models\Zone;
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

    Branch::factory()->count(3)->create([
        'tenant_id' => $this->tenant->id,
        'city_id' => City::inRandomOrder()->first()->id,
    ]);

    Zone::factory()->count(3)->create([
        'tenant_id' => $this->tenant->id,
    ]);

    $this->family = Family::factory()->create([
        'tenant_id' => $this->tenant->id,
        'branch_id' => Branch::inRandomOrder()->whereTenantId($this->tenant->id)->first()->id,
        'zone_id' => Zone::inRandomOrder()->whereTenantId($this->tenant->id)->first()->id,
        'created_by' => \App\Models\User::inRandomOrder()->whereTenantId($this->tenant->id)->first()->id,
    ]);

    $this->sponsor = Sponsor::factory()->create([
        'tenant_id' => $this->tenant->id,
        'family_id' => $this->family->id,
        'created_by' => \App\Models\User::inRandomOrder()->whereTenantId($this->tenant->id)->first()->id,
        'phone_number' => '0664954817',
        'sponsor_type' => 'widowers_wife',
    ]);

    // suppose orphan is baby when weight is always equal to 1
    $this->orphan = Orphan::factory()->create([
        'sponsor_id' => $this->sponsor->id,
        'family_id' => $this->family->id,
        'created_by' => \App\Models\User::inRandomOrder()->whereTenantId($this->tenant->id)->first()->id,
        'tenant_id' => $this->tenant->id,
        'birth_date' => now()->subDays(80),
        'income' => 0,
    ]);
});

it('correctly calculates total income for family when sponsor is widows husband (زوج الأرملة)', function () {
    $this->sponsor->update([
        'sponsor_type' => SponsorType::WIDOWS_HUSBAND,
        'is_unemployed' => true,
    ]);

    $this->incomes = $this->sponsor->incomes()->create([
        'tenant_id' => $this->tenant->id,
        'other_income' => 4000,
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
        'total_income' => 4000,
    ]);

    monthlySponsorship($this->family);

    expect(calculateIncomeRate($this->family))->toBe(15000.0);

    //    expect($this->family->total_income)->toBe(4000.0)
    //        ->and($this->family->income_rate)->toBe(0.0);
});
