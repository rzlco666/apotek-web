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
        Schema::table('faktur', function (Blueprint $table) {
            $table->dropForeign(['obat_id']);
            $table->dropColumn('obat_id');
            $table->json('obat')->nullable()->after('tanggal_faktur');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('faktur', function (Blueprint $table) {
            $table->unsignedBigInteger('obat_id')->nullable()->after('tanggal_faktur');
            $table->dropColumn('obat');
            $table->foreign('obat_id')->references('id')->on('obat');
        });
    }
};
