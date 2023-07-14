<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('obat', function (Blueprint $table) {
            // Tambahkan kolom satuan_id sebagai foreign key
            $table->unsignedBigInteger('satuan_id')->after('kategori_obat_id');
            // Tambahkan kolom golongan_id sebagai foreign key
            $table->unsignedBigInteger('golongan_id')->after('satuan_id');
            // Hapus kolom satuan dan golongan
            $table->dropColumn('satuan');
            $table->dropColumn('golongan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
