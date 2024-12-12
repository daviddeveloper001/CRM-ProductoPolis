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
        Schema::table('segment_registers', function (Blueprint $table) {

            $table->dropColumn('sale_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('segment_registers', function (Blueprint $table) {

            $table->foreign('sale_id')->references('id')->on('sales')->onDelete('cascade');
        });
    }
};
