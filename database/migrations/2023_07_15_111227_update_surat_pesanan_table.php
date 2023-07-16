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
        Schema::table('surat_pesanan', function (Blueprint $table) {
            // Tambahkan kolom kode_pesanan sebagai foreign key
            $table->string('kode_pesanan')->after('id');
            // Tambahkan kolom supplier_id sebagai foreign key
            $table->unsignedBigInteger('supplier_id')->after('kode_pesanan');
            // Hapus kolom nama_perusahaan
            $table->dropColumn('nama_perusahaan');
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
