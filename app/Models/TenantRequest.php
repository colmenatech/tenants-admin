<?php

namespace App\Models;

use App\Traits\HasUUID;
use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TenantRequest extends Model
{
    use HasUUID;
    use HasFactory;
    use Searchable;
    use SoftDeletes;

    protected $fillable = ['email', 'phone', 'description', 'image'];

    protected $searchableFields = ['*'];

    protected $table = 'tenant_requests';

    public function tenants()
    {
        return $this->hasMany(Tenant::class);
    }
}
