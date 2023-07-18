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
            $table->string('bukti')->nullable();
            $table->string('bukti_origin')->nullable();
            $table->string('bukti_path')->nullable();
            $table->string('bukti_type', 20)->nullable();
            $table->integer('bukti_size')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('faktur', function (Blueprint $table) {
            $table->dropColumn('bukti');
            $table->dropColumn('bukti_origin');
            $table->dropColumn('bukti_path');
            $table->dropColumn('bukti_type');
            $table->dropColumn('bukti_size');
        });
    }
};
