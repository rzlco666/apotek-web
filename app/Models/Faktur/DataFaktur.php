<?php

namespace App\Models\Faktur;

use App\Models\Obat\DataObat;
use App\Models\Supplier\Supplier;
use App\Models\Pesanan\SuratPesanan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class DataFaktur extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'faktur';

    protected $fillable = [
        'obat_id',
        'id_surat_pesanan',
        'tanggal_faktur',
        'total_obat',
        'total_bayar',
        'supplier_id',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    public function data_obat()
    {
        return $this->hasOne(DataObat::class, 'id', 'obat_id');
    }

    public function data_supplier()
    {
        return $this->hasOne(Supplier::class, 'id', 'supplier_id');
    }

    public function data_surat_pesanan()
    {
        return $this->hasOne(SuratPesanan::class, 'id', 'id_surat_pesanan');
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
