<?php

namespace App\Models;

use App\Traits\HasUUID;
use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tag extends Model
{
    use HasUUID;
    use HasFactory;
    use Searchable;
    use SoftDeletes;

    protected $fillable = ['name', 'description'];

    protected $searchableFields = ['*'];

    public function tenants()
    {
        return $this->belongsToMany(Tenant::class);
    }
}
