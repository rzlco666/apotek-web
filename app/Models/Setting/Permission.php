<?php

namespace App\Models\Setting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Permission as SpatiePermission;
use Carbon\Carbon;

class Permission extends SpatiePermission
{
    use HasFactory;

    protected $table = 'permissions';

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

}
