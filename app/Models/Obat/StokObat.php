<?php

namespace App\Models\Obat;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokObat extends Model
{
    use HasFactory;

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

    public function exp_obat()
    {
        return $this->hasOne(ExpObat::class, 'obat_id', 'id')->withDefault([
            'data' => '-',
        ]);
    }

    public function in_obat()
    {
        return $this->hasOne(InObat::class, 'obat_id', 'id')
            ->selectRaw('obat_id, SUM(jumlah_in) as total_jumlah_in')
            ->groupBy('obat_id')
            ->withDefault([
                'total_jumlah_in' => 0,
            ]);
    }

    public function out_obat()
    {
        return $this->hasOne(OutObat::class, 'obat_id', 'id')
            ->selectRaw('obat_id, SUM(jumlah_out) as total_jumlah_out')
            ->groupBy('obat_id')
            ->withDefault([
                'total_jumlah_out' => 0,
            ]);
    }

}
