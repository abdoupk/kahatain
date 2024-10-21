<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class Benefactor extends Model
{
    use BelongsToTenant, HasFactory, HasUuids, Searchable;

    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'tenant_id',
    ];

    public function searchable()
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'phone' => $this->phone,
            'tenant_id' => $this->tenant_id,
            'created_at' => $this->created_at,
            'name' => $this->first_name.' '.$this->last_name,
        ];
    }

    public function searchableAs(): string
    {
        return 'benefactors';
    }
}
