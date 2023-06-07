<?php

namespace App\Models\Setting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleHasPermission extends Model
{
    use HasFactory;

    protected $table = 'role_has_permissions';

    protected $fillable = [
        'permission_id',
        'role_id'
    ];

    protected $appends = ['permission_name'];

    public $timestamps = false;
    protected $primaryKey = null;
    public $incrementing = false;

    public function role()
    {
        return $this->belongsTo(Role::class, 'id', 'role_id');
    }

    public function permission()
    {
        return $this->hasOne(Permission::class, 'id', 'permission_id');
    }

    public function getPermissionNameAttribute()
    {
        if ($this->permission) {
            return $this->permission->name;
        }

        return null;
    }
}
