<?php

namespace App\Models\Obat;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class DataObat extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'obat';

    protected $fillable = [
        'kode_obat',
        'nama_obat',
        'dosis',
        'kategori_obat_id',
        'satuan',
        'golongan',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    public function category_obat()
    {
        return $this->hasOne(KategoriObat::class, 'id', 'kategori_obat_id');
    }

    // adjust boot function
    public static function boot()
    {
        // run parent
        parent::boot();

        // add in custom deleting
        self::deleting(function ($model) {
            // save custom delete value
            // user Class::where(...)->get()->each->delete() for delete more than 1
            $model->deleted_by = Auth::user()->id;
            $model->save();
        });
    }

    public function getCreatedByNameAttribute()
    {
        $id = $this->attributes['created_by'];
        $user = User::where('id', $id)->first();

        if ($user) {
            return $user->name;
        }
        return 'Anonim';
    }

    public function getUpdatedByNameAttribute()
    {
        $id = $this->attributes['updated_by'];
        $user = User::where('id', $id)->first();

        if ($user) {
            return $user->name;
        }
        return 'Anonim';
    }

    public function getLastModifiedAttribute()
    {
        if (is_null($this->updated_by)) {
            $user = User::where('id', $this->created_by)->first();
            return ($user->name ?? '-') . ',<br> ' . Carbon::parse($this->created_at)->format('d M Y H:i');
        } else {
            $user = User::where('id', $this->updated_by)->first();
            return ($user->name ?? '-') . ',<br> ' . Carbon::parse($this->updated_at)->format('d M Y H:i');
        }
    }
}
