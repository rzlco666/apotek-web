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
        Schema::create('surat_pesanan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_perusahaan');
            $table->date('tanggal_pesanan');
            $table->bigInteger('jumlah_out');
            $table->unsignedBigInteger('obat_id');
            $table->foreign('obat_id')->references('id')->on('obat');
            $table->bigInteger('created_by')->nullable();
            $table->bigInteger('updated_by')->nullable();
            $table->bigInteger('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_pesanan');
    }
};
