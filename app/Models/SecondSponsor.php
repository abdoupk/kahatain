<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class SecondSponsor extends Model
{
    use BelongsToTenant, HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'first_name',
        'last_name',
        'degree_of_kinship',
        'phone_number',
        'address',
        'income',
        'with_family',
        'family_id',
        'tenant_id',
    ];

    public function getName(): string
    {
        return $this->first_name.' '.$this->last_name;
    }
}
