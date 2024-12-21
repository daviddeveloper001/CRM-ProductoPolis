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
        Schema::table('segments', function (Blueprint $table) {
            $table->dropForeign(['block_id']); // Volver a agregar la clave foránea con eliminación en cascada 
            $table->foreign('block_id')->references('id')->on('blocks')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('segments', function (Blueprint $table) {
            $table->dropForeign(['block_id']); // Volver a agregar la clave foránea sin eliminación en cascada 
            $table->foreign('block_id')->references('id')->on('blocks');
        });
    }
};
