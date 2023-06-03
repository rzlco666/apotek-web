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
            $table->dropColumn('jumlah_out');
            $table->dropForeign(['obat_id']);
            $table->dropColumn('obat_id');
            $table->json('obat')->nullable()->after('tanggal_pesanan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('surat_pesanan', function (Blueprint $table) {
            $table->dropColumn('obat');
            $table->bigInteger('jumlah_out');
            $table->unsignedBigInteger('obat_id')->after('tanggal_pesanan');
            $table->foreign('obat_id')->references('id')->on('obat');
        });
    }
};
