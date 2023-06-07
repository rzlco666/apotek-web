<?php

namespace App\Models\Setting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Role as SpatieRole;
use Carbon\Carbon;

class Role extends SpatieRole
{
    use HasFactory;

    protected $table = 'roles';

    protected $guarded = [
        'id'
    ];


    public function getLastModifiedAttribute()
    {
        if (is_null($this->updated_by)) {
            return Carbon::parse($this->created_at)->format('d M Y H:i');
        } else {
            return Carbon::parse($this->updated_at)->format('d M Y H:i');
        }
    }

    public function userPermission()
    {
        return $this->hasMany(RoleHasPermission::class, 'role_id', 'id');
    }
}
